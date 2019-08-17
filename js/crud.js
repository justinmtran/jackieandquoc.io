
	var header = ['First Name', 'Last Name', 'Plus One', 'Relation']; 

	//////////////////////////
	/////// FUNCTIONS ////////
	//////////////////////////

	function approveForm(id, name, email){
		$.ajax({
			type: "POST", 
			url: "approve.php",
			data: {formId: id},
			success: function(){
				var body = "Dear " + name + ",\n\n"; 
				body += "We just wanted to let you know that your pre-RSVP was approved. " + 
				"We are so happy to know that you and your party may be attending our special day! " +
				"Please note that formal invitiations will be sent at a later date where you will need to submit a formal RSVP. \n\n" +
				"If you have any questions or concerns about the event, please contact us directly. \n\n" + 
				"Sincerly, \n" + 
				"Jackie & Quoc"; 
		
				sendEmail(email, body); 
				location.reload(); 
			}
		});
	}

	function denyForm(id, name, email){
		$.ajax({
			type: "POST", 
			url: "deny.php",
			data: {formId: id},
			success: function(){
				var body = "Dear " + name + ",\n\n"; 
				body += "We are sorry to let you know that you pre-RSVP form was denied. " + 
				"You may have filled out the form incorrectly or was denied for other reasons. \n\n" +
				"If you believe you have filled the form incorrectly, we suggest that you fill it out again or you can contact us directly. \n\n" + 
				"Sincerly, \n" + 
				"Jackie & Quoc"; 	
				sendEmail(email, body); 
				location.reload(); 
			}
		});


	}
	
	function viewGuests(id){
		var row = $("<div class='row'></div>");
		var col = $("<div class='col-sm-12'></div>");
		var table = createTable(); 

		$.ajax({
			type: "POST", 
			url: "view.php",
			data: {formId: id},
			success: function(response){
				BootstrapDialog.show({
					title: "Guest List", 
					message: row.append(col.append(table.append(response))),
					onshow: function(dialogRef){ dialogRef.setSize(BootstrapDialog.SIZE_WIDE); },
					buttons: [{
						label: "OK",
						action: function(dialogRef){
							dialogRef.close(); 
						}
					}]
				});
			}
		});
	}
	
	function createTable(){
		table = $("<table></table>"); 
		table.attr("class", "table table-hover table-bordered table-rounded");
		table.css("max-width", "inherit;"); 
		table.append(createTableHeader()); 

		return table; 
	}

	function createTableHeader(){
		thead = $("<thead></thead>"); 
		tr = $("<tr></tr>"); 
		for(var i = 0; i < header.length; i++){
			var td = $("<td>" + header[i] + "</td>");
			tr.append(td); 
		}
		thead.append(tr); 
		return thead; 
	}
	
	function viewAttendeeMessage(attendee, message){
	    if(!message || message === "")
	        message = "No message written."; 
	    
		BootstrapDialog.show({
			title: "Message from " + attendee, 
			message: message,
			onshow: function(dialogRef){ dialogRef.setSize(BootstrapDialog.SIZE_SMALL); },
			buttons: [{
				label: "OK",
				action: function(dialogRef){
					dialogRef.close(); 
				}
			}]
		});
	}
	
	function deleteForm(id){
		isDelete = "Are you sure you wish to delete this form?"
		BootstrapDialog.confirm(isDelete, function(result){
			if(result){
				$.ajax({
					type: "POST", 
					url: "delete.php",
					data: {formId: id},
					success: function(){
						location.reload(); 
					}
				});
			}else{
				return false; 
			}
		});
	}

	function sendEmail(email, body){
		$.ajax({
			type: "POST",
			url: "email.php", 
			data: {
				"email" : email, 
				"subject" : "J&Q RSVP", 
				"body" : body
			},
			success: function(response){
				console.log(response); 
			},
			failure: function(response){
				console.log("Unable to send email confirmation.")
			}
		});
	}