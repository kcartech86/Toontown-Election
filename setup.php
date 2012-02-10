<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	
	<head>

	<title>Database Setup</title>
	<link href='http://fonts.googleapis.com/css?family=Share:700' rel='stylesheet' type='text/css'>
	<style type="text/css">
		body {
			background: #DDD;
		}
		.hidden {
			display: none;
		}
		#results {
			margin: 0;
			padding: 0;
		}
		#results li
		{
			font-family: 'Share', arial;
			list-style: none;
			font-size: 5em;
			margin: 0;
			padding: 0;
			text-align: center;
			margin-top: 250px;
			color: #666;
		}
		#loader {
			text-align: center;
		}
	</style>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript">
		function showSetup(element)
		{
			$(element).fadeIn('slow', function() {
				if($(element).next().length > 0)
				{
					setTimeout(function() {
						$(element).fadeOut('slow', function() {
							showSetup($(element).next());
						});
					}, 1000);
				}
				else
				{
					$('#loader').fadeOut('fast');
				}
			});
		}
		$(document).ready(function() {
			$('#loader').fadeIn('slow');
			showSetup($('#results').children('li:first-child'));
		});
	</script>
	</head>

	<body>
<?php

require_once("config/config.php");

$queryArray = array();

$queryArray[] = array("CREATE TABLE `candidates` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`message` varchar(255) NOT NULL,
	`image` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;", "Candidates table created");

$queryArray[] = array("INSERT INTO  `candidates` (
	`id` ,
	`name` ,
	`message` ,
	`image`
	)
	VALUES (
		NULL ,  'Finn and Jake',  'This rough and tumble team are ready to be your mayor. They''ll be ready for adventure at any time.',  'adventure_time.jpg'
		), (
		NULL ,  'Tommy Pickles',  'Tommy will make sure there is milk in every bottle and a screwdriver in every diaper.',  'Tommy.jpg'
		), (
		NULL ,  'Darkwing Duck',  'Just remember, when there''s trouble, you call DW',  'darkwing_duck.jpg'
	);", "Candidates table populated");

$queryArray[] = array("CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voter_id` int(11) NOT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `voter_id` (`voter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
", "Voters table created");

$queryArray[] = array("skip", "Setup Complete");

echo "<ul id='results'>";

echo "<li class='hidden'>Preparing to set up ...</li>";

foreach($queryArray as $query)
{
	if($query[0] != "skip")
	{
		if($pdo->prepare($query[0])->execute())
		{
			echo "<li class='hidden'>".$query[1]."</li>";
		}
		else
		{
			echo '<li class="hidden">Setup has already been run</li>';
			break;
		}
	}
	else
	{
		echo "<li class='hidden'>".$query[1]."</li>";
	}
}

echo "</ul>";

?>

	<p id="loader" class="hidden"><img src="<?php echo BASE; ?>assets/img/ajax-loader.gif" /></p>

	</body>

</html>
