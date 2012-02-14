<?php require_once("config/config.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project 02</title>
</head>

<body>
	<div id="content">
    	<h2><?php Load::name($candidates[0]); ?></h2>
    	<ul>
    		<li>ID: <?php Load::id($candidates[0]); ?></li>
    	</ul>
    	<p><?php Load::message($candidates[0]); ?></p>
    	<p><?php Load::image($candidates[0]);?></p>
    </div>

</body>
</html>