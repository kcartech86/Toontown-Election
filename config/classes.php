<?php
	class Candidate {
		public $id;
		public $name;
		public $message;
		public $image;
		public $votes;

		public function __construct($db='', $id=0, $name='', $message='', $image='', $votes='')
		{
			$this->id      = $id;
			$this->name    = $name;
			$this->message = $message;
			$this->image   = $image;
			$this->db      = $db;
			$this->votes   = $votes;
		}
		public function getInfo($id) 
		{
			$result = $this->db->prepare("SELECT c . * , COUNT( v.vote ) AS votes
				FROM candidates c
				STRAIGHT_JOIN votes v ON v.vote = c.id
				WHERE c.id =$id");
			$result->execute();
			$obj = $result->fetch(PDO::FETCH_OBJ);

			$this->__construct(
				$obj->id,
				$obj->name,
				$obj->message,
				"/assets/img/".$obj->image,
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
			echo BASE.$obj->image;
		}
	}