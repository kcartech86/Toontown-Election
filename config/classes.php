<?php
	class Candidate {
		public $id;
		public $name;
		public $message;
		public $image;
		public $votes;

		public function __construct($db='', $id=0, $name='', $message='', $image='', $votes='')
		{
			$this->db      = $db;
			$this->id      = $id;
			$this->name    = $name;
			$this->message = $message;
			$this->image   = $image;
			$this->votes   = $votes;
		}
		public function getInfo($find) 
		{
			if(!is_int($find))
			{
				$find = str_replace('-', ' ', $find);
			}
			$result = $this->db->prepare("SELECT c.* , COUNT( v.vote ) AS votes
				FROM candidates c
				LEFT JOIN votes v ON v.vote = c.id
				WHERE c.id = '$find' OR c.name = '$find'");
			$result->execute();
			$obj = $result->fetch(PDO::FETCH_OBJ);

			$this->__construct(
				null,
				$obj->id,
				$obj->name,
				$obj->message,
				WEB_BASE."assets/img/".$obj->image.".png",
				$obj->votes
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

	class Load {
		public function pic($obj)
		{
			echo "<img src='".$obj->image."' />";
		}
		public function name($obj)
		{
			echo $obj->name;
		}
		public function message($obj)
		{
			echo $obj->message;
		}
		public function votes($obj)
		{
			echo $obj->votes;
		}
		public function id($obj)
		{
			echo $obj->id;
		}
		public function link($obj)
		{
			echo str_replace(' ', '-', strtolower($obj->name));
		}

	}