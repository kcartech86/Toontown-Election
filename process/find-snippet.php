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
		if($parameter == 'all') {
			$candidateArray = array();

			$candidateArray['id']      = $candidate->id;
			$candidateArray['name']    = $candidate->name;
			$candidateArray['message'] = $candidate->message;
			$candidateArray['image']   = $candidate->image;
			$candidateArray['votes']   = $candidate->votes;

			echo json_encode($candidateArray);
		}
		else
		{
			echo json_encode($candidate->$parameter);
		}
	}
	else if($class == 'voter')
	{
		echo json_encode($voter->$parameter);		
	}