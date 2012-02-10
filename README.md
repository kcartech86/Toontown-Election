# API STuff #
  
This is some stuff that you're going to need to use for your javascript stuff


## API Calls for voting ##

__/**__  
 __* The following assumes that the voters information is set up as follows...__  
 __*/__  

var votes  = new Object;  
votes.id   = 1001;  
votes.vote = 1; _//This one's only needed for the /add/ one._  
  
  
__/**__  
 __* This code adds the users vote to the database.__ 
 __*/__
$.post('/api/vote/add/', { voter : votes}, function(data) {  
	_//data.success = true if it worked, false if they already voted._  
}, "json");  
  
__/**__  
 __* This code checks to see if the user has voted or not.__  
 __*/__
$.post('/api/vote/check/', { voter : votes}, function(data) {  
	_//data.success = true if they've voted, false if they haven't._  
}, "json");  
  
__/**__  
 __* This code removes the users vote to the database.__  
 __*/__  
$.post('/api/vote/remove/', { voter : votes}, function(data) {  
	_//data.success = returns true no matter what._  
}, "json");

## Pre-defined variables ##
  
__$candidates__ is an array that holds all the candidates. So to loop through them you would do...  
  
  foreach($candiates as $candidate)  
  {  
  	echo $candidate->id . "<br />";  
  	echo $candidate->name . "<br />";  
  	echo $candidate->message . "<br />";  
  	echo $candidate->image . "<br /><br />";  
  }  
   
__$candidate__ is an object that will do the same as above for a single candidate by calling the following:  
  
  $candidate->getInfo(1); //This will get Finn and Jake since they're id 1. 2 is Tommy Pickles and 3 is Darkwing Duck.  