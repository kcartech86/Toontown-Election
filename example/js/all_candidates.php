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
    
    $.post('/api/find/candidate/all/', function(candidates) {  
        for(i in candidates)
        {
            $('ul').append('<li>'+candidates[i].id+'. <img src="'+candidates[i].icon+'" /> '+candidates[i].name+'</li>');
        }
    }, "json");

});
</script>
</head>

<body>
    <ul></ul>

</body>
</html>