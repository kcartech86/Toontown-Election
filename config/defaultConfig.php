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

$all = $pdo->prepare("SELECT * FROM candidates");
$all->execute();

$candidates = array();

while($single = $all->fetch(PDO::FETCH_OBJ)) 
{
	$candidates[] = new Candidate($single->id, $single->name, $single->message, $single->image, $single->votes);
}