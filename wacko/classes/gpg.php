<?php

if (!defined('IN_WACKO'))
{
	exit('No direct script access allowed');
}

// WackoWiki-GPG INTEGRATION CLASS

// ToDo:
//	nothing currently

/*

########################################################
##          WackoWiki-GPG integration class           ##
########################################################

	NOTE: PHP 5.1.2 and GnuPG 1.4 or later required!

*/

class GPG
{
	// VARIABLES
	var $engine;
	var $UID		= null;		// pubkey user ID
	var $key_id		= null;		// pubkey ID
	var $finger		= null;		// pubkey fingerprint
	var $secret		= '';		// secret protection value
	var $context	= '';		// keyring context
	var $override	= '';		// override global command line and config parameters
	var $baseurl;				// server ip with a proper protocol
	var $homedir;				// gpg homedir
	var $tempdir;				// temporary data dir
	var $sessdir;				// user session dir
	var $stfile;				// gpg status file
	var $srfile;				// gpg stderr file

	// CONSTRUCTOR
	function __construct(&$engine)
	{
		// defining main object properties
		$this->engine	= & $engine;
		$this->secret	= hash('sha1', $this->engine->config['system_seed'].'GPG_SECRET');
		$this->baseurl	= "http://{$_SERVER['SERVER_NAME']}/";
		$this->homedir	= rtrim($this->engine->config['gpg_home'], '/');
		$this->tempdir	= rtrim($this->engine->config['gpg_temp'], '/');
		$this->wrapper	= trim($this->engine->config['gpg_wrapper'], '/');
		$this->sessdir	= $this->tempdir.'/'.session_id();
		$this->stfile	= $this->sessdir.'/'.GPG_STATUS_NAME;
		$this->srfile	= $this->sessdir.'/'.GPG_STDERR_NAME;

		// creating user session directory
		if (false === mkdir($this->sessdir))
		{
			die('WackoWiki-GPG: unable to create user session directory.');
		}
		else
		{
			// creating session files and setting appropriate privileges
			$file = @fopen($this->stfile, 'w');		@fclose($file);
			$file = @fopen($this->srfile, 'w');		@fclose($file);
			chmod($this->sessdir, 0777);
			chmod($this->stfile, 0777);
			chmod($this->srfile, 0777);
		}
	}

	########################################################
	##                   Common functions                 ##
	########################################################

	// call wackowiki-gpg wrapper: executes gpg with passed
	// command line parameters and returns STDOUT. status codes
	// and STDERR are written into the out files and can be
	// processed later.
	//	$request	- additional gpg command line parameters
	//				  (except homedir and status-file)
	//	$method		- passing method: post or get (default)
	//	$input		- any data that is needed to be passed to
	//				  gpg in STDIN for processing (with
	//				  $method = 'post' only)
	function call($request, $method = 'get', $input = '')
	{
		// defining http method
		if ($method != 'get' && $method != 'post') $method = 'get';

		// preparing stdin data
		if ($method != 'post')
		{
			$input = '';
		}
		else
		{
			$input = base64_encode($input);
		}

		// preparing http request
		$request = array(
			'http' => array(
				'method'	=> $method,
				'header'	=> ( $method == 'post' ? 'Content-type: application/x-www-form-urlencoded' : '' ),
				'content'	=> http_build_query(array(
					'pv' => $this->secret,		// protection value
					'hd' => $this->homedir,		// homedir
					'sf' => $this->stfile,		// status-file
					'sr' => $this->srfile,		// stderr
					'cl' => $this->override.' '.$request,	// command line params
					'st' => $input)				// stdin data
				) // end of content array
			) // end of http array
		); // end of request array

		$context	= stream_context_create($request);
		$script		= fopen("{$this->baseurl}{$this->wrapper}", 'r', false, $context);

		if (!$script)
		{
			die('WackoWiki-GPG: unable to open CGI wrapper.');
		}
		else
		{
			// reading output till the end
			while (false === feof($script))
			{
				$result .= fgets($script, 1024);
			}

			fclose($script);

			// here is what gpg has returned
			return str_replace("\r", '', trim($result));
		}
	}

	// sanitize user input string and prepare it for
	// use in gpg command line variables. we don't want
	// to allow arbitrary commands execution, right?
	function prepare_input($str, $len = 255)
	{
		if (!$str = trim(html_entity_decode($str), ' -')) return '';
		else if (strpos($str, "\n")) return '';
		else if ($sp = strpos($str, ' ')) $str = substr($str, 0, $sp);

		return substr($str, 0, $len);
	}

	// define keyring context. empty value means default keyring.
	// special 'temp' value means temporary ring being cleared
	// out by the object destructor. anything else is a keyring
	// filename under gpg_home dir (be careful not to point out
	// to any existing file)
	function set_context($new = '')
	{
		if		($new == '')		return $this->context = '';
		else if	($new == 'temp')	return $this->context = "--no-default-keyring --keyring {$this->sessdir}/".GPG_TEMP_RING_NAME;
		else						return $this->context = "--no-default-keyring --keyring {$this->homedir}/".$new;
	}

	// generate an unique challenge token C as follows:
	//	C = T,P,H(S,U,T,P)
	// where T - unix timestamp, P - procedure ID (see below),
	// S - system secret value, U - user session ID. because
	// we use SID value in MAC calculation, an attacker wishing
	// to replay signed user token needs to somehow intercept
	// a whole user session (not only session vars) and present
	// it along with the other HTTP-POST data. this always poses
	// some risk, so we are putting timestamp in, too (this
	// measure narrows potential vulnerability to replay attack
	// to a more restricted window: see $expiry argument of the
	// next method).
	//
	// $procedure specifies exact operation where challenge-
	// response protocol is utilised. this needs to be some
	// simple identification string. currently defined are:
	//	'upload_pk'		- uploading a key into the user profile
	//	'delete_pk'		- removing a key from the profile
	//	'changepwd'		- changing password for logged in user
	//	'changemail'	- changing email address
	function create_token($procedure)
	{
		$time = time();
		// in the clear part we use value separator for better
		// handling in the token validation method (see below).
		// hash context goes as single concatenated string
		return $token = "$time|$procedure\n".hash('sha1', $this->engine->config['system_seed'].session_id().$time.$procedure);
	}

	// check whether challenge token is correct and did not
	// expired ($expiry argument in minutes). expiration
	// parameter is used to prevent replay attacks in case
	// user session still didn't expired or an attacker has
	// managed to intercept user session.
	// NB: $token must be passed in the same form as it was
	// produced by create_token() method (e.g. without any pgp
	// boilerplates). signature verification is beyond the
	// scope of this function
	function validate_token($token, $procedure, $expiry = 5)
	{
		// parsing passed token, checking proper syntax
		if (is_array($strings = explode("\n", $token)))
		{
			list($token_time, $token_proc) = explode('|', $strings[0]);
			$token_mac = $strings[1];

			// something's wrong with the input
			if (!$token_time || !$token_proc || !$token_mac)
			{
				return false;
			}
		}
		else
		{
			return false;
		}

		// recalculating MAC
		$new_mac = hash('sha1', $this->engine->config['system_seed'].session_id().$token_time.$token_proc);

		// validating conditions. exact order is crucial!
		if ($token_mac !== $new_mac)
		{
			// MAC mismatch
			return false;
		}
		else if ($token_proc !== $procedure)
		{
			// procedure mismatch
			return false;
		}
		else if (time() > ($expiry * 60 + $token_time))
		{
			// token expired
			return false;
		}
		else
		{
			return true;
		}
	}

	// get gpg status codes of the last operation. returns
	// multidimensional array with [GNUPG:] string thrown out
	function get_status()
	{
		$statusfile = @fopen($this->stfile, 'r');

		// read status file
		if (!$statusfile)
		{
			return false;
		}
		else
		{
			while (false === feof($statusfile))
			{
				$statuscodes .= fread($statusfile, 1024);
			}

			fclose($statusfile);
		}

		if ($statuscodes)
		{
			$len	= strlen(GPG_STATUS_LINE);
			$rows	= explode("\n", str_replace("\r", '', $statuscodes));

			foreach ($rows as $row)
			{
				if (substr($row, 0, $len) == GPG_STATUS_LINE)
				{
					$matrix[] = explode(' ', substr($row, $len));
				}
			}

			return $matrix;
		}
		else
		{
			return false;
		}
	}

	// in debug mode returns gpg STDERR contents (stub string
	// otherwise) of false if no gpg error
	function get_error()
	{
		$errorfile = @fopen($this->srfile, 'r');

		// read status file
		if (!$errorfile)
		{
			return false;
		}
		else
		{
			while (false === feof($errorfile))
			{
				$errorcodes .= fread($errorfile, 1024);
			}

			fclose($errorfile);
		}

		if ($errorcodes)
		{
			if ($this->engine->config['gpg_debug'] == true)
			{
				return nl2br("WackoWiki-GPG terminated, error output follows:\n------\n".
				str_replace("\r", '', $errorcodes));
			}
			else
			{
				return GPG_GENERAL_ERROR;
			}
		}
		else
		{
			return false;
		}
	}

	// get parseable key details listing. returns multidimensional
	// array with 'tru' (trustdb) values excepted (empty array if
	// selected key is absent).
	function get_list($key_id = '')
	{
		$key_id = $this->prepare_input($key_id, 42);

		if (!$key_id) $key_id = '0x'.$this->finger;
		if (!$key_id) $key_id = $this->key_id;
		if (!$key_id) return false;

		if ($list = $this->call("{$this->context} --list-public-keys $key_id"))
		{
			$rows = explode("\n", $list);

			foreach ($rows as $row)
			{
				if ($row && substr($row, 0, 3) != 'tru')
				{
					$matrix[] = explode(':', $row);
				}
			}

			return $matrix;
		}
		else
		{
			return false;
		}
	}

	// define pubkey-related object properties from gpg status
	// codes ('status') or key listing ('list').
	// $key_id is required only for $source = 'list'
	function define_key($source, $key_id = '')
	{
		if ($source == 'status')
		{
			if (false === $status = $this->get_status())
			{
				return false;
			}
			else foreach ($status as $code)
			{
				if ($code[0] == 'IMPORTED')
				{
					$this->key_id = $code[1];
					// recompose primary user ID into a single string
					$temp = $code;
					unset($temp[0], $temp[1]);
					$this->UID = implode(' ', $temp);
				}
				else if ($code[0] == 'IMPORT_OK')
				{
					$this->key_id	= '0x'.substr($code[2], -16);
					$this->finger	= $code[2];
				}
			}
			return true;
		}
		else if ($source == 'list')
		{
			if (false === $list = $this->get_list($key_id))
			{
				return false;
			}
			else foreach ($list as $row)
			{
				if ($row[0] == 'pub')
				{
					$this->key_id = '0x'.$row[4];
				}
				else if ($row[0] == 'fpr')
				{
					$this->finger = $row[9];
				}
				else if ($row[0] == 'uid' && !$definedUID)
				{
					$this->UID	= str_replace('\x3a', ':', $row[9]);
					$definedUID	= true;
				}
			}

			return true;
		}
	}

	########################################################
	##                  Special functions                 ##
	########################################################

	// check gpg operation and version number. returns one of
	// these error code values:
	//	0 - everything's okay
	//	1 - no output from the cgi backend
	//	2 - no gpg version string returned
	//	3 - gpg detected but of an older version than is required
	function self_check()
	{
		if ($gpg = $this->call('--list-config'))
		{
			$gpg = explode("\n", $gpg);

			// no gpg version string in the wrapper output
			if (is_array($gpg) === false || false === is_array($sub = explode(':', $gpg[0])))
			{
				 return 2;
			}
			else
			{
				if ($sub[0] == 'cfg' && $sub[1] == 'version')
				{
					// version number requirement is not met
					if ($sub[2] < GPG_VERSION_MIN)
					{
						return 3;
					}
				}
				else
				{
					return 2;
				}
			}
		}
		else
		{
			// no output from the backend wrapper
			return 1;
		}
		// everything's okay
		return 0;
	}

	// make sure an imported key is suitable for encryption.
	// checks the following conditions are met:
	//	- at least one encryption subkey is present, not expired,
	//	  and not revoked
	//	- base key is not expired, and not revoked
	// returns these error code values:
	//	0 - everything's okey
	//	1 - not suitable for encryption (encryption subkey is
	//	    absent, expired or revoked)
	//	2 - pubkey is unusable (expired or revoked)
	//	3 - no key found in get_list() output
	function check_pk($key_id)
	{
		$pubkey = false;
		$subkey = false;

		if (false == $list = $this->get_list($key_id))
		{
			// no key found
			return 3;
		}
		else foreach ($list as $row)
		{
			// check for base key usability
			if ($row[0] == 'pub')
			{
				if ( ($row[1] != 'r' && $row[1] != 'e') &&					// check for revocation/expiry status
				($row[5] < time() && ($row[6] == '' || $row[6] > time())) )	// check creation and expiration dates
				{
					$pubkey = true;
				}
			}
			// check for subkey presence and usability
			else if ($row[0] == 'sub')
			{
				if ( ($row[1] != 'r' && $row[1] != 'e') &&					// check for revocation/expiry status
				(strpos($row[11], 'e') !== false) &&						// check that subkey is intended for encryption
				($row[5] < time() && ($row[6] == '' || $row[6] > time())) )	// check creation and expiration dates
				{
					$subkey = true;
				}
			}
		}

		// return codes
		if ($pubkey === false) return 2;	// public key is unusable
		if ($subkey === false) return 1;	// key is not suitable for encryption
		// key is okay
		return 0;
	}

	// import key onto the temp keyring through webform for
	// later processing. be warned that imported key must
	// be processed in the current cycle before object destructor
	// cleans things up
	function upload_pk($keyblock)
	{
		// import key
		$_context = $this->context;
		$this->call($this->set_context('temp')." --import", 'post', $keyblock);
		$this->context = $_context;

		if (false === $error = $this->get_error())
		{
			return true;
		}
		else
		{
			die($error);
		}
	}

	// download selected key from the public keyserver. keyserver
	// name may be passed along the key ID. returns one of the
	// following:
	//	true	- defined key (and defined key *only*) was
	// 			  downloaded successfully.
	//	false	- defined key wasn't found on server.
	//	array()	- indexed array (if more than one key was
	//			  found; of no use currently :-(
	//			[0] - username
	//			[1] - fingerprint
	function recieve_pk($key_id, $keyserver = '')
	{
		// sanitizing user input
		if (!$keyserver = $this->prepare_input($keyserver))
		{
			$keyserver = $this->engine->config['gpg_server'];
		}

		$key_id = $this->prepare_input($key_id, 42);

		// requesting key from the keyserver
		$_context = $this->context;
		$this->call($this->set_context('temp')." --keyserver $keyserver --recv-key $key_id");
		$this->context = $_context;

		// loading gpg status codes
		if (false === $status = $this->get_status())
		{
			return false;
		}
		else foreach ($status as $index => $code)
		{
			if ($status[$index][0] == 'IMPORTED')
			{
				$i++;

				// defining first output array element: UID
				$temp = $code;
				unset($temp[0], $temp[1]);
				$output[$i][0] = implode(' ', $temp);

				// defining second output array element: fingerprint.
				// however in case of import error we need to clear
				// output set in the current cycle.
				if ($status[$index + 1][0] == 'IMPORT_OK')
				{
					$output[$i][1] = $status[$index + 1][2];
				}
				else
				{
					unset($output[$i--]);
				}
			}
			else if ($status[$index][0] == 'IMPORT_RES')
			{
				// check how many keys was imported to determine
				// function's resulting output
				if		((int)$status[$index][1] === 0)	$result = false;
				else if	((int)$status[$index][1] === 1)	$result = true;
				else if	((int)$status[$index][1]  >  1)	$result = $output;
			}
		}

		return $result;
	}

	// move selected key from a temp keyring to the main keyring.
	// $key_id variable is necessary to not allow passing of multiple
	// uploaded keys
	function accept_pk($key_id)
	{
		$_context		= $this->context;
		$key_id			= $this->prepare_input($key_id, 42);
		$pack			= $this->call($this->set_context('temp')." --export $key_id");
		$this->context	= $_context;
		$this->call("{$this->context} --import", 'post', $pack);

		if (false === $error = $this->get_error())
		{
			return true;
		}
		else
		{
			die($error);
		}
	}

	// remove selected public key from the main keyring.
	// in order to avoid ambiguity passing key fingerprint
	// is needed.
	function delete_pk($fingerprint)
	{
		if (strlen($fingerprint = $this->prepare_input($fingerprint, 42)) < 42)
		{
			return false;
		}

		$this->call("{$this->context} --delete-key $fingerprint");

		if (false === $error = $this->get_error())
		{
			return true;
		}
		else
		{
			die($error);
		}
	}

	// extract selected public key from the keyring
	function get_pk($key_id)
	{
		$key_id	= $this->prepare_input($key_id, 42);
		$key	= $this->call("{$this->context} --export $key_id");

		if (false === $error = $this->get_error())
		{
			return $key;
		}
		else
		{
			die($error);
		}
	}

	// encrypt passed plaintext data with selected public key
	function encrypt_msg($plaintext, $key_id)
	{
		$key_id		= $this->prepare_input($key_id, 42);
		$ciphertext	= $this->call("{$this->context} --recipient $key_id --encrypt", 'post', $plaintext);

		if (false === $error = $this->get_error())
		{
			return $ciphertext;
		}
		else
		{
			die($error);
		}
	}

	// verify passed data. returns indexed array with the following elements:
	//	[0] - status: true, false or null (in case of error)
	//	[1] - primary key FPR
	//	[2] - signature creation unix timestamp
	//	[3] - signature ID
	//	[4] - signed message body
	//	[5] - additional status:
	//			0 = not relevant
	//			1 = expired key
	//			2 = expired signature
	//			3 = revoked key
	// elements [1]-[3] may be null if input error encountered
	function verify_msg($data)
	{
		// we are using '-v' specifically to catch clear message
		// after signature verification is complete
		$body = $this->call("{$this->context} -v -d", 'post', $data);

		$results = array(
			false,	// [0]
			null,	// [1]
			null,	// [2]
			null,	// [3]
			$body,	// [4], always defined
			0,		// [5]
		);

		// checking status codes of the verification operation
		if (false === $status = $this->get_status())
		{
			// something's wrong, aborting
			$results[0] = null;
			return $results;
		}
		else foreach ($status as $code)
		{
			if ($code[0] == 'VALIDSIG')
			{
				// defining output elements for good sig
				$results[0] = true;
				$results[1] = $code[10];
				$results[2] = $code[3];
			}
			else if ($code[0] == 'BADSIG')
			{
				// in case of bad signature we return
				// long key_id, not a full FPR!
				$results[1] = $code[1];
			}
			else if ($code[0] == 'ERRSIG')
			{
				// signature verification error (no pubkey?).
				// only long key_id is returned!
				$results[0] = null;
				$results[1] = $code[1];
				$results[2] = $code[5];
			}
			else if ($code[0] == 'EXPKEYSIG')
			{
				// signature with expired key
				$results[5] = 1;
			}
			else if ($code[0] == 'EXPSIG')
			{
				// signature itself is expired
				$results[5] = 2;
			}
			else if ($code[0] == 'REVKEYSIG')
			{
				// signing key is revoked
				$results[5] = 3;
			}
			else if ($code[0] == 'SIG_ID')
			{
				// defining remaining output element: sigID
				// (if applicable)
				$results[3] = $code[1];
			}
			else if ($code[0] == 'ERROR' || $code[0] == 'NODATA')
			{
				// input error encountered, aborting
				$results[0] = null;
				return $results;
			}
		}

		return $results;
	}

	// print packets listing for the given data
	// which may be passed as a plain text or a
	// binary object
	function decode_packets($data)
	{
		return $this->call('--list-packets', 'post', $data);
	}

	// send the given key to the keyserver
	function send_pk($key_id, $keyserver = '')
	{
		// defining keyserver
		if (!$keyserver)
		{
			$keyserver = $this->engine->config['gpg_server'];
		}
		else
		{
			$keyserver = $this->prepare_input($keyserver);
		}

		$key_id = $this->prepare_input($key_id, 42);
		$this->call("{$this->context} --keyserver $keyserver --send-keys $key_id");
		return true;
	}

	// search $string on a public $keyserver.
	// returns associative array with key_ids as keys
	// and indexed arrays as values. subarrays' values
	// are as follows:
	//	[0] - (str) primary key type
	//	[1] - (int) key length
	//	[2] - (int) key creation timestamp
	//	[3] - (str) status:
	//			'r' - revoked
	//	[4] - (array):
	//			(str) UID => (int) UID creation timestamp
	function search_pk($string, $keyserver = '')
	{
		// matches limit
		$max = 50;

		// defining keyserver
		if (!$keyserver = $this->prepare_input($keyserver))
		{
			$keyserver = $this->engine->config['gpg_server'];
		}

		// correcting search string
		if (substr($string = trim($string), 0, 2) == '0x')
		{
			$string = '='.$string;
		}

		// requesting key search
		if ($list = $this->call("--keyserver $keyserver --search-key $string"))
		{
			$n = 0;
			$results = array();

			// filling results array
			if ($rows = explode("\n", $list)) foreach ($rows as $row)
			{
				$cells = explode(':', $row);

				// new pubkey element
				if ($cells[0] == 'pub')
				{
					if (++$n > $max) break;		// break flooding searches

					switch ($cells[2])
					{
						case '1':	$type = 'RSA';		break;
						case '3':	$type = 'RSA-S';	break;
						case '17':	$type = 'DSA';		break;
						default:	$type = 'Undefined';
					}

					$results[$key_id = $cells[1]] = array(
						0 => $type,
						1 => (int)$cells[3],
						2 => (int)$cells[4],
						3 => trim($cells[6]),
						4 => array()
					);
				}
				// uid for the current pubkey element
				else if ($cells[0] == 'uid')
				{
					$results[$key_id][4][$cells[1]] = (int)$cells[2];
				}
			}
			return $results;
		}
		else
		{
			return false;
		}
	}

	// DESTRUCTOR
	function __destruct()
	{
		// flush session dir in the end of script execution
		if ($dh = opendir($this->sessdir))
		{
			while (false !== ($filename = readdir($dh)))
			{
				if (is_dir($file = $this->sessdir.'/'.$filename) !== true)
				{
					unlink($file);
				}
			}

			closedir($dh);
			rmdir($this->sessdir);
		}
	}
}

?>