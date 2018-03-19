function logoutAjax(event){
    var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("GET", "logout.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You have been logged out");
            $("#addevent").hide();
            //$("#logout").hide();
		}else{
			alert("You were not logged out.  "+jsonData.message);
		}
	}, false);
    xmlHttp.send(null);
}
document.getElementById("logout_button").addEventListener("click", logoutAjax, false);