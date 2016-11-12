<?php
/*

Typografica library: paragrafica class.

---------

Copyright (c) 2004, Kuso Mendokusee <mailto:mendokusee@yandex.ru>
All rights reserved.

*/

class paragrafica
{
	var $ignore			= "/(<!--notypo-->.*?<!--\/notypo-->)/si"; // regex to be ignored
	// paragpaph is a chicken-feed like this: <t->text, text, just text<-t>
	var $wacko;
	var $t0 			= [ // terminators like <-t>$1<t->
		"/(<br[^>]*>)(\s*<br[^>]*>)+/si",
		"/(<hr[^>]*>)/si",
	];
	var $t1				= [ // terminators like <-t>$1
		[ // rightinators
			"!(<table)!si",
			"!(<h[1-9][^>]*>)!si",
			"!(<dl)!si",
			"!(<(u|o)l)!si",
			"!(<div)!si",
			"!(<nav)!si",
			"!(<aside)!si",
			"!(<section)!si",
			"!(<article)!si",
			"!(<footer)!si",
			"!(<header)!si",
			"!(<address)!si",
			"!(<figure)!si",
			"!(<figcaption)!si",
			"!(<p)!si",
			"!(<form)!si",
			"!(<textarea)!si",
			"!(<blockquote)!si",
		],
		[ // wronginators
			"!(</td>)!si",
		],
		[ // wronginators-2
			"!(</li>)!si",
		],
		[ // wronginators-3
			"!(</pre>)!si",
		],
	];
	var $t2				= [ // terminators like $1<t->
		[ // rightinators
			"!(</table>)!si",
			"!(</h[1-9]>)!si",
			"!(</dl>)!si",
			"!(</(u|o)l>)!si",
			"!(</div>)!si",
			"!(</nav>)!si",
			"!(</aside>)!si",
			"!(</section>)!si",
			"!(</article>)!si",
			"!(</footer>)!si",
			"!(</header>)!si",
			"!(</address>)!si",
			"!(</figure>)!si",
			"!(</figcaption>)!si",
			"!(</p>)!si",
			"!(</form>)!si",
			"!(</textarea>)!si",
			"!(</blockquote>)!si",
		],
		[ // wronginators
			"!(<td[^>]*>)!si",
		],
		[ // wronginators-2
			"!(<li[^>]*>)!is",
		],
		[ // wronginators-3
			"!(<pre[^>]*>)!is",
		],
	];

	var $mark_prefix	= '{:typo:markup:1:}';
	var $mark1			= '{:typo:markup:1:}<:-t>'; // <-t>
	var $mark2			= '{:typo:markup:1:}<:t->'; // <t->
	var $mark3			= '{:typo:markup:1:}<:::>'; // (*) wronginator mark:

	// within constructions like <t->(*).....<-t>
	// & vice versa -- paragraphs should be placed
	// but within <t->(*)....(*)<-t> -- shouldn't
	var $mark4			= '{:typo:markup:1:}<:-:>'; // (!) ultimate wronginator mark:
	// paragraphs shouldn't be placed regardless to <t->(!).....<-t>

	var $prefix1		= '<p class="auto" id="p';
	var $prefix2		= '">';
	var $postfix		= '</p>';

	function __construct( &$wacko )
	{
		$this->wacko = &$wacko;
	}

	function correct( $what )
	{
		// -2. ignoring a regexp (or ignoring next regexp)
		$ignored = [];
		{
			$total	= preg_match_all($this->ignore, $what, $matches);
			$what	= preg_replace($this->ignore, '{:typo:markup:3:}', $what);

			for ($i = 0; $i < $total; $i++)
			{
				$ignored[] = $matches[0][$i];
			}
		}

		// -1. remove t-prefix;
		$what = str_replace( $this->mark_prefix, '', $what );

		if (isset($this->wacko->data))
		{
			if (is_array($this->wacko->data) && isset($this->wacko->data['record_id']))
			{
				$page_id = $this->wacko->data['record_id'];
			}
		}
		else
		{
			$page_id = substr(crc32(time()), 0, 5);
		}

		// 1. insert terminators appropriately
		foreach ($this->t0 as $t)
		{
			$what = preg_replace( $t, $this->mark1.'$1' . $this->mark2, $what );
		}

		foreach ($this->t1[0] as $t)
		{
			$what = preg_replace( $t, $this->mark1.'$1', $what );
		}

		foreach ($this->t2[0] as $t)
		{
			$what = preg_replace( $t, '$1' . $this->mark2, $what );
		}

		foreach ($this->t1[1] as $t)
		{
			$what = preg_replace( $t, $this->mark3.$this->mark1.'$1', $what );
		}

		foreach ($this->t2[1] as $t)
		{
			$what = preg_replace( $t, '$1' . $this->mark2.$this->mark3, $what );
		}

		foreach ($this->t1[2] as $t)
		{
			$what = preg_replace( $t, $this->mark4.$this->mark1.'$1', $what );
		}

		foreach ($this->t2[2] as $t)
		{
			$what = preg_replace( $t, '$1' . $this->mark2.$this->mark4, $what );
		}

		// wrap whole text in terminator pair
		$what = $this->mark2.$what.$this->mark1;

		// 2bis. swap <t-><br /> -> <br /><t->
		$what = preg_replace( "!(" . $this->mark2.")((\s*<br[^>]*>)+)!si", '$2$1', $what );
		// noneedin: > eliminating multiple breaks
		$what = preg_replace( "!((<br[^>]*>\s*)+)(" . $this->mark1.")!s", '$3', $what );

		// 2. cleanup <t->\s<-t>
		do
		{
			$_w		= $what;
			$what	= preg_replace( "!(" . $this->mark2.")((\s|(<br[^>]*>|" . $this->mark3."|" . $this->mark4."))*)(" . $this->mark1.")!si", '$2', $what );
		}

		while ($_w != $what);

		// 3. replace each <t->....<-t> to <p class="auto">...</p>
		$pcount = 0;
		$pieces = explode( $this->mark2, $what );

		if (isset($mark1))
		{
			$sizeof_mark1 = sizeof($mark1);
		}
		else
		{
			$sizeof_mark1 = null;
		}

		foreach ($pieces as $k => $v)
		{
			if ($k > 0)
			{
				$pos	= strpos($v, $this->mark1);
				$pos2	= strpos($v, $this->mark3);
				$pos_u	= strpos($v, $this->mark4);

				if (($pos !== false) && ($pos_u === false))
				{
					$insert_p = false;

					if ($pos2 === false)
					{
						$insert_p = true;
					}
					else
					{
						$pieces_inside = explode( $this->mark3, $v );

						if (sizeof($pieces_inside) < 3)
						{
							$insert_p = true;
						}
					}

					if ($insert_p)
					{
						$inside = substr($v, 0, $pos);
						$inside = str_replace( $this->mark3, '', $inside );

						if (strlen($inside))
						{
							$pcount++;
							$pieces[$k] = $this->prefix1.
										  $page_id.'-' . $pcount.
										  $this->prefix2.
										  $inside.
										  $this->postfix.substr($v, $pos + $sizeof_mark1);
						}
					}
				}
			}
		}

		$what = implode('', $pieces);
		// 4. remove unused <t-> & <-t>
		$what = str_replace( $this->mark1, '', $what );
		$what = str_replace( $this->mark2, '', $what );
		$what = str_replace( $this->mark3, '', $what );
		$what = str_replace( $this->mark4, '', $what );
		// -. done with P

		// INFINITY-2. inserting a (or next?) ignored regexp
		{
			$what .= ' ';
			$a = explode( '{:typo:markup:3:}', $what );

			if ($a)
			{
				$what = $a[0];
				$size = count($a);

				for ($i = 1; $i < $size; $i++)
				{
					$what = $what.$ignored[$i - 1].$a[$i];
				}
			}
		}

		// ==================================================================
		// Forming body_toc
		//  * in wacko formatter we have done "#h1249_1"
		//  * right here we have done         "#p1249_1"
		// 1. get all ^^ of this
		$this->toc = [];
		$what = preg_replace_callback( '!'.
				"(<h([0-9]) id=\"(h[0-9]+-[0-9]+)\">(.*?)</h\\2>)".		// 2=depth, 3=id, 4=name
									"|".
				"(<p class=\"auto\" id=\"(p[0-9]+-[0-9]+)\">)".			// 6=id
									"|".
				"<\!--action:begin-->include\s+[^=]+=([^\ ]+)(\s+notoc=\"?[^0]\"?)?.*?<\!--action:end-->".
				// {{include page="TAG" notoc=1}}
				"!i", [&$this, 'add_toc_entry'], $what );

		return $what;
	}

	// for further TOC creation routines
	function add_toc_entry($matches)
	{
		if (!isset($matches[6])) $matches[6] = '';
		if (!isset($matches[8])) $matches[8] = '';

		if ((isset($matches[7])) && $matches[7] != '')
		{
			if ($matches[8] == '')
			{
				$this->toc[] = [$this->wacko->unwrap_link(trim($matches[7], '"')), '(include)', 99999];
			}
		}
		else
		{
			// id, text, depth
			if ($matches[6] != '')
			{
				$this->toc[] = [$matches[6], '(p)', 77777];
			}
			else
			{
				$this->toc[] = [$matches[3], $matches[4], $matches[2]];
			}
		}

		return $matches[0];
	}
}

?>
