
var guestHeader = ['First Name', 'Last Name', 'Plus One', 'Relation'];
var partyOptionsHeader = ['First Name', 'Last Name', 'Status', 'Meal'] 

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
			body += "We just wanted to let you know that your RSVP was approved. " + 
			"We are so happy to know that you and your party will be attending our special day! \n\n" +
			"If you have any questions or concerns about the event, please contact us directly. \n\n" + 
			"Sincerly, \n" + 
			"Jackie & Quoc"; 
	
			//sendEmail(email, body); 
			location.reload(); 
		}
	});
}

function pendForm(id){
	$.ajax({
		type: "POST", 
		url: "pend.php",
		data: {formId: id},
		success: function(){
			location.reload(); 
		}
	});
}

/* // NO LONGER NEEDED
function denyForm(id, name, email){
	$.ajax({
		type: "POST", 
		url: "deny.php",
		data: {formId: id},
		success: function(){
			var body = "Dear " + name + ",\n\n"; 
			body += "We are sorry to let you know that you RSVP form was denied. " + 
			"You may have filled out the form incorrectly or was denied for other reasons. \n\n" +
			"Please sign in with your passcode and fix your form. \n\n" + 
			"Sincerly, \n" + 
			"Jackie & Quoc"; 	
			sendEmail(email, body); 
			location.reload(); 
		}
	});
}
*/

function viewGuests(id){
	var row = $("<div class='row'></div>");
	var col = $("<div class='col-sm-12'></div>");
	var table = createTable(guestHeader); 

	$.ajax({
		type: "POST", 
		url: "guest_list.php",
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

function viewPartyOptions(passcode, message){
	var row = $("<div class='row'></div>");
	var col = $("<div class='col-sm-12'></div>");
	var table = createTable(partyOptionsHeader); 

	$.ajax({
		type: "POST",
		url: "party_options.php",
		data: { "passcode" : passcode},
		success: function(response){
			BootstrapDialog.show({
				title: "Party Options", 
				message: row.append(col.append(table.append(response))),
				onshow: function(dialogRef){ 
					dialogRef.setSize(BootstrapDialog.SIZE_WIDE); 
					dialogRef.$modalBody.find('select').attr('disabled', 'disabled');

					// add dietary restrictions
					var container = $("<div></div>"); 
					var label = $("<p>Dietary Restriction:</label>"); 
					var dietaryRestriction = $("<textarea style='width: 100%'></textarea>");
					dietaryRestriction.val(message);  
					container.append(label).append(dietaryRestriction); 

					dialogRef.$modalBody.append(container); 
				},
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

function createTable(headerArray){
	table = $("<table></table>"); 
	table.attr("class", "table table-hover table-bordered table-rounded");
	table.css("max-width", "inherit;"); 
	table.append(createTableHeader(headerArray)); 

	return table; 
}

function createTableHeader(headerArray){
	thead = $("<thead></thead>"); 
	tr = $("<tr></tr>"); 
	for(var i = 0; i < headerArray.length; i++){
		var td = $("<td>" + headerArray[i] + "</td>");
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
			console.log("email sent."); 
		},
		failure: function(response){
			console.log("Unable to send email confirmation.")
		}
	});
}