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

function viewDetailsForms(){
	
}

function denyForm(){
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

function deleteForm(){
	
}

function deleteGuests(){
	
}

function notifyAtteneePlusOne(){
	
}