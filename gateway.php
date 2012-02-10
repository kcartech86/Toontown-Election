<?php
	
	$page = $_GET['page'];
	$file = 'process/'.$page.'-snippet.php';
	if(file_exists($file)) 
	{ 
		require_once($file);
	} 
	else 
	{ 
		header("HTTP/1.0 404 Not Found");
	}