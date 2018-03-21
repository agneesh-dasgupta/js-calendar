function edit(event){
    var newTitle = document.getElementById("edittitle").value;
    var newDescription = document.getElementById("editdescription").value;
    var newDate = document.getElementById("editdate").value;
    var newTime = document.getElementById("edittime").value;
    var eventid = event.target.className;
    var eventyear = parseInt(newDate.substring(0,4));
    var eventmonth = parseInt(newDate.substring(5,7));
    var eventday = parseInt(newDate.substring(8,10));
    var dataString = "eventtitle=" + encodeURIComponent(newTitle) + "&eventdescription=" + encodeURIComponent(newDescription)+ "&eventyear="+encodeURIComponent(eventyear)+ "&eventmonth="+encodeURIComponent(eventmonth)+"&eventday="+encodeURIComponent(eventday)+"&eventid="+encodeURIComponent(eventid)+"&eventtime="+encodeURIComponent(newTime);
    var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "updateEvent.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){  // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			alert("Event successfully updated");
		}else{
			alert("Event not updated "+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
    makeCalendar();
}
document.getElementById("submitedit").addEventListener("click", edit, false);