

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
			var thishtml='<table>';
			thishtml+='<tr><td>Organization Num:</td><td>'+selectedItemValue.organization_num+'</td></tr>';
			thishtml+='<tr><td>Organization Name:</td><td>'+selectedItemValue.organization_name+'</td></tr>';
			thishtml+='</table>';
		
			$("#resultsdiv").html(thishtml);
			
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
	if($("#expedition_sponsor_organization").val()==""){
		$("#resultsdiv").html("");
	}
	//clear hidden
	$("#expedition_hidden_sponsor_organization").val("");
});