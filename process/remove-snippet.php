<?php
	require_once('config/config.php');

	$voterId = $_POST['voter']['id'];

	$voter->addUser($voterId);
	if($voter->deleteVote())
	{
		echo json_encode(array('success' => true));	
	}
	else
	{
		echo json_encode(array('success' => false));			
	}

