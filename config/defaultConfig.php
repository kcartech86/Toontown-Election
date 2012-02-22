<?php
try{
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);  
}  
catch(PDOException $e) {  
    echo $e->getMessage(); 
}

require_once("classes.php");


$voter     = new Voter($pdo);
$candidate = new Candidate();
$candidate->loadDb($pdo);

$all = $pdo->prepare("SELECT c.*
				FROM candidates c");
$all->execute();

$candidates = array();

while($single = $all->fetch(PDO::FETCH_OBJ)) 
{
	$count = $pdo->prepare("SELECT COUNT(vote) FROM votes WHERE voter_id != 7531 AND vote=".$single->id);
	$count->execute();

	$count = $count->fetch();
	$count = $count[0];
	$candidates[] = new Candidate($single->id, $single->name, $single->message, $single->image, $count);
}