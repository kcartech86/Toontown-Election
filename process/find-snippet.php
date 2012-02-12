<?php
	require_once('config/config.php');
	$class     = $_GET['class'];
	$parameter = $_GET['parameter'];

	$ifilter = array();
	foreach($_POST['input'] as $key => $name)
	{
		$ifilter[$key] = $name;
	}

	if($class == 'candidate')
	{
		$candidate->getInfo($ifilter['find']);
		echo $candidate->$parameter;
	}
	else if($class == 'voter')
	{
		echo $voter->$parameter;		
	}