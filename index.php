<?php require_once("config/config.php"); ?>

<!DOCTYPE html> 
<html class="ui-mobile-rendering"> 

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Project 02</title>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
<script type="text/javascript">

var voter = {};

$(document).ready(function() {
	$("#voterIdSubmit").tap(function() {
		var voterId = $("#voterId").val();
		if(voterId.match(/^[0-9]+$/) && voterId > 1000 && voterId < 1050)
		{
			$.post('/api/vote/check/', { 'voter' : voter}, function(data) {
				if(data.success)
				{
					alert("You've already voted!");
				}
				else
				{
					voter.id = voterId;
					$.mobile.changePage( "#two" );			
				}
			}, "json");
		}
		else
		{
			alert("The only valid voter numbers are 1001 - 1049")
		}
		return false;
	});
	$('.candidateLink').tap(function() {
		var input = {};
		input.find = $(this).attr("data-candidate");
	    $.post('/api/find/candidate/info/', { 'input' : input}, function(candidate) {  
	        //The candidate variable will have all the candidates info in it.
	        $('#about-content h2').html(candidate.id+": "+candidate.name);
	        $('#about-content #statement').html(candidate.message);
	        $('#about-content #image').attr('src', candidate.image);
	        $('#about-content li').html('Votes: '+candidate.votes);
			$.mobile.changePage( "#about" );	
	    }, "json");
	    return false;
	});
	$('#castVote').tap(function(e) {
		e.preventDefault();
		voter.vote = $("#ballot").find("input:checked").attr("value")
       $.post('/api/vote/add/', { 'voter' : voter }, function(data) {
            //If the vote has been successfully cast, send them to the voted page.
            if(data.success)
            {
				$.mobile.changePage( "#results", { transition: "slideDown"} );	

            }
            //An extra check to make sure they haven't voted yet, just to be sure.
            else
            {
                alert("You've already voted");
            }
        }, "json");    
	});
});

</script>
<style type="text/css">
	#results div ul {
		margin: 0;
		padding: 0;
	}
	#results div ul li {
		list-style: none;
		height: 50px;
		margin: 10px;
	}
	#results div .votes {
		display: inline-block;
		height: 10px;
		background: #f00;
		width: 1%;
		border-radius: 10px;
		background-image: linear-gradient(bottom, rgb(196,27,8) 26%, rgb(227,52,32) 63%, rgb(232,49,21) 82%);
		background-image: -o-linear-gradient(bottom, rgb(196,27,8) 26%, rgb(227,52,32) 63%, rgb(232,49,21) 82%);
		background-image: -moz-linear-gradient(bottom, rgb(196,27,8) 26%, rgb(227,52,32) 63%, rgb(232,49,21) 82%);
		background-image: -webkit-linear-gradient(bottom, rgb(196,27,8) 26%, rgb(227,52,32) 63%, rgb(232,49,21) 82%);
		background-image: -ms-linear-gradient(bottom, rgb(196,27,8) 26%, rgb(227,52,32) 63%, rgb(232,49,21) 82%);

		background-image: -webkit-gradient(
			linear,
			left bottom,
			left top,
			color-stop(0.26, rgb(196,27,8)),
			color-stop(0.63, rgb(227,52,32)),
			color-stop(0.82, rgb(232,49,21))
		);
	}
	#results div .inline
	{
		padding: 0;
		margin-top: -10px;
		width: 200px;
		display: inline-block;
	}
	#results div .percent
	{
		padding: 0;
		margin: 0;
		display: block;
		vertical-align: 0px;
	}

</style>

</head>

<body>
<!-- Start of first page: #one -->
<div data-role="page" id="one">

	<div data-role="header">
		<h1>Toon-town Election</h1>
	</div><!-- /header -->

	<div data-role="content" >
	<p>Welcome to the Toon-town election! Please enter your Voter ID number to continue:</p>
	<input type="text" id="voterId" />
	<a data-role="button" id="voterIdSubmit" href="#two">Continue</a>
	</div><!-- /content -->
	
	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page one -->


<!-- Start of second page: #two -->
<div data-role="page" id="two">	
	<div data-role="header">
		<h1>About Each Candidate</h1>
	</div><!-- /header -->
	<ul data-role="listview" data-theme="g">
		<?php foreach ($candidates as $runner) { ?>
		<li><a class="candidateLink" data-candidate="<?php Load::link($runner); ?>" href="#about"><?php Load::icon($runner); ?> <?php Load::name($runner); ?></a></li>
		<?php } ?>
	</ul>
	<p><a data-role="button" href="#vote">Continue on to Cast Your Vote</a></p>
	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page two -->


<!-- Start of third page: #popup -->
<div data-role="page" id="about">

	<div data-role="header">
		<h1>Dialog</h1>
	</div><!-- /header -->

	<div data-role="content" id="about-content">	
	    <h2></h2>
	    <img id="image">
	    <p id="statement"></p>
	    <ul>
	        <li></li>
	    </ul>
	    <p><a data-direction="reverse" data-role="button" href="#two">Back</a></p>
	</div><!-- /content -->
	
	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page popup -->
<div data-role="page" id="vote">

	<div data-role="header">
		<h1>Cast Your Vote</h1>
	</div><!-- /header -->

	<div data-role="content">				
		<div id="ballot" data-role="fieldcontain">
					<?php 
						$count = 0;
						foreach($candidates as $running) { ?>
					<input type="radio" name="voter" id="checkbox-<?php echo $count; ?>" class="custom" value="<?php Load::id($running); ?>" />
					<label for="checkbox-<?php echo $count; ?>"><?php Load::icon($running); ?> Vote For <?php Load::name($running); ?></label>
					<?php $count++; } ?>
		</div>
		<p><a id="castVote" data-role="button">Click to Cast Your Vote</a></p>
	</div>
	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page popup -->
<div data-role="page" id="results">

	<div data-role="header">
		<h1>Cast Your Vote</h1>
	</div><!-- /header -->

	<div data-role="content">				
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
	</div>
	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div>
</body>
</html>