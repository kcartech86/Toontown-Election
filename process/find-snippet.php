<?php
	require_once('config/config.php');
	$class     = $_GET['class'];
	$parameter = $_GET['parameter'];

	$ifilter = array();
	if($_POST['input'])
	{
		foreach($_POST['input'] as $key => $name)
		{
			$ifilter[$key] = $name;
		}
	}
	if($class == 'candidate')
	{
		$candidate->getInfo($ifilter['find']);
		if($parameter == 'info') {
			$candidateArray = array();

			$candidateArray['id']      = $candidate->id;
			$candidateArray['name']    = $candidate->name;
			$candidateArray['message'] = $candidate->message;
			$candidateArray['image']   = $candidate->image;
			$candidateArray['icon']    = $candidate->icon;
			$candidateArray['votes']   = $candidate->votes;

			echo json_encode($candidateArray);
		}
		else if($parameter == 'all')
		{
			$candidateArray = array();
			foreach($candidates as $item)
			{
				$candidateArray[] = array(
					'id'      => $item->id, 
					'name'    => $item->name, 
					'message' => $item->message, 
					'image'   => $item->image, 
					'icon'    => $item->icon, 
					'votes'   => $item->votes
				);
			}
			echo json_encode($candidateArray);
		}
		else
		{
			echo json_encode($candidate->$parameter);
		}
	}
	else if ($class == 'candidate/all')
	{
		if($parameter == 'votes')
		{
			$candidateArray = array();
			$winnerQuery = $pdo->prepare("SELECT vote FROM votes WHERE voter_id=7531");
			$winnerQuery->execute();
			$winner = $winnerQuery->fetch(PDO::FETCH_OBJ);
			foreach($candidates as $item)
			{
				$candidateArray[] = array(
					'name'    => $item->link, 
					'votes'   => $item->votes
				);
			}
			echo json_encode(array("candidate" => $candidateArray, "showWinner" => $winner->vote));
		}
	}
	else if($class == 'voter')
	{
		echo json_encode($voter->$parameter);		
	}
