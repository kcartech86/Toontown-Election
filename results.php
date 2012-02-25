<?php require_once("config/config.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	
	<head>
	<link href='http://fonts.googleapis.com/css?family=Arimo:400,700' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Maven+Pro:400,900' rel='stylesheet' type='text/css'>

	<title>Voting Results</title>
	<style type="text/css">
		body
		{
			font-family: 'Arimo', sans-serif;
			width: 960px;
			margin: 0 auto;
		}
		header
		{
			text-align: center;
		}
		.icon
		{
			border: 2px solid black;
			padding: 10px;
			border-radius: 10px;
			margin: 10px;
		}
		p
		{
			font-size: 2em;
			text-align: center;
		}
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
			width: 800px;
			display: inline-block;
		}
		.percent
		{
			padding: 0;
			margin: 0;
			display: block;
			vertical-align: 0px;
			font-weight: bold;
			font-size: 1.4em;
			width: 30px;
			text-align: right;
		}
		#popupback { 
			background:#000000; 
			opacity:.5; 
			z-index:10; 
			position:fixed; 
			left:0; 
			top:0; 
			margin-top:-21px; 
		}
		.winner
		{
			font-family: 'Maven Pro', sans-serif;
			text-transform: uppercase;
			font-weight: bold;
			font-size: 6em;
			z-index: 400;
			color: #FFF;
			position: absolute;
			text-align: center;
			display: none;
			padding: 0;
			margin: 0;
		}

	</style>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript">
		var voter = {};
		var winnerShownAlready = false;
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
			$.post('/api/find/candidate/all/votes/', function(data) {
				var fullAmount = 0;
				var candidate = data.candidate;
				var showWinner = data.showWinner;

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
						 	},
						 	duration: 1000,
						 	complete: function() {
						 		console.log('oijo');
								if(showWinner == 1  && winnerShownAlready == false)
								{
									finish();
								}
							}
						});
					}
				}
				counter(fullAmount);
			}, "json");
		}
		function finish()
		{
			var votes = new Array();
			var winner = '';
			var soFar = 0;
			winnerShownAlready = true;
			$('.percent').each(function() {
				if(parseInt($(this).text()) > soFar)
				{
					soFar = parseInt($(this).text());
					winner = $(this).parent().parent().parent().attr('id');
				}
			});
			$('body').prepend("<p class='winner' id='upper'>The winner is</p>");
			$('body').prepend("<p class='winner' id='lower'>"+winner.replace(/-/g, ' ')+" </p>");
			$(".candidates ul").each(function() {
				if($(this).attr('id') != winner)
				{
					$(this).fadeTo("slow", 0.5);
				}
				else
				{
					var pos = $(this).position();
					$(this).css({
						'z-index' : "400", 
						"position" : "absolute",
						"left" : pos.left,
						"top" : pos.top,
					});
					$(this).children('li').css({
						"background" : "#fff",
					});
					var newTop = ($(window).height()/2) - $(this).height();
					popUpBack();
					$(this).animate({
						width: $(window).width()-20,
						left: 20,
						top: newTop,
					}, 
					{
						duration: 900,
					});

					$('#lower').css({ 
						"top" : (newTop + $(this).height()),
						"left": (($(window).width()/2) - $("#lower").width()/2),
					});
					$('#upper').css({ 
						"top" : (newTop - $(this).height()),
						"left": (($(window).width()/2) - $("#lower").width()/2) 
					});
					$(".winner").fadeIn(2000);

				}
			});
		}
		function popUpBack() {
			width = $(document).width()+100;
			height = $(document).height()+100;
			
			$('body').prepend('<div id="popupback"></div>');
			
			$('#popupback').hide();
			$('#popupback').fadeIn(300);
			$('#popupback').width(width);
			$('#popupback').height(height);
		}
		$(document).ready(function() {
			var timer = setInterval(change, 2000);
		});
	</script>
	</head>

	<body>
		<header>
			<h1>Toontown Elections</h1>
			<h2>Voting results</h2>
		</header>
		<ul class="candidates">
		<?php foreach($candidates as $name) { ?>
			<li>
				<ul id="<?php Load::link($name); ?>" class="candidate">
					<li class="icon"><?php Load::icon($name); ?>
					<div class="inline"><span class="percent">0%</span> <span class="votes"></span></div>
				</ul>
			</li>
		<?php } ?>
		</ul>
		<p>Votes: <span id="totals">0</span></p>
	</body>

</html>
