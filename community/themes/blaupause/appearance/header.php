<?php
/*
Blaupause theme.
Common header file.
*/

require ('themes/_common/_header.php');

?>
<body onload="all_init();">

<div id="sitewrapper">
<div id="site">
<div class="header">
  <?php
// Outputs page title
?>
  <div id="header">
    <ul id="accessmenu">
      <li><a href="#content">zum Seiteninhalt spingen</a></li>
      <li><a href="#navigation">zur Navigation springen</a></li>
      <?php // Opens Search form ?>
      <li id="search"><?php echo $this->form_open('', $this->get_translation('TextSearchPage'), 'get'); ?>
        <fieldset>
        <label for="phrase"><?php echo $this->get_translation('SearchText'); ?></label>
        <input type="text" name="phrase" id="phrase" size="15" class="textinput" />
        <input  class="submitinput" type="submit" value="&raquo;" alt="<?php echo $this->get_translation('SearchButtonText'); ?>!" title="<?php echo $this->get_translation('SearchButtonText'); ?>!" />
        </fieldset>
        <?php echo $this->form_close(); ?></li>
    </ul>
  </div>
  <div id="infomenu">
    <div id="breadcrumb">
      <!-- <h1>-->
      <span class="main"><a href="<?php echo $this->config['base_url']; ?>"><?php echo $this->config['site_name'] ?></a>:</span> <span class="pagetitle"><?php echo $this->get_page_path(); ?></span> <a class="Search" title="<?php echo $this->get_translation('SearchTitleTip')?>"
     href="<?php echo $this->config['base_url'].$this->get_translation('TextSearchPage').($this->config['rewrite_mode'] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a><br />
      <!-- </h1> -->
    </div>
    <div id="languages">
    </div>
    <div id="bookmarks">
  <div id="navigation">
<?php
// Outputs Bookmarks AKA QuickLinks
	echo '<div id="usermenu">';
	echo "<ol>\n";
	// Main page
	echo "<li>".$this->compose_link_to_page($this->config['root_page'])."</li>\n";
	echo "<li>";
	// Bookmarks
	foreach ($this->get_bookmarks() as $_bookmark)
	{
		$formatted_bookmarks = $this->format($_bookmark[1], 'post_wacko');

		if ($this->page['page_id'] == $_bookmark[0])
		{
			echo '<li class="active">';
		}
		else
		{
			echo '<li>';
		}

		echo $formatted_bookmarks."</li>\n";
	}

	if ($this->get_user())
	{
		// determines what it should show: "add to bookmarks" or "remove from bookmarks" icon
		if (!in_array($this->page['page_id'], $this->get_bookmark_links()))
		{
			echo '<li><a href="'. $this->href('', '', 'addbookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icons/bookmark1.gif" alt="+" title="'.
				$this->get_translation('AddToBookmarks') .'"/></a></li>';
		}
		else
		{
			echo '<li><a href="'. $this->href('', '', 'removebookmark=yes')
				.'"><img src="'. $this->config['theme_url']
				.'icons/bookmark2.gif" alt="-" title="'.
				$this->get_translation('RemoveFromBookmarks') .'"/></a></li>';
		}
	}
	echo "\n</ol></div>";
?>

<div id="login">
<?php
// If user are logged, Wacko shows "You are UserName"
if ($this->get_user())
   { ?> <span class="nobr"><?php echo $this->get_translation('YouAre')." ".$this->link($this->config['users_page'].'/'.$this->get_user_name(), '', $this->get_user_name()) ?></span><small> ( <span class="nobr Tune"><?php
echo $this->compose_link_to_page($this->get_translation('AccountLink'), "", $this->get_translation('AccountText'), 0); ?>
 | <a onclick="return confirm('<?php echo $this->get_translation('LogoutAreYouSure');?>');" href="<?php echo $this->href('', $this->get_translation('LoginPage')).($this->config['rewrite_mode'] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->slim_url($this->tag);?>"><?php echo $this->get_translation('LogoutLink'); ?></a></span>
)</small>
<?php
// Else Wacko shows login's controls
   }
else
   {
   // Begin Login form
	echo $this->form_open('', $this->get_translation('LoginPage'), 'post'); ?>
      <input type="hidden" name="action" value="login" />
   <span class="nobr"><input type="hidden" name="goback" value="<?php echo $this->slim_url($this->tag);?>" /><strong><strong><?php echo $this->get_translation('LoginWelcome') ?></strong>:&nbsp;</strong>
   <input type="text" name="name" size="18" class="login" />&nbsp;<?php echo $this->get_translation('LoginPassword') ?>:&nbsp;<input type="password" name="password" class="login" size="8" />&nbsp;<input type="image" src="<?php echo $this->config['theme_url'] ?>icons/login.gif" alt=">>>" style="vertical-align:top" /></span> <?php

   // Closing Login form
	echo $this->form_close();
   }

// End if
?></div>
</div>
</div>
<div id="content">
<?php
// here we show messages
if ($message = $this->get_message()) echo "<div class=\"info\">$message</div>";
?>