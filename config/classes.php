<?php
	class Candidate {
		public $id;
		public $name;
		public $message;
		public $image;
		public $votes;
		public $db;

		public function __construct($id=0, $name='', $message='', $image='', $votes='')
		{
			$this->id      = $id;
			$this->name    = $name;
			$this->message = $message;
			$this->image   = WEB_BASE."assets/img/".$image.".png";
			$this->icon    = WEB_BASE."assets/img/".$image."_icon.png";
			$this->votes   = $votes;
			$this->link    = str_replace(' ', '-', strtolower($name));
			$this->db      = '';
		}
		public function loadDb($database)
		{
			$this->db = $database;
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
				$obj->id,
				$obj->name,
				$obj->message,
				$obj->image,
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
		public static function __callStatic($name, $arguments)
	    {
			$obj = $arguments[0];
			if($obj->$name)
			{
				if($name == 'image' || $name == 'icon')
				{
					echo "<img src='".$obj->$name."' />";
				}
				else
				{
					echo $obj->$name;
				}
			}
			else
			{
				echo "<h1>WARNING: Class \"<strong>".get_class($obj)."\"</strong> has no parameter \"<strong>".$name."</strong>\"!</h1>.";
			}
		}
	}