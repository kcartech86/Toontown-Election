<?php require_once("config/config.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project 02</title>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
<script type="text/javascript">

var voter = {};

$(document).ready(function() {
	$("#voterIdSubmit").click(function() {
		var voterId = $("#voterId").val();
		if(voterId.match(/^[0-9]+$/) && voterId > 1000 && voterId < 1050)
		{
			$.mobile.changePage( "#two" );	
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
	});
});

</script>
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
<div data-role="page" id="two">	<div data-role="header">
		<h1>About Each Candidate</h1>
	</div><!-- /header -->
	<ul data-role="listview" data-theme="g">
		<?php foreach ($candidates as $runner) { ?>
		<li><a class="candidateLink" data-candidate="<?php Load::link($runner); ?>" href="#about"><?php Load::icon($runner); ?> <?php Load::name($runner); ?></a></li>
		<?php } ?>
	</ul>	
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

</body>
</html>