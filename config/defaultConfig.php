<?php
try{
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);  
}  
catch(PDOException $e) {  
    echo $e->getMessage();  
}

class Candidate {
	public $id;
	public $name;
	public $message;
	public $image;

	public function __construct($db='', $id=0, $name='', $message='', $image='')
	{
		$this->id      = $id;
		$this->name    = $name;
		$this->message = $message;
		$this->image   = $image;
		$this->db      = $db;
	}
	public function getInfo($id) 
	{
		$result = $this->db->prepare("SELECT * FROM candidates WHERE id=1");
		$result->execute();
		$obj = $result->fetch(PDO::FETCH_OBJ);

		$this->__construct(
			$obj->id,
			$obj->name,
			$obj->message,
			$obj->image
		);
	}
}
class Voter {
	public $voter;
	public $vote;

	public function __construct($db='', $voter='', $voter='') {
		$this->voter = $voterId;
		$this->vote  = $vote;
		$this->db    = $db;
	}
	public function addUser($voter)
	{
		$this->voter = $voter;
	}
	public function addVote($vote)
	{
		$this->vote = $vote;
	}
	public function sendVote()
	{
		return $this->db->prepare("INSERT INTO votes (voter_id, vote) VALUES ($this->voter, $this->vote)")->execute();
	}
	public function deleteVote()
	{
		return $this->db->prepare("DELETE FROM votes WHERE voter_id=$this->voter")->execute();
	}
	public function checkVote()
	{
		$result = $this->db->prepare("SELECT COUNT(*) AS count FROM votes WHERE voter_id=$this->voter");
		$result->execute();
		$count = $result->fetch(PDO::FETCH_OBJ);
		if($count->count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}

$voter     = new Voter($pdo);
$candidate = new Candidate($pdo);


$all = $pdo->prepare("SELECT * FROM candidates");
$all->execute();

$candidates = array();

while($single = $all->fetch(PDO::FETCH_OBJ)) 
{
	$candidates[] = new Candidate(null, $single->id, $single->name, $single->message, $single->image);
}