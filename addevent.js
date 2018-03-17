function addEventAjax(event){
    var eventtitle = document.getElementById("title").value; // Get the username from the form
	var eventdescription = document.getElementById("description").value;
    var eventdate = document.getElementById("date").value;
    console.log(eventdate);
    var eventyear = parseInt(eventdate.substring(0,4));
    var eventmonth = parseInt(eventdate.substring(5,7));
    var eventday = parseInt(eventdate.substring(8,10));
    var dataString = "eventtitle=" + encodeURIComponent(eventtitle) + "&eventdescription=" + encodeURIComponent(eventdescription)+ "&eventyear="+encodeURIComponent(eventyear)+ "&eventmonth="+encodeURIComponent(eventmonth)+"&eventday="+encodeURIComponent(eventday);
    var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "addevent.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("Event successfully added");
			$("#addevent").show();
		}else{
			alert("Event not added  "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
    
}
document.getElementById("submitnewevent").addEventListener("click", addEventAjax, false);