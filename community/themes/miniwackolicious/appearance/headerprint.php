<?php
	// Wacko can show message (by javascript)
	$message = $this->get_message();
	$base_url = $this->config['base_url'];

	// HTTP header with right Charset settings
	header("Content-Type: text/html; charset=".$this->get_charset());
?>
<!DOCTYPE html
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->config['language']; ?>" lang="<?php echo $this->config['language']; ?>">
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->get_charset(); ?>" />
	<meta name="robots" content="noindex, nofollow" /> <!-- do not index alternative print pages -->
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url'] ?>../default/css/default.css.php" />
	<link media="screen,projection,print" rel="stylesheet" type="text/css" href="<?php echo $this->config['theme_url'] ?>layout/print.css" />
	<style media="screen,projection,print">
		body {margin:1.875cm 2.5cm 3.75cm 1.5cm}
		br {display:inline;}
	</style>
	<link rel="start" href="<?php echo $this->config['base_url']; ?>" />
	<title><?php echo $this->config['wacko_name'] ?> : <?php echo $this->add_spaces($this->tag).($this->method != 'show' ? ' ('.$this->method.')' : ''); ?></title>
	<link rel="shortcut icon" href="<?php echo $this->config['theme_url'] ?>icons/favicon.ico" type="image/x-icon" />

<body>

		<div class="printheader">
			<a href="<?php echo $this->config['base_url'] ?>" class="title"><?php echo $this->config['wacko_name']; ?></a>
		</div>

<div id="content" class="content">
