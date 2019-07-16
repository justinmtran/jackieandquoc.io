$(document).ready(function(){
	// Global Variables
	var arrHead = new Array(); 
	var guests = { list: [] }; 
	var plusOneRelationsOptions = ""; 

	// set header
	arrHead = ['First Name', 'Last Name', 'Plus One?', 'Relation to Plus One', '']; 

	// add event handler to the guest button (dialog for guest API window)
	var guestBtn = $("#guestBtn"); 
	guestBtn.click(function(e){
		e.preventDefault(); 
		openGuestDialog(); 
	});

	var dialog = new BootstrapDialog({
		title: "Guest Form",
		message: function(dialogRef){
			if($("#guestTable").length < 1)
				dialogRef.$modalBody[0].innerHTML = getGuestAPI();		 
		},
		buttons: [{
			icon: 'glyphicon glyphicon-plus',
			label: ' Add Guest',
			cssClass: 'btn-warning btn-admin',
			action: function(dialogRef){ addRow(); }
		}, {
			label: 'Save',
			action: function(dialogRef){
				guests.list.length = 0; // empty array. 
				$("#guestTable > tbody > tr").each(function(){
					var first = $(this).find("[name='guest_first[]']").val(); 
					var last = $(this).find("[name='guest_last[]']").val();
					var isPlusOne = ($(this).find("[name='guest_isPlusOne[]']").is(':checked')) ? true : false; 
					var relation = (isPlusOne) ? $(this).find("[name='guest_relation[]']").val() : 0; 

					guests.list.push({
						"First" : first, 
						"Last" : last,
						"IsPlusOne" : isPlusOne, 
						"Relation" : relation
					}); 
				});

				$("#guestBtn").text((guests.list.length > 1) ? guests.list.length + " GUESTS ADDED  " : guests.list.length + " GUEST ADDED  " )
							  .append("<i class='fa fa-check'></i>");
				 

				dialogRef.close();
			}
		}],
		autodestroy: false,
		onshown: function(){
			if($("#guestTable > tbody > tr").length < 1)
				addRow(); 
		}
	});
		
	///////////////
	// FUNCTIONS //
	///////////////
	
	function createHeader(){
		var thead = document.createElement('thead');
		thead.setAttribute('class', 'thead-dark'); 
		var tr = document.createElement('tr');
		thead.prepend(tr); 
		
		for (var h = 0; h < arrHead.length; h++) {
			var th = document.createElement('th'); // TABLE HEADER.
			th.innerHTML = arrHead[h];
			tr.appendChild(th);
		}

		return thead; 
	}

	// ADD A NEW ROW TO THE TABLEs
	function addRow() {
		var guestTable = $('#guestTable'); 
 
		if(guestTable.find('tbody > tr').length > 8) // can't add more then 9 guests
			return; 
		else if(guestTable.find('tbody').length < 1){
			guestTable.append("<tbody></tbody>"); 
		}
			

		var tr = $("<tr></tr>"); 
		guestTable.find('tbody').append(tr); // TABLE ROW.

		for (var i = 0; i < arrHead.length; i++) {
			var td = $("<td></td>"); 
			td.attr("align", "center"); 
			tr.append(td); 
            
			switch(i){
                case 0: td[0].appendChild(getInputField("First Name*", "guest_first[]")); break; 
				case 1: td[0].appendChild(getInputField("Last Name*", "guest_last[]")); break; 
				case 2: td[0].appendChild(getCheckBox()); break; 
				case 3: td[0].appendChild(getDropdown()); break; 
				case 4: td[0].appendChild(getRemoveButton()); break; 
			}
		}
    }

    function getInputField(inputValue, name, value = ""){
		var ele = $("<input></input>")
		ele.attr('type', 'text');
		ele.attr('placeholder', inputValue);
		ele.attr('class', 'form-control'); 
		ele.attr('name', name); 
		ele.attr('value', value); 
	
		return ele[0]; 
	}

	function getCheckBox(isChecked = false){
		var chkbx = document.createElement('input'); 
		chkbx.setAttribute('type', 'checkbox');
        chkbx.setAttribute("name", "guest_isPlusOne[]")
		chkbx.addEventListener("change", function(){
			var dropDown = $(this).closest('tr').find('select'); 
			var isVisible = dropDown.is(":visible"); 
			
			if(isVisible)
				dropDown.hide(); 
			else
				dropDown.show(); 
		}); 
		
		if(isChecked)
		chkbx.setAttribute("checked", "checked"); 
			
		return chkbx; 
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
    
    function getDropdown(value = 0){
		var dropDown = $("<select></select>");  
		dropDown.attr("name", "guest_relation[]");
		 
		dropDown.append(plusOneRelationsOptions); 

		$.ajax({
			type: "POST",
			url: "modules.php", 
			dataType: "html",
			data: { functionName: 'getPlusOneRelationOptions'}, 
			success: function(response){
				dropDown.append(response); 
			} 
		});

		if(value < 1)
			dropDown.attr("style", "display: none;"); 
		else{
			dropDown.val(value); 
			dropDown.find("option[value=" + value + "]").attr("selected", "selected"); 
		}

		
		return dropDown[0]; 
	}	

	// DELETE TABLE ROW.
	function removeRow(oButton) {
		var guestTable = document.getElementById('guestTable');
		guestTable.deleteRow(oButton.parentNode.parentNode.rowIndex);       // TD -> TR -> BUTTON
	}

	// OPEN GUEST API
	function openGuestDialog(){
		dialog.open();   
	}

	function getGuestAPI(){ 
		return "<div class='row'>" + 
				"<div class='col-sm-12' style='max-height: 300px; overflow: auto;'>" +
					"<table id='guestTable' class='table table-hover table-bordered table-rounded' style='border: none;'>" +
					"<thead>" + createHeader().innerHTML + "</thead>" +  
				"</div>" + 
			"</div>";
	}
});

