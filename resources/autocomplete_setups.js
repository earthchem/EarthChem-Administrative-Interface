

var base_options = {

	listLocation: "results",

	ajaxSettings: {
		dataType: "json",
		method: "GET",
		data: {
		}
	},
	
	list: {},


	minCharNumber: 2,
	//theme: "plate-dark",
	requestDelay: 300
};


/*********************************************

Expedition Sponsor Organization

*********************************************/
var expedition_sponsor_organization_options = base_options;
expedition_sponsor_organization_options.url="/REST/organization";
expedition_sponsor_organization_options.getValue = function(element) {return element.organization_name;}
expedition_sponsor_organization_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#expedition_sponsor_organization").getSelectedItemData();
	$("#expedition_hidden_sponsor_organization").val(selectedItemValue.organization_num);
};
		
expedition_sponsor_organization_options.preparePostData = function(data) {
	data.query = $("#expedition_sponsor_organization").val();
return data;
};

$("#expedition_sponsor_organization").easyAutocomplete(expedition_sponsor_organization_options);

$( "#expedition_sponsor_organization" ).keyup(function() {
	//clear hidden
	$("#expedition_hidden_sponsor_organization").val("");
});


/*********************************************

Expedition Equipment

*********************************************/
var eqnums = ["1","2","3","4","5","6","7","8","9"];
_.each(eqnums, function(eqnum){
	var expedition_equipment_options = base_options;
	expedition_equipment_options.url="/REST/equipment";
	expedition_equipment_options.getValue = function(element) {return element.equipment_name;}
	expedition_equipment_options.list.onChooseEvent = function() {
		var selectedItemValue = $("#expedition_equipment"+eqnum).getSelectedItemData();
		$("#expedition_hidden_equipment"+eqnum).val(selectedItemValue.equipment_num);
	};
		
	expedition_equipment_options.preparePostData = function(data) {
		data.query = $("#expedition_equipment"+eqnum).val();
		return data;
	};

	$("#expedition_equipment"+eqnum).easyAutocomplete(expedition_equipment_options);

	$("#expedition_equipment"+eqnum).keyup(function() {
		//clear hidden
		$("#expedition_hidden_equipment"+eqnum).val("");
	});
});


/*********************************************

Method Lab (Organization)

*********************************************/
var method_lab_options = base_options;
method_lab_options.url="/REST/organization";
method_lab_options.getValue = function(element) {return element.organization_name;}
method_lab_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#method_lab").getSelectedItemData();
	$("#method_lab_hidden").val(selectedItemValue.organization_num);
};
		
method_lab_options.preparePostData = function(data) {
	data.query = $("#method_lab").val();
return data;
};

$("#method_lab").easyAutocomplete(method_lab_options);

$( "#method_lab" ).keyup(function() {
	//clear hidden
	$("#method_lab_hidden").val("");
});











































/*







var eqnums = ["1","2","3","4","5","6","7","8","9"];
_.each(eqnums, function(eqnum){
	var expedition_equipment_options = base_options;
	expedition_equipment_options.list.onChooseEvent = function() {
		var selectedItemValue = $("#expedition_equipment"+eqnum).getSelectedItemData();
		$("#expedition_hidden_equipment"+eqnum).val(selectedItemValue.organization_num);
	};
		
	expedition_equipment_options.preparePostData = function(data) {
		data.query = $("#expedition_equipment"+eqnum).val();
		return data;
	};

	$("#expedition_equipment"+eqnum).easyAutocomplete(expedition_equipment_options);

	$("#expedition_equipment"+eqnum).keyup(function() {
		//clear hidden
		$("#expedition_hidden_equipment"+eqnum).val("");
	});
});









var expedition_equipment_options = base_options;
expedition_equipment_options.list.onChooseEvent = function() {
var selectedItemValue = $("#expedition_equipment1").getSelectedItemData();
$("#expedition_hidden_equipment1").val(selectedItemValue.organization_num);
};
		
expedition_equipment_options.preparePostData = function(data) {
data.query = $("#expedition_equipment1").val();
return data;
};

$("#expedition_equipment1").easyAutocomplete(expedition_equipment_options);

$( "#expedition_equipment1" ).keyup(function() {
	//clear hidden
	$("#expedition_hidden_equipment1").val("");
});








var expedition_sponsor_organization_options = {

	url: function(phrase) {
		return "/REST/organization";
	},

	listLocation: "results",

	getValue: function(element) {
		return element.organization_name;
	},

	ajaxSettings: {
		dataType: "json",
		method: "GET",
		data: {
		}
	},

	list: {
		maxNumberOfElements: 10,
		onChooseEvent: function() {
			var selectedItemValue = $("#expedition_sponsor_organization").getSelectedItemData();
			$("#expedition_hidden_sponsor_organization").val(selectedItemValue.organization_num);
		},
		onHideListEvent: function() {
		}
	},

	preparePostData: function(data) {
		data.query = $("#expedition_sponsor_organization").val();
		return data;
	},

	minCharNumber: 2,
	//theme: "plate-dark",
	requestDelay: 300
};

$("#expedition_sponsor_organization").easyAutocomplete(expedition_sponsor_organization_options);

$( "#expedition_sponsor_organization" ).keyup(function() {
	//clear hidden
	$("#expedition_hidden_sponsor_organization").val("");
});

*/

























