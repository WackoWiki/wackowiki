<?php
/*
 {{TOC page|for="!/SubTag" from="h2" to="h4" numerate="0|1|..." }}
 */
// 1. check for first param (for what TOC is built)
if ($for) $page=$for;
if ($page)
{
	$page = $this->UnwrapLink($page);
	$ppage = "/".$page;
	$context = $page;
	$_page = $this->LoadPage($page);
	if (!$title) $title = $page;
	$link = $this->Href("",$_page["tag"]);
}
else
{
	$page = ""; $ppage="";
	$context = $this->tag;
	$_page = $this->page;
	$link = "";
}

if (!$from) $from = "h2";
if (!$to)   $to   = "h9";

$start_depth = $from{1};
$end_depth   = $to{1};

// 3. output
print "<fieldset>";
print "<legend><strong> ".$this->GetResourceValue("TOCTitle")." ".$this->Link($ppage, "", $title)."  </strong></legend>";
if (!$this->HasAccess("read",$_page["tag"]))
print $this->GetResourceValue("ReadAccessDenied");
else
{
	$toc = $this->BuildToc( $context, $start_depth, $end_depth, $numerate, $link );
	{ // ---------------------- toc numeration ------------------------
		// identify what size where faces
		$toc_len = sizeof($toc);
		$numbers = array(); $depth = 0;
		for($i=0;$i<$toc_len;$i++)
		if ($toc[$i][2] < 66666)
		{ // normalized depth immersion
			$toc[$i][4] = $toc[$i][2]-$start_depth+1;
			if ($numerate)
			{
				// if dive deeper, reset the meter for new depths
				if ($toc[$i][2] > $depth) $numbers[ $toc[$i][2] ] =0;
				// if left lower level, nothing else to do.
				// store and increase the depth meter item
				$depth = $toc[$i][2];
				$numbers[ $depth ]++;
				// collect numbering on the array of $ numbers from start to the current depth, allowing zero
				$num="";
				for($j=1;$j<=$depth; $j++)
				if ($numbers[$j] > 0) $num.=$numbers[$j].".";
				// Human content TOC
				$toc[$i][1] = $num." ".$toc[$i][1];
			}
		}
		// not bad in a cache write similar version
		$this->tocs[ $context ] = &$toc;
		// it is now necessary to place flag about the fact that good to [iskurochit] in Post-[vake]
		// the source page, adding there [tsyfirki]
		if (!$ppage) { $this->post_wacko_toc = &$toc; $this->post_wacko_action["toc"] = 1; }
	} // --------------------------------------------------------------
	// display!
	foreach( $toc as $v )
	if ($v[4])
	{
		echo '<div class="toc'.$v[4].'">';
		echo '<a href="'.$v[3].'#'.$v[0].'">'.strip_tags($v[1]).'</a>';
		echo '</div>';
	}
	//$this->tocRecursion( ($ppage?$this->Href("",$ppage):""), $toc_body, 2 );
}
print "</fieldset>";

?>