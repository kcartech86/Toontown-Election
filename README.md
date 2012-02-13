# API Stuff #
  
This is some stuff that you're going to need to use for your javascript stuff


## API Calls for Voting ##
  
__The following assumes that the voters information is set up as follows...__  

var votes  = new Object;  
votes.id   = 1001;  
votes.vote = 1; _//This one's only needed for the /add/ one._  
  
  
__This code adds the users vote to the database.__  
$.post('/api/vote/add/', { voter : votes}, function(data) {  
	_//data.success = true if it worked, false if they already voted._  
}, "json");  
      
__This code checks to see if the user has voted or not.__  
$.post('/api/vote/check/', { voter : votes}, function(data) {  
	_//data.success = true if they've voted, false if they haven't._  
}, "json");  

$.post('/api/vote/remove/', { voter : votes}, function(data) {  
  _//data.success = returns true no matter what._  
}, "json");

## API Calls for Candidates ##

__The following assumes that the voters information is set up as follows...__  

var input  = new Object;  
input.find   = "Darkwing Duck"; _//Can also be the id number OR lowercase with dashes ("darkwing-duck") _
    
__This code returns all the candidates info (can return single item with '/api/find/cadidate/id').__  
$.post('/api/find/candidate/info', { 'input' : input}, function(candidate) {  
  _//candidate will be an object with all the candidates information. (like candidate.name)_ 
}, "json");

__This code returns the info for ALL the candidates in an array__  
$.post('/api/find/candidate/all' function(candidates) {  
  _//candidates will be an array with candidates objects_  
}, "json");

## Pre-defined Variables ##
  
__$candidates__ is an array that holds all the candidates. So to loop through them you would do...  
  
  foreach($candiates as $candidate)  
  {  
  	echo $candidate->id . "&lt;br /&gt;";                 //Candidates id  
  	echo $candidate->name . "&lt;br /&gt;";               //Name of candidate  
  	echo $candidate->message . "&lt;br /&gt;";            //Candidates campaign message  
    echo $candidate->image . "&lt;br /&gt;&lt;br /&gt;";  //Candidates image location  
    echo $candidate->icon . "&lt;br /&gt;&lt;br /&gt;";   //Candidates icon location  
  	echo $candidate->votes . "&lt;br /&gt;&lt;br /&gt;";  //Candidates number of votes  
  }  
   
__$candidate__ is an object that will do the same as above for a single candidate by calling the following:  
  
  $candidate->getInfo(1); //This will get Finn and Jake since they're id 1. 2 is Tommy Pickles and 3 is Darkwing Duck.

  You can also use $candidate->getInfo("Darkwing Duck") or $candidate->getInfo('tommy-pickles').

__Load__ is a class that will load and echo an objects parameters:
  
  <?php Load::id($candidate); ?> will echo the candidates id.
  <?php Load::image($candidate); ?> will echo the candidates image, already wrapped in an image tag.