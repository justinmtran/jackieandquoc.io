$(document).ready(function(){
	// ARRAY FOR HEADER.
	var arrHead = new Array();
	arrHead = ['First Name', 'Last Name', 'Plus One?', 'Relation to Plus One', '']; // TABLE HEADERS

	// Add Event Handler to Add Guest Button
	// var addGuestBtn = $("#addGuestBtn"); 
	// addGuestBtn.click(function(){
	// 	addRow(); 
	// }); 

	var guestBtn = $("#guestBtn"); 
	guestBtn.click(function(e){
		e.preventDefault(); 
		openGuestDialog(); 
	});
		
	function addHeader(table, header){
		var tr = document.createElement('tr'); 	
		var thead = table.find('thead'); 
		thead.append(tr); 
		
		for (var h = 0; h < header.length; h++) {
			var th = document.createElement('th'); // TABLE HEADER.
			th.innerHTML = header[h];
			tr.appendChild(th);
		}
	}

	// ADD A NEW ROW TO THE TABLEs
	function addRow() {
		var guestTable = $('#guestTable');

		var rowCnt = guestTable.find('tbody').find('tr').length;        // GET TABLE ROW COUNT.
		if(rowCnt > 9){
			return; 
		}
		else if(rowCnt < 1){
			addHeader(guestTable, arrHead);
			rowCnt++; 
		}
		var tr = document.createElement('tr'); 	
		guestTable.find('tbody').append(tr);      // TABLE ROW.

		for (var i = 0; i < arrHead.length; i++) {
			var td = document.createElement('td'); 
			td.setAttribute("align", "center"); 
			tr.append(td); 
			
			switch(i){
				case 0: td.appendChild(getInputField("First Name*", "guest_first[]")); break; 
				case 1: td.appendChild(getInputField("Last Name*", "guest_last[]")); break; 
				case 2: td.appendChild(getRadio()); break; 
				case 3: td.appendChild(getDropdown()); break; 
				case 4: td.appendChild(getRemoveButton()); break; 
			}
		}
	}

	// EXTRACT AND SUBMIT TABLE DATA.
	function submit() {
		var myTab = document.getElementById('guestTable');
		var values = new Array();

		// LOOP THROUGH EACH ROW OF THE TABLE.
		for (row = 1; row < myTab.rows.length - 1; row++) {
			for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.
				var element = myTab.rows.item(row).cells[c];
				
				if (element.childNodes[0].getAttribute('type') == 'text') {
					values.push("'" + element.childNodes[0].value + "'");
				}
			}
		}
		console.log(values);
	}

	function getRemoveButton(){
		// ADD A BUTTON.
		var anchor = document.createElement('a');
		var icon = document.createElement('i'); 

		// SET INPUT ATTRIBUTE.
		anchor.setAttribute('class', "btn btn-danger"); 
		icon.setAttribute("class", "fa fa-times"); 
		icon.setAttribute("style", "color:white;");  

		// ADD THE BUTTON's 'onclick' EVENT.
		anchor.appendChild(icon); 
		anchor.setAttribute('onclick', "removeRow(this)");

		return anchor; 
	}

	function getInputField(inputValue, name){
		var ele = document.createElement('input');
		ele.setAttribute('type', 'text');
		ele.setAttribute('placeholder', inputValue);
		ele.setAttribute('class', 'form-control'); 
		ele.setAttribute("name", name)
		return ele; 
	}

	function getRadio(){
		var radio = document.createElement('input'); 
		radio.setAttribute('type', 'radio');
		radio.setAttribute("name", "guest_isPlusOne[]")
		radio.addEventListener("change", function(){
			$("select").attr("style", "display: none;"); 
			
			var dropDown = $(this).closest('tr').find('select'); 
			var isVisible = dropDown.is(":visible"); 
			
			if(isVisible)
				dropDown.hide(); 
			else
				dropDown.show(); 
		}); 
		return radio; 
	}

	function getDropdown(){
		var dropDown = document.createElement('select'); 
		dropDown.setAttribute("name", "guest_relation[]"); 
		dropDown.setAttribute("style", "display: none;"); 

		var option1 = document.createElement('option');
		option1.append("Pokemon"); 
		var option2 = document.createElement('option'); 
		option2.append("Stranger"); 
		var option3 = document.createElement('option'); 
		option3.append("Imaginary Friend"); 
		
		dropDown.appendChild(option1); 
		dropDown.appendChild(option2); 
		dropDown.appendChild(option3);
		
		return dropDown; 
	}	
});

// DELETE TABLE ROW.
function removeRow(oButton) {
	var guestTable = document.getElementById('guestTable');
	guestTable.deleteRow(oButton.parentNode.parentNode.rowIndex);       // TD -> TR -> BUTTON
	
	// remove header if no rows exist
	if(guestTable.rows.length == 1){
		guestTable.deleteRow(0); 
	}
}

// OPEN GUEST API
function openGuestDialog(){
	var guestData = $("#guestData").find('tbody'); 
	var guestApi = $("<div></div>")
	guestApi.append($.get("guest.html").html()); 
	guestApi.find("table").innerHTML(guestData.html()); 

	BootstrapDialog.show({
		message: Object(guestApi.html()),
		buttons: [{
			icon: 'glyphicon glyphicon-send',
			label: 'Send ajax request',
			cssClass: 'btn-primary',
			autospin: true,
			action: function(dialogRef){
				dialogRef.enableButtons(false);
				dialogRef.setClosable(false);
				dialogRef.getModalBody().html('Dialog closes in 5 seconds.');
				setTimeout(function(){
					dialogRef.close();
				}, 5000);
			}
		}, {
			label: 'Close',
			action: function(dialogRef){
				dialogRef.close();
			}
		}]
	});
}