$(document).ready(function(){

	//////////////////////////
	//// GLOBAL VARIABLES ////
	//////////////////////////

	var header = ['First Name', 'Last Name', 'Plus One', 'Relation']; 
	var colors = ["rgb(123, 104, 238)", "rgb(152, 251, 152)", "rgb(240, 128, 128)",
				  "rgb(255, 218, 185)", "rgb(216, 191, 216)", "rgb(192, 192, 192)",
				  "rgb(160, 224, 208)", "rgb(0, 255, 255)", "rgb(255, 250, 205)"
	]; 
	

	//////////////////////////
	/////// FUNCTIONS ////////
	//////////////////////////

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
	
	function viewGuests(formId){
		BootstrapDialog.show({
			title: "Guess List", 
			message: "Hello World",
			buttons: [{
				label: "OK",
				action: function(dialogRef){
					dialogRef.close(); 
				}
			}]
		});
	}
	
	function createGuestList(formId){
		table = $("<table></table>"); 
		table.attr("class", "table table-hover table-bordered table-rounded");
		table.append(createTableHeader()); 
	
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

});

