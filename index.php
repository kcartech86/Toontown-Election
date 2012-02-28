<?php require_once("config/config.php"); ?>

<!DOCTYPE html>
<html>
<head>
  
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Google fonts link -->
<link href='http://fonts.googleapis.com/css?family=Lilita+One|Shadows+Into+Light+Two|Original+Surfer' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="assets/css/themes/warnerbros_theme.min.css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile.structure-1.0.1.min.css" /> 
<title>Toon-town Mayoral Election</title>
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
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
	$.post('/api/find/candidate/all/votes/', function(data) {		
		var fullAmount = 0;
		var candidate = data.candidate;

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
	$("#voterIdSubmit").tap(function(e) {
		e.preventDefault();
		var voterId = $("#voterId").val();
		voter.id = voterId;
		if(voterId.match(/^[0-9]+$/) && voterId > 1000 && voterId < 1050)
		{
			$.post('/api/vote/check/', { 'voter' : voter}, function(data) {
				$('.voterIdNum').each(function() {
					$(this).html("Voter ID: "+voter.id+"");
				});
				if(data.success)
				{
					$.mobile.changePage( "#results", { transition: "slidedown"} );
					if(timer)
					{
						clearInterval(timer);
						var timer = setInterval(change, 1000);
					}
					else
					{
						var timer = setInterval(change, 1000);
					}
				}
				else
				{
					$.mobile.changePage("#two");			
				}
			}, "json");
		}
		else
		{
			//Let's put a jquery popup page here. It should work about the same and should blend better.
			//alert("The only valid voter numbers are 1001 - 1049")
			//$.mobile.changePage("#warning");
			$.mobile.changePage( "#warning", { transition: "pop"}, {rel: "dialogue"} );
			
		}
	});
	$('.candidateLink').tap(function(e) {
		e.preventDefault();
		var input = {};
		input.find = $(this).attr("data-candidate");
	    $.post('/api/find/candidate/info/', { 'input' : input}, function(candidate) {  
	        //The candidate variable will have all the candidates info in it.
	        $('#about-content #statement').html(candidate.message);
	        $('#about-content #image').attr('src', candidate.image);
	        $('#about-content li').html('Votes: '+candidate.votes);
	        $('#about-header h1').html("About "+candidate.name);
			$.mobile.changePage( "#about" );	
	    }, "json");
	});
	$('#castVote').tap(function(e) {
		e.preventDefault();
		voter.vote = $("#ballot").find("input:checked").attr("value");
       if(voter.vote != undefined)
       {
	       $.post('/api/vote/add/', { 'voter' : voter }, function(data) {
	            //If the vote has been successfully cast, send them to the voted page.
	            if(data.success)
	            {
					$.mobile.changePage( "#results", { transition: "slidedown"} );
					if(timer)
					{
						clearInterval(timer);
						var timer = setInterval(change, 1000);
					}
					else
					{
						var timer = setInterval(change, 1000);
					}
	            }
	            //An extra check to make sure they haven't voted yet, just to be sure.
	            else
	            {
	                alert("You've already voted");
	            }
	        }, "json");    
	   	}
	   	else
	   	{
	   		alert('You must choose a candidate.')
	   	}
	});
	$('#deleteVote').tap(function() {
       $.post('/api/vote/remove/', { 'voter' : voter}, function() {
			alert('Your vote has been deleted');
			$.mobile.changePage( "#two" );			
       });
	});
	if(window.location.hash != '')
	{
		window.location = "/"
	}
});

</script>
<style type="text/css">
	#results div ul {
		margin: 0;
		padding: 0;
	}
	#results div ul li {
		list-style: none;
		margin: 10px;
	}
	#results div .votes {
		display: inline-block;
		height: 50px;
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
	#results div .inline
	{
		padding: 0;
		margin-top: -10px;
		width: 60%;
		display: inline-block;
	}
	#results div .percent
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
	#about-content
	{
		text-align: center;
	}
	#about-content li {
		list-style: none;
	}
</style>

</head>

<body>

<!-- Start of first page: #one -->
<div data-role="page" data-theme="a" id="one">

	<div data-role="header">
		<h1>Sign In</h1>
	</div><!-- /header -->

	<div data-role="content" >
	<p>Welcome to the Toon-town election! Please enter your Voter ID number to continue:</p>
	<input type="text" id="voterId" />
	<a data-role="button" data-ajax="false" id="voterIdSubmit" href="#two">Continue</a>
	</div><!-- /content -->
	<div data-role="footer" data-id="voter" data-position="fixed">
		<h4 class="voterIdNum">Toon-town Election</h4>
	</div><!-- /footer -->	
</div><!-- /page one -->


<!-- Start of second page: #two -->
<div data-role="page" data-theme="a" id="two">	
	<div data-role="header" data-position="fixed">
		<h1>About Each Candidate</h1>
	</div><!-- /header -->
	<ul data-role="listview" data-theme="g">
		<?php foreach ($candidates as $runner) { ?>
		<li><a class="candidateLink" data-ajax="false" data-candidate="<?php Load::link($runner); ?>" href="#about"><?php Load::icon($runner); ?> <?php Load::name($runner); ?></a></li>
		<?php } ?>
	</ul>
	<p><a data-role="button" href="#vote">Continue on to Cast Your Vote</a></p>
	<div data-role="footer" data-id="voter" data-position="fixed">
		<h4 class="voterIdNum"></h4>
	</div><!-- /footer -->
</div><!-- /page two -->


<!-- Start of third page: #popup -->
<div data-role="page" data-theme="a" id="about">
	<div data-role="header" id="about-header" data-position="fixed">
		<a data-direction="reverse" data-role="button" data-icon="back" href="#two">Back</a>
		<h1></h1>
	</div><!-- /header -->

	<div data-role="content" id="about-content">	
	    <img id="image">
	    <p id="statement"></p>
	    <ul>
	        <li></li>
	    </ul>
	</div><!-- /content -->
	<div data-role="footer" data-id="voter" data-position="fixed">
		<h4 class="voterIdNum"></h4>
	</div><!-- /footer -->
</div><!-- /page popup -->


<div data-role="page" data-theme="a" id="vote">

	<div data-role="header" data-position="fixed">
		<h1>Cast Your Vote <span class="voterIdNum"></span></h1>
	</div><!-- /header -->

	<div data-role="content">				
		<div id="ballot" data-role="fieldcontain">
					<?php 
						$count = 0;
						foreach($candidates as $running) { ?>
					<input type="radio" name="voter" data-inline="true" id="checkbox-<?php echo $count; ?>" class="custom" value="<?php Load::id($running); ?>" />
					<label for="checkbox-<?php echo $count; ?>">Vote For <?php Load::name($running); ?></label>
					<?php $count++; } ?>
		</div>
		<p><a id="castVote" data-ajax="false"  data-role="button">Click to Cast Your Vote</a></p>
	</div>
	<div data-role="footer" data-id="voter" data-position="fixed">
		<h4 class="voterIdNum"></h4>
	</div><!-- /footer -->
</div><!-- /page popup -->
<div data-role="page" data-theme="a" id="results">

	<div data-role="header" data-position="fixed">
		<h1>Voting Results</h1>
	</div><!-- /header -->

	<div data-role="content">
			<ul>
			<?php foreach($candidates as $name) { ?>
				<li>
					<ul id="<?php Load::link($name); ?>" class="candidate">
						<li class="icon"><?php Load::icon($name); ?>
						<div class="inline"><span class="percent">0%</span> <span class="votes"></span></div>
					</ul>
				</li>
			<?php } ?>
			</ul>
		<div>
			<p>Votes: <span id="totals">0</span></p>
			<p><a href="#" id="deleteVote" data-role="button" data-icon="delete" id="deleteVote">Delete My Vote</a></p>
		</div>
	</div>
	<div data-role="footer" data-id="voter" data-position="fixed">
		<h4 class="voterIdNum"></h4>
	</div><!-- /footer -->
</div>
	
<!-- Start of WARNING popup menu ------------------------------------------------------------------------------->
<div data-role="page" data-theme="a" id="warning">

	<div data-role="header">
		<h1>WARNING!</h1>
	</div><!-- /header -->

	<div data-role="content">	
		<div data-role="controlgroup">
            <p>The only valid voter numbers are 1001 - 1049. Please enter your number again or try a different valid entry.</p>
            
            <a href="#one" data-role="button">Retry</a>            
        </div>	
	</div><!-- /content -->
	
	<div data-role="footer">
		<h1>WARNING!</h1>
	</div><!-- /footer -->
</div><!-- /page ------------------------------------------------------------------------------------------------>


</body>
</html>