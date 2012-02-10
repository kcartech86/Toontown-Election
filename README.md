This is an H1
=============

/**  
 * The following assumes that the voters information is set up as follows...  
 */  

var votes  = new Object;  
votes.id   = 1001;  
votes.vote = 1; //This one's only needed for the /add/ one.  


/**
 * This code adds the users vote to the database.
 */
$.post('/api/vote/add/', { voter : votes}, function(data) {
	//data.success = true if it worked, false if they already voted.
}, "json");

/**
 * This code checks to see if the user has voted or not.
 */
$.post('/api/vote/check/', { voter : votes}, function(data) {
	//data.success = true if they've voted, false if they haven't.
}, "json");

/**
 * This code removes the users vote to the database.
 */
$.post('/api/vote/remove/', { voter : votes}, function(data) {
	//data.success = returns true no matter what.
}, "json");
