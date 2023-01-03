<?php

/*

Typografica library: Paragrafica class.

https://wackowiki.org/doc/Dev/Projects/Typografica

*/

class Paragrafica
{
	public string $ignore		= '/(<!--notypo-->.*?<!--\/notypo-->)/usi'; // regex to be ignored
	// paragpaph is a chicken-feed like this: <t->text, text, just text<-t>
	public $wacko;
	public array $toc;
	public array $t0 			= [ // terminators like <-t>$1<t->
		'/(<br[^>]*>)(\s*<br[^>]*>)+/usi',
		'/(<hr[^>]*>)/usi',
	];
	public array $t1			= [ // terminators like <-t>$1
		[
			// rightinators
			'!(<(o|u)l)!si',
			'!(<address)!si',
			'!(<article)!si',
			'!(<aside)!si',
			'!(<blockquote)!si',
			'!(<details)!si',
			'!(<div)!si',
			'!(<dl)!si',
			'!(<fieldset)!si',
			'!(<figcaption)!si',
			'!(<figure)!si',
			'!(<footer)!si',
			'!(<form)!si',
			'!(<h[1-9][^>]*>)!si',
			'!(<header)!si',
			'!(<hgroup)!si',
			'!(<hr)!si',
			'!(<ignore>)!si',
			'!(<menu)!si',
			'!(<nav)!si',
			'!(<p)!si',
			'!(<pre)!si',
			'!(<section)!si',
			'!(<table)!si',
			'!(<textarea)!si',
		],
		[
			// wronginators
			'!(</td>)!si',
		],
		[
			// wronginators-2
			'!(</dd>)!si',
			'!(</dt>)!si',
			'!(</li>)!si',
		],
	];
	public array $t2			= [ // terminators like $1<t->
		[
			// rightinators
			'!(</(o|u)l>)!si',
			'!(</address>)!si',
			'!(</article>)!si',
			'!(</aside>)!si',
			'!(</blockquote>)!si',
			'!(</details>)!si',
			'!(</div>)!si',
			'!(</dl>)!si',
			'!(</fieldset>)!si',
			'!(</figcaption>)!si',
			'!(</figure>)!si',
			'!(</footer>)!si',
			'!(</form>)!si',
			'!(</h[1-9]>)!si',
			'!(</header>)!si',
			'!(</hgroup>)!si',
			'!(</hr>)!si',
			'!(</ignore>)!si',
			'!(</menu>)!si',
			'!(</nav>)!si',
			'!(</p>)!si',
			'!(</pre>)!si',
			'!(</section>)!si',
			'!(</table>)!si',
			'!(</textarea>)!si',
		],
		[
			// wronginators
			'!(<td[^>]*>)!si',
		],
		[
			// wronginators-2
			'!(<dd[^>]*>)!si',
			'!(<dt[^>]*>)!si',
			'!(<li[^>]*>)!si',
		],
	];

	public string $mark_prefix	= '{:typo:markup:1:}';
	public string $mark1		= '{:typo:markup:1:}<:-t>'; // <-t>
	public string $mark2		= '{:typo:markup:1:}<:t->'; // <t->
	public string $mark3		= '{:typo:markup:1:}<:::>'; // (*) wronginator mark:

	// within constructions like <t->(*).....<-t>
	// & vice versa -- paragraphs should be placed
	// but within <t->(*)....(*)<-t> -- shouldn't
	public string $mark4		= '{:typo:markup:1:}<:-:>'; // (!) ultimate wronginator mark:
	// paragraphs shouldn't be placed regardless to <t->(!).....<-t>

	public string $prefix1		= '<p id="p';
	public string $prefix2		= '" class="auto">';
	public string $postfix		= '</p>' . "\n";

	function __construct(&$wacko)
	{
		$this->wacko = &$wacko;
	}

	function correct($what)
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
		$what = str_replace($this->mark_prefix, '', $what);

		if (isset($this->wacko->page['page_id']))
		{
			$page_id = $this->wacko->page['page_id'];
		}
		else
		{
			$page_id = substr((string) hash('crc32', (string) time()), 0, 5);
		}

		// 1. insert terminators appropriately
		foreach ($this->t0 as $t)
		{
			$what = preg_replace($t, $this->mark1 . '$1' . $this->mark2, $what);
		}

		foreach ($this->t1[0] as $t)
		{
			$what = preg_replace($t, $this->mark1 . '$1', $what);
		}

		foreach ($this->t2[0] as $t)
		{
			$what = preg_replace($t, '$1' . $this->mark2, $what);
		}

		foreach ($this->t1[1] as $t)
		{
			$what = preg_replace($t, $this->mark3 . $this->mark1 . '$1', $what);
		}

		foreach ($this->t2[1] as $t)
		{
			$what = preg_replace($t, '$1' . $this->mark2 . $this->mark3, $what);
		}

		foreach ($this->t1[2] as $t)
		{
			$what = preg_replace($t, $this->mark4 . $this->mark1 . '$1', $what);
		}

		foreach ($this->t2[2] as $t)
		{
			$what = preg_replace($t, '$1' . $this->mark2 . $this->mark4, $what);
		}

		// wrap whole text in terminator pair
		$what = $this->mark2 . $what . $this->mark1;

		// 2bis. swap <t-><br> -> <br><t->
		$what = preg_replace('!(' . $this->mark2 . ')((\s*<br[^>]*>)+)!si', '$2$1', $what);
		// noneedin: > eliminating multiple breaks
		$what = preg_replace('!((<br[^>]*>\s*)+)(' . $this->mark1 . ')!s', '$3', $what);

		// 2. cleanup <t->\s<-t>
		do
		{
			$_w		= $what;
			$what	= preg_replace('!(' . $this->mark2 . ')((\s|(<br[^>]*>|' . $this->mark3 . '|' . $this->mark4 . '))*)(' . $this->mark1 . ')!si', '$2', $what);
		}

		while ($_w != $what);

		// 3. replace each <t->....<-t> to <p class="auto">...</p>
		$pcount = 0;
		$pieces = explode($this->mark2, $what);

		if (isset($mark1))
		{
			$sizeof_mark1 = count($mark1);
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
						$pieces_inside = explode($this->mark3, $v);

						if (count($pieces_inside) < 3)
						{
							$insert_p = true;
						}
					}

					if ($insert_p)
					{
						$inside = substr($v, 0, $pos);
						$inside = str_replace($this->mark3, '', $inside);

						if (strlen($inside))
						{
							$pcount++;
							$pieces[$k] = "\n" .
										  $this->prefix1 .
										  $page_id . '-' . $pcount .
										  $this->prefix2 .
										  $inside .
										  $this->postfix . substr($v, $pos + $sizeof_mark1);
						}
					}
				}
			}
		}

		$what = implode('', $pieces);

		// 4. remove unused <t-> & <-t> and <ignore> tags
		$what = str_replace(
			[
				$this->mark1,
				$this->mark2,
				$this->mark3,
				$this->mark4,
				'<ignore>',
				'</ignore>'
			],
			'',
			$what);

		// -. done with P

		// INFINITY-2. inserting a (or next?) ignored regexp
		{
			$what	.= ' ';
			$a		 = explode('{:typo:markup:3:}', $what);

			if ($a)
			{
				$what = $a[0];
				$size = count($a);

				for ($i = 1; $i < $size; $i++)
				{
					$what = $what . $ignored[$i - 1] . $a[$i];
				}
			}
		}

		// ==================================================================
		// Forming body_toc
		//  * in wacko formatter we have done "#h1249-1"
		//  * right here we have done         "#p1249-1"
		// 1. get all ^^ of this
		$this->toc = [];

		return preg_replace_callback( '!' .
				// [2] = depth,
				// [3] = h-id,
				// [4] = name
				"(<h(\d) id=\"(h\d+-\d+)\" class=\"heading\">(.*?)<a class=\"self-link\" href=\"#h\d+-\d+\"></a>.*?</h\\2>)" .
					"|" .
				// [6] = p-id
				"(<p id=\"(p\d+-\d+)\" class=\"auto\">)" .
					"|" .
				// [7] = tag,
				// [8] = notoc
				"<\!--action:begin-->include\s+.*?page=\"([^\ ]+)\".*?(\s+notoc=\"?[^0]\"?)?.*?<\!--action:end-->" .
				// {{include page="tag" notoc=1}}
				"!ui", [&$this, 'add_toc_entry'], $what);
	}

	// for further TOC creation routines
	function add_toc_entry($matches)
	{
		$matches[6] ??= '';
		$matches[8] ??= '';

		// included page
		if ((isset($matches[7])) && $matches[7] != '')
		{
			// notoc=0 (default)
			if ($matches[8] == '')
			{
				$this->toc[] = [
					$this->wacko->unwrap_link(trim($matches[7], '"')),
					'(include)',
					IS_INCLUDE
				];
			}
		}
		else
		{
			// id, text, depth
			if ($matches[6] != '')
			{
				$this->toc[] = [
					$matches[6],
					'(p)',
					IS_PARAGRAPH
				];
			}
			else
			{
				$this->toc[] = [
					$matches[3],
					$matches[4],		// strip_tags()
					$matches[2]
				];
			}
		}

		return $matches[0];
	}
}
