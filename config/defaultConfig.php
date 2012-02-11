<?php
try{
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);  
}  
catch(PDOException $e) {  
    echo $e->getMessage(); 
}

require_once("classes.php");


$voter     = new Voter($pdo);
$candidate = new Candidate($pdo);

$all = $pdo->prepare("SELECT * FROM candidates");
$all->execute();

$candidates = array();

while($single = $all->fetch(PDO::FETCH_OBJ)) 
{
	$candidates[] = new Candidate(null, $single->id, $single->name, $single->message, WEB_BASE."assets/img/".$single->image.".png", $single->votes);
}