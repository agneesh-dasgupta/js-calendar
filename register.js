function registerAjax(event){
	//a
	var username = document.getElementById("newusername").value; // Get the username from the form
	var password = document.getElementById("newpassword").value; // Get the password from the form
	// Make a URL-encoded string for passing POST data:
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "register.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("You were successfully registered");
		}else{
			alert("You were not registered.  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
}
document.getElementById("login_btn2").addEventListener("click", registerAjax, false);