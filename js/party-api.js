$(document).ready(function(){
	// constants
	var MAX_GUESTS = 9; 
	var numOfGuests = 0; 
	
	//{GuestFirst,GuestLast,PlusOneType,GuestRelation,PlusOneFirst,PlusOneLast,PlusOneRelation}
	var guests = { list: [] };
	var header = ['First Name', 'Last Name', 'Plus One', 'Relation', '']; 
	var colors = {
		list: [
			{"color" : "rgb(123, 104, 238)", "isUsed" : false}, 
			{"color" : "rgb(152, 251, 152)", "isUsed" : false}, 
			{"color" : "rgb(240, 128, 128)", "isUsed" : false}, 
			{"color" : "rgb(255, 218, 185)", "isUsed" : false}, 
			{"color" : "rgb(216, 191, 216)", "isUsed" : false}, 
			{"color" : "rgb(192, 192, 192)", "isUsed" : false}, 
			{"color" : "rgb(160, 224, 208)", "isUsed" : false}, 
			{"color" : "rgb(0, 255, 255)", "isUsed" : false}, 
			{"color" : "rgb(255, 250, 205)", "isUsed" : false},
		] 
	};

	var guestDialog = new BootstrapDialog({
		title: "* Do not include the main applicant and be sure to save before submitting the RSVP form.",
		message: function(dialogRef){
			if($("#guestTable").length < 1)
				dialogRef.$modalBody[0].innerHTML = getGuestAPI();		 
		},
		buttons: [{
			icon: 'glyphicon glyphicon-plus',
			label: ' Add Guest',
			cssClass: 'btn-warning btn-admin',
			action: function(dialogRef){ 
				if(numOfGuests < MAX_GUESTS)
					addRow();	 
			}
		}, {
			label: 'Save',
			action: function(dialogRef){
				guests.list.length = 0; 
				saveGuestList(); 
				
				var partyTotal = $("#guestTable > tbody > tr").length; 

				dialogRef.close();
				$("#guestBtn").text("PARTY OF " + (partyTotal +1) + " ").append("<i class='fa fa-check'></i>");
			}
		}],
		autodestroy: false,
		onshown: function(){
			if($("#guestTable > tbody > tr").length < 1){
				addRow(); 
			}		
		}
	}); 

	var guestBtn = $("#guestBtn").click(function(e){
		e.preventDefault(); 
		guestDialog.open(); 
	}); 



	///////////////
	// FUNCTIONS //
	///////////////
	
	function createHeader(){
		var thead = document.createElement('thead');
		thead.setAttribute('class', 'thead-dark'); 
		var tr = document.createElement('tr');
		thead.prepend(tr); 
		
		for (var h = 0; h < header.length; h++) {
			var th = document.createElement('th'); // TABLE HEADER.
			th.innerHTML = header[h];
			tr.appendChild(th);
		}

		return thead; 
	}

	// ADD A NEW ROW TO THE TABLEs
	function addRow() {
		var guestTable = $('#guestTable'); 
		var headers = guestTable.find("thead").find("th"); 
 
		if(guestTable.find('tbody').length < 1){
			guestTable.append("<tbody></tbody>"); 
		}

		var tr = $("<tr></tr>"); 
		var rowColor = getRowColor(); 
		tr.css("background-color", rowColor); 
		guestTable.find('tbody').append(tr); // TABLE ROW.

		for (var i = 0; i < headers.length; i++) {
			var td = $("<td></td>"); 
			td.attr("align", "center"); 
			tr.append(td); 

			switch(headers[i].innerHTML){
                case "First Name": td.append(createInputField("First Name*", "guestfirst[]")); break; 
				case "Last Name": td.append(createInputField("Last Name*", "guestlast[]")); break; 
				case "Plus One": td[0].appendChild(getPlusOneDropdown()); break;
				case "Relation" : td[0].appendChild(getRelationDropdown(-1)); break; 
				default: td[0].appendChild(getRemoveButton()); break; 
			}
		}

		numOfGuests++;
	}

	function addPlusOne(parentRow){
		var headers = $("#guestTable").find("thead").find("th"); 
		var tr = $("<tr></tr>"); 

		tr.css("background-color", parentRow.css("background-color")); 
		parentRow.after(tr); 

		for (var i = 0; i < headers.length; i++) {
			var td = $("<td></td>"); 
			td.attr("align", "center"); 
			tr.append(td); 

			switch(headers[i].innerHTML){
                case "First Name": td.append(createInputField("Plus One First Name*", "plusonefirst[]")); break; 
				case "Last Name": td.append(createInputField("Plus One Last Name*", "plusonelast[]")); break; 
				case "Relation" : td[0].appendChild(getRelationDropdown(1)); break; 
			}
		}
	}
	
	function getRowColor(){
		for(var i = 0; i < colors.list.length; i++){
			if(colors.list[i].isUsed)
				continue; 
			else{
				colors.list[i].isUsed = true; 
				return colors.list[i].color; 
			}
		}

		return null; 
	}

    function createInputField(placeholder, name, value = ""){
		var ele = $("<input></input>")
		ele.attr('type', 'text');
		ele.attr('placeholder', placeholder);
		ele.attr('class', 'form-control'); 
		ele.attr('name', name); 
		ele.attr('value', value); 
	
		return ele; 
	}

	function getPlusOneDropdown(value){
		var dropdown = $("<select></select>")
		dropdown.append("<option value = 0>None</option>"); 
		dropdown.attr("name", "guestplusonetype[]");
		$.ajax({
			type: "POST",
			url: "modules.php", 
			dataType: "html",
			data: { functionName: 'getPlusOneTypeOptions'}, 
			success: function(response){
				dropdown.append(response); 
			} 
		});

		dropdown.change(function(){
			var hasPlusOne = $(this).val(); 
			var row = $(this).closest('tr'); 
			switch(hasPlusOne){
				case '0': {
					removePlusOne(row); 
					$(this).parent().next().find('select').hide(); 
					break; 
				}
				case '1': {
					removePlusOne(row)
					$(this).parent().next().find('select').show(); 
					break; 
				}
				case '2': {
					var relation = $(this).parent().next().find('select').hide(); 
					addPlusOne($(this).closest('tr')); 
				}
			}	
		});

		return dropdown[0]; 
	}

	function getRemoveButton(){
		// ADD A BUTTON.
		var anchor = $("<a></a>"); 
		var icon = $("<i></i>"); 

		// SET INPUT ATTRIBUTE.
		anchor.attr('class', "btn btn-danger"); 
		icon.attr("class", "fa fa-times"); 
		icon.attr("style", "color:white;");  

		// ADD THE BUTTON's 'onclick' EVENT.
		anchor.append(icon); 
		anchor.click(function(){ 
			removeRow(this); 
		});
 
		return anchor[0]; 
    }
    
    function getRelationDropdown(value = 0){
		var dropdown = $("<select></select>");  
		dropdown.attr("name", "guestrelation[]");

		$.ajax({
			type: "POST",
			url: "modules.php", 
			dataType: "html",
			data: { functionName: 'getPlusOneRelationOptions'}, 
			success: function(response){
				dropdown.append(response); 
			} 
		});

		if(value < 0)
			dropdown.attr("style", "display: none;"); 
		else{
			dropdown.val(value); 
			dropdown.find("option[value=" + value + "]").attr("selected", "selected"); 
		}

		return dropdown[0]; 
	}	

	// DELETE TABLE ROW.
	function removeRow(oButton) {
		var button = $(oButton); 
		var row = button.closest('tr'); 
		var color = row.css("background-color"); 
		var plusOne = row.find("select[name='guestplusonetype[]']");

		if(plusOne.val() > 1)
			removePlusOne(row); 

		row.remove(); 
		removeColor(color); 
		numOfGuests--; 
	}

	function removePlusOne(parentRow){
		 var plusOneRow = parentRow.next(); 

		 if(plusOneRow.css("background-color") === parentRow.css("background-color"))
		 	plusOneRow.remove(); 
	}

	function removeColor(color){
		for(var i = 0; i < colors.list.length; i++){
			if(colors.list[i].color === color){
				colors.list[i].isUsed = false; 
			}
		}
	}

	function saveGuestList(){
		var rows = $("#guestTable > tbody > tr"); 

		for(var i = 0; i < rows.length; i++){
			var current = rows.eq(i); 
			var plusOne = rows.eq(i+1); 

			var first = current.find("input[name='guestfirst[]']").val(); 
			var last = current.find("input[name='guestlast[]']").val(); 
			var plusOneType = current.find("select[name='guestplusonetype[]']").val(); 
			var relation = current.find("select:visible[name='guestrelation[]']").val(); 
			var plusOneFirst = plusOneLast = plusOneRelation = $(); 

			if(plusOneType > 1){
				plusOneFirst = plusOne.find("input[name='plusonefirst[]']").val(); 
				plusOneLast = plusOne.find("input[name='plusonelast[]']").val(); 
				plusOneRelation = plusOne.find("select[name='guestrelation[]']").val(); 
				i++; 
			}

			guests.list.push({
				"GuestFirst" : first, 
				"GuestLast" : last, 
				"PlusOneType" : (plusOneType > 0) ? plusOneType : null, 
				"GuestRelation" : (relation != undefined) ? relation : null, 
				"PlusOneFirst" : (plusOneFirst.length > 0) ? plusOneFirst : null, 
				"PlusOneLast" : (plusOneLast.length > 0) ? plusOneLast : null, 
				"PlusOneRelation" : (plusOneRelation.length > 0) ? plusOneRelation : null
			});

			numOfGuests = guests.list.length; 
		}
	}

	function getGuestAPI(){ 
		return "<div class='row'>" + 
				"<div class='col-sm-12' style='max-height: 300px; overflow: auto;'>" +
					"<table id='guestTable' class='table table-hover table-bordered table-rounded' style='border: none;'>" +
					"<thead>" + createHeader().innerHTML + "</thead>" +  
				"</div>" + 
			"</div>";
	}

	/*------------------------------------------
        = RSVP FORM SUBMISSION
    -------------------------------------------*/
    if ($("#rsvp-form").length){ 
        $("#rsvp-form").validate({
            rules: {
                first: {
                    required: true,
                    minlength: 2
                },
				last: {
                    required: true,
                    minlength: 2
                },
				attendstatus:  {
					required: true
				},
				relationship:  {
					required: true
				}
            },

            messages: {
                first: "Please enter your first name",
                last: "Please enter your last name",				
				attendstatus: "Are you attending?", 
				relationship: "Select your relationship to the couple",
				phone: "Please enter a 10-digit phone number"
            },

            submitHandler: function(form) {
                $("#loader").css("display", "inline-block");
                $.ajax({
                    type: "post",
                    url: "submit.php",
                    data: {
						first: $("input[name=first]").val(),
                        last: $("input[name=last]").val(),
                        phone : $("input[name=phone]").val(),
                        email : $("input[name=email]").val(), 
                        relationship : $("select[name=relationship]").val(),
						guest: guests.list
					},
                    success: function() {
						//sendPendingEmail(); 
						resetForm(); 		
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        failure(); 
                    }
                });
				
                return false; // required to block normal submit since you used ajax
            }

        });
	}

	function resetForm(){
		document.getElementById("rsvp-form").reset(); 	
		$("#guestTable > tbody").empty(); 	
		$("#guestBtn").text("ADD GUESTS");
		saveGuestList(); 

		success(); 
	}

	function success(){
		$("#loader").hide();
		$("#success").slideDown("slow");
		setTimeout(function() {
			$("#success").slideUp("slow");
		}, 3000);
	}
	
	function failure(){
		$("#loader").hide();
		$("#error").slideDown("slow");
		setTimeout(function() {
			$("#error").slideUp("slow");
		}, 3000);
	}
	
	/*=========================================
		SUBMISSION CONFIRMATION EMAIL 
	===========================================*/
	function sendPendingEmail(){
		var email = $("input[name=email]").val(); 
		var name = $("input[name=first]").val(); 
		var body = "Dear " + name + ",\n\n"; 
		body += "Your RSVP form is now pending for you to complete and review at https://www.jandqsayido.com. \n" + 
				"To view your form, enter your passcode (provided on your invitation) in the 'RSVP' section of our website.  \n\n" + 
				"Sincerly, \n" + 
				"Jackie & Quoc"

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
				console.log("unable to send email confirmation.")
			}
		});
	}
});