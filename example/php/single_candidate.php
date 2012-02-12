<?php require_once("../../config/config.php"); ?>
<?php 
    $candidate->getInfo('Darkwing Duck');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project 02</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>

<body>
    <h2><?php Load::icon($candidate); ?> <?php Load::name($candidate); ?></h2>
    <p><?php Load::message($candidate); ?></p>
    <?php Load::image($candidate); ?>
    <ul>
        <li>Votes: <?php Load::votes($candidate); ?></li>
    </ul>

</body>
</html>