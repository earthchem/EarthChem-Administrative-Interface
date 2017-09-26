
$( function() {

	$( "#searchbox" ).keyup(function() {
	  doSearch();
	});

} );




var updateRightSide = function() {
	
	var selectedObject = $('#objselect').find(":selected").val();
	
	$('#searchbox').val('');
	
	if(selectedObject!=""){
	
		$('#newbutton').show();
		$('#searchboxwrapper').show();
		$("#searchlist").html("");
		$("#rightwrapper").html("");
		hideBottomButtons();
	
	}else{
		
		$('#newbutton').hide();
		$('#searchboxwrapper').hide();
		$("#searchlist").html("");
		$("#rightwrapper").html("");
		hideBottomButtons();
	
	}

}


var hideObjectDetails = function() {
	$('#objectdetails').hide("slow");
	$('#showDetailsButtonDiv').show();
	$('#hideDetailsButtonDiv').hide();
}

var showObjectDetails = function() {
	$('#showDetailsButtonDiv').hide();
	$('#hideDetailsButtonDiv').show();
	$('#objectdetails').css("display:block;");
}



var showBottomButtons = function() {
	$('#bottombuttons').show();
}

var hideBottomButtons = function() {
	$('#bottombuttons').hide();
}

var showDeleteButton = function() {
	$('#deletebutton').html('<button class="menubutton" onClick="doDelete();"><span>DELETE</span></button>');
}

var showEditButton = function() {
	$('#editbutton').html('<button class="menubutton" onClick="doEdit();"><span>EDIT</span></button>');
}

var showCancelButton = function() {
	$('#cancelbutton').html('<button class="menubutton" onClick="doCancel();"><span>CANCEL</span></button>');
}

var showSaveButton = function() {
	$('#savebutton').html('<button class="menubutton" onClick="doSave();"><span>SAVE</span></button>');
}


var hideDeleteButton = function() {
	$('#deletebutton').html('<button class="menubuttonoff"><span>DELETE</span></button>');
}

var hideEditButton = function() {
	$('#editbutton').html('<button class="menubuttonoff"><span>EDIT</span></button>');
}

var hideCancelButton = function() {
	$('#cancelbutton').html('<button class="menubuttonoff"><span>CANCEL</span></button>');
}

var hideSaveButton = function() {
	$('#savebutton').html('<button class="menubuttonoff"><span>SAVE</span></button>');
}



var doSearch = function() {

	var val = $('#searchbox').val();
	var url = "";
	
	if(val.length > 0){
	
		var selectedObject = $('#objselect').find(":selected").val();
	
		if(selectedObject=="equipment"){
	
			//$("#rightwrapper").html(val);
			url = "/REST/equipment?query="+val;
	
		}else if(selectedObject=="expedition"){
	
			url = "/REST/expedition?query="+val;
	
		}else if(selectedObject==""){
		
		
	
		}
		
		if(url!=""){
			var thishtml = "";
			$.getJSON(url, function(data){
				if(data.resultcount>0){
					_.each(data.results, function(res){
						
						if(selectedObject=="equipment"){
							thishtml=thishtml+'<div><span class="searchItem" onclick="showStatic(\''+res.equipment_num+'\');">'+res.equipment_name+'</span></div>';
						}else if (selectedObject=="expedition"){
							thishtml=thishtml+'<div><span class="searchItem" onclick="showStatic(\''+res.expedition_num+'\');">'+res.expedition_name+'</span></div>';
						}
					});
				}
				
				if(thishtml!=""){
					thishtml='<fieldset style="border: 1px solid #CDCDCD; padding: 4px; padding-bottom:0px; margin: 8px 0"><legend><strong>Results:</strong></legend>'+thishtml+'</fieldset>';
				}

				$("#searchlist").html(thishtml);
			});
		}
	
	}else{
	
		$("#searchlist").html("");
	
	}

}


var doNew = function() {

	var selectedObject = $('#objselect').find(":selected").val();
	var html = "";
	
	if(selectedObject=="equipment"){
	
		$.get("/templates/equipment_dynamic.html", function(data) {
			$("#rightwrapper").html(data);
			showBottomButtons();
		});
	
	}else if(selectedObject=="expedition"){
	
		$.get("/templates/expedition_dynamic.html", function(data) {
			$("#rightwrapper").html(data);
			showBottomButtons();
		});
	
	}else if(selectedObject==""){
		
		
	
	}
	
	hideEditButton();
	hideDeleteButton();
	showCancelButton();
	showSaveButton();
	

}

var showStatic = function(id) {

	//window.scrollTo(0, 0);
	$("html, body").animate({ scrollTop: 0 }, "fast");
	var selectedObject = $('#objselect').find(":selected").val();
	var html = "";
	
	if(selectedObject!=""){
	
		$.get("/templates/"+selectedObject+"_static.html", function(newpage) {
			$("#rightwrapper").html(newpage);


			//load data from server
			if(selectedObject=="equipment"){
			

			
				$.getJSON("/REST/equipment/"+id, function(data){
					$('#equipmentid').val(data.equipment_num);
					$('#equipment_name').html(data.equipment_name);
				
					$('#model_id').html(data.model_id);
					$('#equipment_serial_num').html(data.equipment_serial_num);
					$('#equipment_inventory_num').html(data.equipment_inventory_num);
					$('#equipment_owner_id').html(data.equipment_owner_id);
					$('#equipment_vendor_id').html(data.equipment_vendor_id);
					$('#equipment_phurchase_date').html(data.equipment_phurchase_date);
					$('#equipment_phurchase_order_num').html(data.equipment_phurchase_order_num);
					$('#equipment_photo_file_name').html(data.equipment_photo_file_name);
					$('#equipment_description').html(data.equipment_description);

					//translate equipment_type_num
					var show_equipment_type = "";
					_.each(equipment_types, function(eqtype){
						if(eqtype.num==data.equipment_type_num){
							show_equipment_type=eqtype.name;
						}
					});
				
					$('#equipment_type_num').html(show_equipment_type);

				});
			
			}else if(selectedObject=="expedition"){

				$.getJSON("/REST/expedition/"+id, function(data){
					
					//console.log(JSON.stringify(data));
					$('#expeditionid').val(data.expedition_num);
					$("#expedition_name").html(data.expedition_name);

					//translate expedition_type_num
					var show_expedition_type_num = "";
					_.each(expedition_types, function(extype){
						if(extype.num==data.expedition_type_num){
							show_expedition_type_num=extype.name;
						}
					});
					
					$('#expedition_type_num').html(show_expedition_type_num);
					
					//get organization name
					if(data.sponsor_organization!=""){
						$.getJSON("/REST/organization/"+data.sponsor_organization, function(orgdata){
							$('#expedition_sponsor_organization').html(orgdata.organization_name);
						});
					}
					
					$("#expedition_description").html(data.description);
					$("#expedition_begin_date").html(data.begin_date_time);
					$("#expedition_end_date").html(data.end_date_time);
					
					
					$("#expedition_identifier").html(data.identifier);
					
					if(data.alternate_names.length > 0){
						$("#expedition_alternate_names").html(data.alternate_names.join(", "));
					}

					//get equipment
					if(data.equipment_nums.length>0){
						_.each(data.equipment_nums, function(eqnum){
							$.getJSON("/REST/equipment/"+eqnum, function(eqdata){
								$("#expedition_equipment").append("<div>"+eqdata.equipment_name+"</div>");
							});
						});
					}


				});

















			}


			showEditButton();
			showDeleteButton();
			hideCancelButton();
			hideSaveButton();
			showBottomButtons();
		});
		


	}else{

	}

}



var doEdit = function() {
	
	var selectedObject = $('#objselect').find(":selected").val();
	var html = "";
	
	var id = $('#'+selectedObject+'id').val();
	
	if(selectedObject!=""){
	
		$.get("/templates/"+selectedObject+"_dynamic.html", function(newpage) {
			$("#rightwrapper").html(newpage);

			//load data from server
			if(selectedObject=="equipment"){
			
				$.getJSON("/REST/equipment/"+id, function(data){
					$('#equipmentid').val(data.equipment_num);
					$('#equipment_name').val(data.equipment_name);
					$('#model_id').val(data.model_id);
					$('#equipment_serial_num').val(data.equipment_serial_num);
					$('#equipment_inventory_num').val(data.equipment_inventory_num);
					$('#equipment_owner_id').val(data.equipment_owner_id);
					$('#equipment_vendor_id').val(data.equipment_vendor_id);
					$('#equipment_phurchase_date').val(data.equipment_phurchase_date);
					$('#equipment_phurchase_order_num').val(data.equipment_phurchase_order_num);
					$('#equipment_photo_file_name').val(data.equipment_photo_file_name);
					$('#equipment_description').val(data.equipment_description);
				
					//turn on appropriate equipment type select value
					//$('#equipment_type_num option[value=data.equipment_type_num]').prop('selected', true)
					//$('#equipment_type_num option[value=data.equipment_type_num]').attr("selected", "selected");
					$("#equipment_type_num").children('[value='+data.equipment_type_num+']').attr('selected', true);
				});
			
			}else if(selectedObject=="expedition"){

				$.getJSON("/REST/expedition/"+id, function(data){
					
					//console.log(JSON.stringify(data));
					$('#expeditionid').val(data.expedition_num);
					$("#expedition_name").val(data.expedition_name);

					$("#expedition_type_num").children('[value='+data.expedition_type_num+']').attr('selected', true);
					
					
					//get organization name
					if(data.sponsor_organization!=""){
						$('#expedition_hidden_sponsor_organization').val(data.sponsor_organization);
						$.getJSON("/REST/organization/"+data.sponsor_organization, function(orgdata){
							$('#expedition_sponsor_organization').val(orgdata.organization_name);
						});
					}
					
					$("#expedition_description").val(data.description);
					$("#expedition_begin_date").val(data.begin_date_time);
					$("#expedition_end_date").val(data.end_date_time);
					
					
					$("#expedition_identifier").val(data.identifier);
					
					if(data.alternate_names.length > 0){
						$("#expedition_alternate_names").val(data.alternate_names.join(", "));
					}

					//get equipment
					
					
					
					if(data.equipment_nums.length>0){
						var thiseqnum=1;
						_.each(data.equipment_nums, function(eqnum){
							console.log("thisequnum: "+thiseqnum);
							$.getJSON("/REST/equipment/"+eqnum, function(eqdata){
								$("#expedition_equipment"+thiseqnum).val(eqdata.equipment_name);
								$("#expedition_hidden_equipment"+thiseqnum).val(eqnum);
								$("#expedition_equipment"+thiseqnum).show();
								thiseqnum++;
							});
						});
					}
					

				});






















			}

			hideEditButton();
			hideDeleteButton();
			showCancelButton();
			showSaveButton();
			showBottomButtons();
		});
		


	}else{

	}

}





var doSave = function() {
	
	var errors = checkForm();
	
	if(errors==""){
	
		var selectedObject = $('#objselect').find(":selected").val();
		var html = "";
	
		if(selectedObject!=""){
	
			if(selectedObject=="equipment"){

				var data = {};

				data.equipment_name = $('#equipment_name').val();
				data.equipment_type_num = $('#equipment_type_num').val();
				data.model_id = $('#model_id').val();
				data.equipment_serial_num = $('#equipment_serial_num').val();
				data.equipment_owner_id = $('#equipment_owner_id').val();
				data.equipment_vendor_id = $('#equipment_vendor_id').val();
				data.equipment_phurchase_date = $('#equipment_phurchase_date').val();
				data.equipment_photo_file_name = $('#equipment_photo_file_name').val();
				data.equipment_description = $('#equipment_description').val();

				var saveJSON = JSON.stringify(data);
				
				console.log(saveJSON);

				var id = $('#equipmentid').val();
			
				if(id!=""){
			
					console.log(id);
				
					//update (PUT)
					var url = "/REST/equipment/"+id;

				
					console.log(saveJSON);
				
					$.ajax({
						type: "PUT",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							showStatic(id);
							$("#successmessage").html('Equipment Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Equipment.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}else{
					
					//save new (POST)
					
					var url = "/REST/equipment";
					
					$.ajax({
						type: "POST",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							
							var id = msg.equipment_num;
							//console.log(msg);
							showStatic(id);
							$("#successmessage").html('Equipment Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Equipment.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
				
				}
			
			}else if(selectedObject=="expedition"){

				var data = {};

				data.expedition_name = $('#expedition_name').val();
				data.expedition_type_num = $('#expedition_type_num').val();


				data.expedition_name = $('#expedition_name').val();
				data.expedition_type_num = $('#expedition_type_num').val();
				data.expedition_sponsor_organization = $('#expedition_hidden_sponsor_organization').val();
				data.expedition_description = $('#expedition_description').val();
				data.expedition_begin_date = $('#expedition_begin_date').val();
				data.expedition_end_date = $('#expedition_end_date').val();
				data.expedition_identifier = $('#expedition_identifier').val();
				
				//expedition_alternate_names alternate_names
				var altnames = [];
				data.alternate_names=[];
				if($('#expedition_alternate_names').val()!=""){
					var thesenames = $('#expedition_alternate_names').val().split(",");
					_.each(thesenames, function(thisname){
						thisname = thisname.trim();
						data.alternate_names.push(thisname);
					});
				}

				//equipment_nums
				data.equipment_nums = [];
				var eqnums = ["1","2","3","4","5","6","7","8","9"];
				_.each(eqnums, function(num){
					if($('#expedition_hidden_equipment'+num).val()!=""){
						data.equipment_nums.push($('#expedition_hidden_equipment'+num).val());
					}
				});
				
				console.log(data);

				var saveJSON = JSON.stringify(data);
				
				console.log(saveJSON);

				var id = $('#expeditionid').val();
			
				
				if(id!=""){
			
					console.log(id);
				
					//update (PUT)
					var url = "/REST/expedition/"+id;

				
					console.log(saveJSON);
				
					$.ajax({
						type: "PUT",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							showStatic(id);
							$("#successmessage").html('Expedition Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Expedition.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
					
				}else{
					
					//save new (POST)
					
					var url = "/REST/expedition";
					
					$.ajax({
						type: "POST",
						url: url,
						contentType: "application/json",
						data: saveJSON,
						success: function (msg) {
							
							var id = msg.expedition_num;
							//console.log(msg);
							showStatic(id);
							$("#successmessage").html('Expedition Saved Successfully.');
							$("#successmessage").fadeIn();
							$("#successmessage").fadeOut(2000);
						},
						error: function (err){
							$("#errormessage").html('There was an error saving Expedition.');
							$("#errormessage").fadeIn();
							$("#errormessage").fadeOut(2000);
						}
					});
				
				}
				
































			}

		}else{

		}
		
	}else{
	
		errors = "Error!\n" + errors;
		alert(errors);

	}

}


var checkForm = function() {

	var errors = "";
	var errordelim = "";
	
	var selectedObject = $('#objselect').find(":selected").val();
	
	if(selectedObject == "equipment"){
	
		//check for integers and existence of required fields.
		if($('#equipment_name').val()==""){
			errors += errordelim+"Equipment name cannot be blank.";
			errordelim = "\n";
		}
		
		if($('#equipment_type_num').val()==""){
			errors += errordelim+"Equipment type cannot be blank.";
			errordelim = "\n";
		}
		
		if($('#model_id').val()!=""){
			if(!isInt($('#model_id').val())){
				errors += errordelim+"Model ID can only be an integer.";
				errordelim = "\n";
			}
		}

		if($('#equipment_serial_num').val()!=""){
			if(!isInt($('#equipment_serial_num').val())){
				errors += errordelim+"Serial number can only be an integer.";
				errordelim = "\n";
			}
		}


	}else if(selectedObject == "expedition"){
	
		if($('#expedition_name').val()==""){
			errors += errordelim+"Expedition name cannot be blank.";
			errordelim = "\n";
		}

		if($('#expedition_type_num').val()==""){
			errors += errordelim+"Expedition type cannot be blank.";
			errordelim = "\n";
		}

		if($('#expedition_hidden_sponsor_organization').val()==""){
			errors += errordelim+"Sponsor organization cannot be blank.";
			errordelim = "\n";
		}





	
	}
	
	return errors;
	
}


var testbutton = function() {
	//$("#errormessage").fadeIn();
	//$("#errormessage").fadeOut(2000);
}


var doCancel = function() {

	var result = confirm("Are you sure?");
	if (result) {
		
		var selectedObject = $('#objselect').find(":selected").val();
		
		var thisid="";
		
		if(selectedObject == "equipment"){
		
			thisid = $('#equipmentid').val();
		
		}else if(selectedObject == "expedition"){
		
			thisid = $('#expeditionid').val();
		
		}
		
		if(thisid!=""){
		
			showStatic(thisid);
		
		}else{
		
			$("#rightwrapper").html("");
			hideBottomButtons();

		}

	}

}


 var addEquipment = function() {
 	var eqnums = ["1","2","3","4","5","6","7","8","9"];
 	var go="yes";
	_.each(eqnums, function(eqnum){
		if(go=="yes"){
			if ($('#expedition_equipment'+eqnum).is(':visible')){
				//console.log(eqnum+" is visible.");
			}else{
				$('#expedition_equipment'+eqnum).show();
				go="no";	
			}
		}
	});
 }






var equipment_types=[];
equipment_types.push({num:1,name:"Ship"});
equipment_types.push({num:2,name:"AUV"});
equipment_types.push({num:3,name:"HOV"});
equipment_types.push({num:4,name:"ROV"});
equipment_types.push({num:5,name:"Submersible / HOV"});
equipment_types.push({num:6,name:"LaboratoryInstrument"});

var expedition_types=[];
//expedition_types.push({num:1,name:"Not Applicable"});
//expedition_types.push({num:2,name:"Unknown"});
expedition_types.push({num:3,name:"Cruise"});
expedition_types.push({num:11,name:"Expedition"});
expedition_types.push({num:12,name:"Field Activity"});
expedition_types.push({num:19,name:"Site Visit"});
expedition_types.push({num:25,name:"Submersible Launch"});




function isInt(value) {
  var x;
  return isNaN(value) ? !1 : (x = parseFloat(value), (0 | x) === x);
}

