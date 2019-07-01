function approveForm(id){
	$.ajax({
		type: "POST", 
		url: "approve.php",
		data: {formId: id},
		success: function(){
			location.reload(); 
		}
	});
}

function viewGuests(id){
}

function denyForm(id){
	$.ajax({
		type: "POST", 
		url: "deny.php",
		data: {formId: id},
		success: function(){
			location.reload(); 
		}
	});
}

function editForm(){
	
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

function deleteGuests(attendeeId){
	
}

function notifyAtteneePlusOne(email){
	BootstrapDialog.show({
		message: "The following message will be sent to " + email + ":" + "<textarea name='emailMessage' class='form-control'>",
		buttons: [{
			label: 'Send',
			action: function() {
				alert("Email Sent"); 
			}
		}]
	});     
}