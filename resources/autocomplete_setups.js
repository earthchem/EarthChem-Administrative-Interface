

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
chemical_analysis_method
chemical_analysis_lab
chemical_analysis_equipment
chemical_analysis_analyst
*/

var thisitem="";

/*********************************************

Chemical Analysis Method

*********************************************/
thisitem="chemical_analysis_method";
var chemical_analysis_method_options = base_options;
chemical_analysis_method_options.url="/REST/method";
chemical_analysis_method_options.getValue = function(element) {return element.method_name;}
chemical_analysis_method_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#chemical_analysis_method").getSelectedItemData();
	$("#chemical_analysis_method_hidden").val(selectedItemValue.method_num);
};
		
chemical_analysis_method_options.preparePostData = function(data) {
	data.query = $("#chemical_analysis_method").val();
	return data;
};

$("#chemical_analysis_method").easyAutocomplete(chemical_analysis_method_options);

$( "#chemical_analysis_method" ).keyup(function() {
	//clear hidden
	$("#chemical_analysis_method_hidden").val("");
});


/*********************************************

Chemical Analysis Lab

*********************************************/
thisitem="chemical_analysis_lab";
var chemical_analysis_lab_options = base_options;
chemical_analysis_lab_options.url="/REST/organization";
chemical_analysis_lab_options.getValue = function(element) {return element.organization_name;}
chemical_analysis_lab_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#chemical_analysis_lab").getSelectedItemData();
	$("#chemical_analysis_lab_hidden").val(selectedItemValue.organization_num);
};
		
chemical_analysis_lab_options.preparePostData = function(data) {
	data.query = $("#chemical_analysis_lab").val();
	return data;
};

$("#chemical_analysis_lab").easyAutocomplete(chemical_analysis_lab_options);

$( "#chemical_analysis_lab" ).keyup(function() {
	//clear hidden
	$("#chemical_analysis_lab_hidden").val("");
});


/*********************************************

Chemical Analysis Equipment

*********************************************/
thisitem="chemical_analysis_equipment";
var chemical_analysis_equipment_options = base_options;
chemical_analysis_equipment_options.url="/REST/equipment";
chemical_analysis_equipment_options.getValue = function(element) {return element.equipment_name;}
chemical_analysis_equipment_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#chemical_analysis_equipment").getSelectedItemData();
	$("#chemical_analysis_equipment_hidden").val(selectedItemValue.equipment_num);
};
		
chemical_analysis_equipment_options.preparePostData = function(data) {
	data.query = $("#chemical_analysis_equipment").val();
	return data;
};

$("#chemical_analysis_equipment").easyAutocomplete(chemical_analysis_equipment_options);

$( "#chemical_analysis_equipment" ).keyup(function() {
	//clear hidden
	$("#chemical_analysis_equipment_hidden").val("");
});


/*********************************************

Chemical Analysis Analyst

*********************************************/
thisitem="chemical_analysis_analyst";
var chemical_analysis_analyst_options = base_options;
chemical_analysis_analyst_options.url="/REST/personaffiliation";
chemical_analysis_analyst_options.getValue = function(element) {return element.person_name+' - '+element.organization_name;}
chemical_analysis_analyst_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#chemical_analysis_analyst").getSelectedItemData();
	$("#chemical_analysis_analyst_hidden").val(selectedItemValue.affiliation_num);
};
		
chemical_analysis_analyst_options.preparePostData = function(data) {
	data.query = $("#chemical_analysis_analyst").val();
	return data;
};

$("#chemical_analysis_analyst").easyAutocomplete(chemical_analysis_analyst_options);

$( "#chemical_analysis_analyst" ).keyup(function() {
	//clear hidden
	$("#chemical_analysis_analyst_hidden").val("");
});




/*
thisitem="chemical_analysis_equipment";
var chemical_analysis_equipment_options = base_options;
chemical_analysis_equipment_options.url="/REST/equipment";
chemical_analysis_equipment_options.getValue = function(element) {return element.equipment_name;}
chemical_analysis_equipment_options.list.onChooseEvent = function() {
	var selectedItemValue = $("#"+thisitem).getSelectedItemData();
	$("#"+thisitem+"_hidden").val(selectedItemValue.equipment_num);
};
		
newoptions.preparePostData = function(data) {
	data.query = $("#"+thisitem).val();
	return data;
};

$("#"+thisitem).easyAutocomplete(chemical_analysis_equipment_options);

$( "#"+thisitem ).keyup(function() {
	//clear hidden
	$("#"+thisitem+"_hidden").val("");
});
*/



































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

























