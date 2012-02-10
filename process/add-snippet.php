<?php
	require_once('config/config.php');

	$voterId = $_POST['voter']['id'];
	$vote = $_POST['voter']['vote'];

	$voter->addUser($voterId);
	$voter->addVote($vote);
	if($voter->sendVote())
	{
		echo json_encode(array('success' => true));	
	}
	else
	{
		echo json_encode(array('success' => false));			
	}

