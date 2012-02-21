<?php require_once("config/config.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	
	<head>

	<title>Voting Results</title>
	<style type="text/css">
		ul {
			margin: 0;
			padding: 0;
		}
		ul li {
			list-style: none;
			margin: 10px;
		}
		.votes {
			display: inline-block;
			height: 30px;
			width: 1%;
			border-radius: 10px;

			background: #113D69 /*{a-bar-background-color}*/;
			background-image: -webkit-gradient(linear, left top, left bottom, from( #175593 /*{a-bar-background-start}*/), to( #0A243F /*{a-bar-background-end}*/));
			background-image: -webkit-linear-gradient( #175593 /*{a-bar-background-start}*/, #0A243F /*{a-bar-background-end}*/);
			background-image: -moz-linear-gradient( #175593 /*{a-bar-background-start}*/, #0A243F /*{a-bar-background-end}*/);
			background-image: -ms-linear-gradient( #175593 /*{a-bar-background-start}*/, #0A243F /*{a-bar-background-end}*/);
			background-image: -o-linear-gradient( #175593 /*{a-bar-background-start}*/, #0A243F /*{a-bar-background-end}*/);
			background-image: linear-gradient( #175593 /*{a-bar-background-start}*/, #0A243F /*{a-bar-background-end}*/);
			border-image: initial;			);
		}
		.inline
		{
			padding: 0;
			margin-top: -10px;
			width: 200px;
			display: inline-block;
		}
		.percent
		{
			padding: 0;
			margin: 0;
			display: block;
			vertical-align: 0px;
		}

	</style>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript">
		var voter = {};
		function counter(cap)
		{
			var count = parseInt($('#totals').html());
			if(count < cap)
			{
				count++;
				$('#totals').html(count);
				setTimeout(function() { counter(cap); }, 50);
			}
			else if(count > cap)
			{
				count--;
				$('#totals').html(count);
				setTimeout(function() { counter(cap); }, 50);
			}
		}

		function change() {
			$.post('/api/find/candidate/all/votes/', function(candidate) {		
				var fullAmount = 0;

				for(i in candidate)
				{
					fullAmount += parseInt(candidate[i].votes);
				}

				var percent = new Array();
				var element = new Array();

				for(i in candidate)
				{
					if(fullAmount != 0)
					{
						percent[i] = Math.round((candidate[i].votes/fullAmount)*100);
					}
					else
					{
						percent[i] = 0;
					}
				}

				for (i in candidate)
				{
					var obj = $('#'+candidate[i].name);
					if(percent[i] != parseInt($(obj).children("li").children('div').children('.percent').html()))
					{	
						$(obj).children("li").children('div').children(".votes").animate({
							width: percent[i]+"%"
						}, 
						{
							step: function(now, fx) {
								$(fx.elem).parent().children('.percent').width(Math.round(now)+"%").html(Math.round(now)+"%");
						 	}
						},
						1000);
					}
				}
				counter(fullAmount);
			}, "json");
		}
		$(document).ready(function() {
			var timer = setInterval(change, 1000);
		});
	</script>
	</head>

	<body>
		<ul>
		<?php foreach($candidates as $name) { ?>
			<li>
				<ul id="<?php Load::link($name); ?>" class="candidate">
					<li><?php Load::icon($name); ?>
					<div class="inline"><span class="percent">0%</span> <span class="votes"></span></div>
				</ul>
			</li>
		<?php } ?>
		</ul>
		<p>Votes: <span id="totals">0</span></p>
	</body>

</html>
