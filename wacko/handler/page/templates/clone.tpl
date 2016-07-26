FIRST EVER html template for WackoWiki!
please do not reformat!
leave it as is for the memories


[ ====================================== main =================================== ]
<h3>[''' _t: ClonePage '''] [''' headLink | ''']</h3>
<br />
[' // massLog ']
[' form ']

[ ====================================== massLog =================================== ]
<p><strong>[' _t: MassCloning ']</strong></p>
[' err ']
[' log ']

[ ====================================== err =================================== ]
<ol>
	[' a err2 ']
</ol>
[ ====================================== err2 =================================== ]
<li>[' error | ']</li>

[ ====================================== log =================================== ]
[' h logHead ']
<ol>
	[' l log2 ']
</ol>
[ ====================================== log2 =================================== ]
<li>['' message | // message contains url '']</li>
[ ====================================== logHead =================================== ]
[' to ']: <br />

[ ====================================== form =================================== ]
[' _t: CloneName ']

<form action="[' href | ']" method="post" name="clone_page" >
	[' csrf: clone_page | ']
	<input type="text" name="clone_name" size="40" maxlength="250"/>
	[' e editNote ']
	[' doCluster ']
	<br /><br />
	<input type="submit" name="submit" value="[' _t: CloneButton ']" />
	&nbsp;
	<a href="[' show | ']" style="text-decoration: none;"><input type="button" value="[' _t: EditCancelButton | replace "\n" " " ']"/></a>
</form>
[ ====================================== editNote =================================== ]
<br />
<label for="edit_note">[' _t: EditNote ']</label><br />
<input type="text" id="edit_note" maxlength="200" value="[' note ']" size="60" name="edit_note"/>
[ ====================================== doCluster =================================== ]
<br /><br />
<input type="checkbox" id="massclone" name="massclone" />
<label for="massclone">[' _t: MassClone ']</label>
