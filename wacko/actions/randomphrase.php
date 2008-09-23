<?php
$vars[0] = $this->UnwrapLink($vars[0]);
if (! $this->HasAccess("read",$vars[0])){
	echo $this->GetResourceValue("NoAccessToSourcePage");
}else{
	if (!$phrase_page = $this->LoadPage($vars[0], $_GET["time"])){
		echo "<em> ".$this->GetResourceValue("SourcePageDoesntExist")."(".$vars[0].")</em>";
	}else{
		$strings = preg_replace("/\{\{[^\}]+\}\}/","",$phrase_page["body"]);
		$strings = $this->Format($strings);
		$splitexpr = "|<br />|";
		if ($useemptystring==1) $splitexpr = "|<br />[\n\r ]*<br />|";
		$lines = preg_split($splitexpr,$strings);
		$lines = array_values(array_filter( $lines, "trim"));
		srand ((double) microtime() * 1000000);
		print $lines[rand(0,count($lines)-1)];
	};
}
?>