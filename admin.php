<?php require_once("config/config.php");
	if(isset($_POST['submit']))
	{
		if($_POST['master'] == "7531")
		{
			$q = $pdo->prepare("UPDATE votes SET vote=1 WHERE voter_id=7531");
			$q->execute();
		}
	}
	if(isset($_POST['reset']))
	{
		if($_POST['master'] == "7531")
		{
			$q = $pdo->prepare("UPDATE votes SET vote=0 WHERE voter_id=7531");
			$q->execute();
		}
	}
?>
<form action='' method="post">
	<p>Enter master user: <input type="text" name="master" /><input type="submit" name="submit" value="Finish Poll" /> <input type="submit" name="reset" value="Reset Poll" /></p>
</form>