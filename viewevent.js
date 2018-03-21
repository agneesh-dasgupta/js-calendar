function editAjax(event){
    var eventid = event.target.id;
    var dataString = "eventid=" + encodeURIComponent(eventid);
     var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
	xmlHttp.open("POST", "editEvent.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
		if(jsonData.success){// in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
			$('#edittitle').val(jsonData.eventTitle);
            $('#editdescription').val(jsonData.eventDescription);
            var editMonth = jsonData.eventMonth;
            if(jsonData.eventMonth < 10){
                editMonth = "0"+editMonth;
            }
            var editDate = jsonData.eventDay;
            if(jsonData.eventDay < 10){
                editDate = "0"+editDate;
            }
            var fullDate = jsonData.eventYear + "-" +editMonth+ "-" + editDate;
            $('#editdate').val(fullDate);
		}else{
			alert("Event not deleted"+jsonData.message);
		}
	}, false); // Bind the callback to the load event
	xmlHttp.send(dataString); // Send the data
         $('#edit_dialog').dialog();
}