<?php require_once("../../config/config.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Project 02</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript">
/**
 * IN NO WAY IS THIS HOW TO HANDLE THE REAL THING, JUST SOME EXAMPLES OF 
 * HOW TO USE THE API
 */
$(document).ready(function() {
    //This is the object that's going to hold the voters information.
    var voter = new Object();

    //Hiding the voting div.
    $('#voting').hide();
    //Hiding the voted div.
    $('#voted').hide();

    //If they want to delete a vote.
    $('#delete').click(function() {
       voter.id= $('#delete_input').val();
       //The delete api deletes the vote no matter what, so no need to check it.
       $.post('/api/vote/remove/', { 'voter' : voter}, function() {
           alert('Vote deleted');
       });
    });

    //If they want to add a vote, they "sign in" with their voter id
    $('#voter_form input:last-child').click(function() {
        voter.id = $(this).prev().val();

        //Checks to make sure they haven't voted already.
        $.post('/api/vote/check/', { 'voter' : voter}, function(data) {
            //If it comes back that they've already voted, let them know.
            if(data.success)
            {
                alert("You've already voted");
            }
            //If they haven't, then fade out the sign in div and fade in the voting one.
            else 
            {
                $('#voter').fadeOut(function() {
                   $('#voting').fadeIn(); 
                });                        
            }
        }, "json");
        return false;
    });

    //When they click on vote button for a candidate.
    $('.v_btn').click(function() {
        voter.vote = $(this).attr('id');

        $.post('/api/vote/add/', { 'voter' : voter }, function(data) {
            //If the vote has been successfully cast, send them to the voted page.
            if(data.success)
            {
                $('#voting').fadeOut(function() {
                   $('#voted').fadeIn(); 
                });
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
</head>

<body>
    <div id="voter">
        <form id="voter_form">
            <input type="text" /><input type="submit" />
        </form>
        <p>Delete Vote for <input type="text" id="delete_input"><button id="delete">Delete</button></p>
    </div>
    <div id="voting">
        <ul>
            <li>Candidate 1 <button id="1" class="v_btn">Vote</button></li>
            <li>Candidate 2 <button id="2" class="v_btn">Vote</button></li>
            <li>Candidate 3 <button id="3" class="v_btn">Vote</button></li>
        </ul>
    </div>
    <div id="voted">
    </div>
</body>
</html>