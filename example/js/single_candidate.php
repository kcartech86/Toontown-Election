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
    var input  = new Object;  
    input.find   = "Darkwing Duck"; //You can search by name.
    //input.find = "tommy-pickles"; //Also, by url name
    //input.find = 1;               //And by id number.
    
    $.post('/api/find/candidate/info/', { 'input' : input}, function(candidate) {  
        //The candidate variable will have all the candidates info in it.
        $('h2').html("<img src='"+candidate.icon+"' />"+candidate.id+": "+candidate.name);
        $('p').html(candidate.message);
        $('#image').attr('src', candidate.image);
        $('li').html('Votes: '+candidate.votes);
    }, "json");

});
</script>
</head>

<body>
    <h2></h2>
    <p></p>
    <img id="image">
    <ul>
        <li></li>
    </ul>

</body>
</html>