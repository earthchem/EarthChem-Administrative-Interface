<?
include("logincheck.php");

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$email = $_SESSION['username'];

function dumpVar($var){
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EarthChem Admin Interface</title>

	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	
	<link rel="stylesheet" href="/resources/style.css">

	<link rel="stylesheet" href="/resources/jquery-ui/jquery-ui.css">
	<link rel="stylesheet" href="/resources/jquery-ui/jquery-ui.theme.css">
	<link rel="stylesheet" type="text/css" href="/resources/fancybox/src/css/core.css">
	
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="/resources/jquery-ui/jquery-ui.js"></script>
	<script src="/resources/fancybox/src/js/core.js"></script>
	<script src="/resources/underscore/underscore.js"></script>
	
	<script src="/resources/ecadmin.js"></script>

	<!-- JS file -->
	<script src="/resources/easyautocomplete/jquery.easy-autocomplete.js"></script> 

	<!-- CSS file -->
	<link rel="stylesheet" href="/resources/easyautocomplete/easy-autocomplete.min.css"> 

	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="/resources/easyautocomplete/easy-autocomplete.themes.min.css"> 

	

</head>
<body>
	
	<div id="wrapper">
		<div class="clearfloat" id="header">
		EarthChem Admin Interface
		</div>
		<div class="loginbar">
			Logged in as <?=$firstname?> <?=$lastname?> - <?=$email?> <a href="/logout">(Logout)</a>
		</div>
	
		<div style="clear:both;"></div>

		<table width="100%">
		
			<tr>
			
				<td valign="top" width="150px;">

					<div id="leftBarContent">
						
						<!--<button onclick="testbutton();">Test Here</button>-->
						
						<div class="selectlabel">Object:</div>

						<select id="objselect" class="ecselect" onchange="updateRightSide();">
							<option value="">Select...</option>
							<option value="analytical_method">Analytical Method</option>
							<option value="chemical_analysis">Chemical Analysis</option>
							<option value="equipment">Equipment</option>
							<option value="expedition">Expedition</option>
						</select>
						
						<div id="newbutton" style="padding-top:20px;display:none;"><button class="menubutton" onClick="doNew();"><span>NEW</span></button></div>
						
						<div id="searchboxwrapper" style="display:block;display:none;">
							<div class="selectlabel" style="padding-top:10px;">Search:</div>
							<div><input type="text" id="searchbox" class="ectextbox" id="searchstring" size="10"></div>
						</div>

						

						<div id="searchlist" style="padding-top:20px;">
						



						
						</div>
						
						
						
						<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					</div>

				</td>
				
				<td valign="top">
				
					<div id="successmessage">
						Saved Successfully!
					</div>
					
					<div id="errormessage">
						There was an error saving!
					</div>
					
					<div id="rightwrapper">
					





































































		













































































					
					</div>


						<div id="bottombuttons" style="text-align:center;padding-left:50px;display:none;">
							<div id="editbutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="doEdit();"><span>EDIT</span></button></div>
							<div id="deletebutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="doDeprecate();"><span>DELETE</span></button></div>
							<div id="cancelbutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="doCancel();"><span>CANCEL</span></button></div>
							<div id="savebutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="doSave();"><span>SAVE</span></button></div>
						</div>


				</td>
			
			</tr>
		
		</table>
		
		
		

					<!---
					<div id="leftBarContent">
						<div class="selectlabel">Object:</div>
						<div class="styled-select slate">
						<select id="objselect">
							<option value="">Select...</option>
							<option value="equipment">Equipment</option>
							<option value="expedition">Expedition</option>
						</select>
						</div>
						<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					</div>
					--->




		
		</div>
		

	</div>

	<script src="/resources/autocomplete_setups.js"></script>






	<div style="display: none;" id="add_organization_hidden">
		<div class="templateHeader">Add New Organization</div>

		<table>
			<tr>
				<td>Organization Name:</td>
				<td>
					<input type="text" id="new_organization_name" size="59" />
				</td>
			</tr>
			<tr>
				<td>Department:</td>
				<td>
					<input type="text" id="new_organization_department" size="59" />
				</td>
			</tr>
			<tr>
				<td>Organization Type:</td>
				<td>
					<select id="new_organization_type">
						<option value="">select...</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Home Page:</td>
				<td>
					<input type="text" id="new_organization_link" size="59" />
				</td>
			</tr>


			<tr>
				<td>City:</td>
				<td>
					<input type="text" id="new_organization_city" size="59" />
				</td>
			</tr>
			<tr>
				<td>State:</td>
				<td>
					<select id="new_organization_state">
						<option value="">select...</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Country:</td>
				<td>
					<select id="new_organization_country">
						<option value="">select...</option>
					</select>
				</td>
			</tr>



			<tr>
				<td>Address:</td>
				<td>
					<input type="text" id="new_organization_address" size="59" />
				</td>
			</tr>
			<tr>
				<td>Description:</td>
				<td>
					<textarea id="new_organization_description" cols="50" rows="7"></textarea>
				</td>
			</tr>



			</table>
			
			<div style="padding-top:30px;padding-left:150px;">
				<div id="cancelmodalbutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="cancelModal();"><span>CANCEL</span></button></div>
				<div id="savemodalbutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="saveNewOrg();"><span>SAVE</span></button></div>
			</div>


		</div>
		

		
	</div>









	<div style="display: none;" id="add_equipment_hidden">

		<div class="templateHeader">New Equipment</div>

		<table>
			<tr>
				<td>Equipment Name:</td>
				<td>
					<input type="text" id="new_equipment_name" size="59" />
				</td>
			</tr>
			<tr>
				<td>Equipment Type:</td>
				<td>
					<select id="new_equipment_type_num">
						<option value="">select...</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Description:</td>
				<td>
					<textarea id="new_equipment_description" cols="50" rows="7"></textarea>
				</td>
			</tr>
			<tr>
				<td>Model ID:</td>
				<td><input type="text" id="new_equipment_model_id" size="59"></td>
			</tr>
			<tr>
				<td>Serial Number:</td>
				<td><input type="text" id="new_equipment_serial_num" size="59"></td>
			</tr>
			<tr>
				<td>Manufacturer:</td>
				<td><input type="text" id="new_equipment_vendor_id" size="59"></td>
			</tr>
			<tr>
				<td>Purchase Date:</td>
				<td><input type="text" id="new_equipment_purchase_date" size="59"></td>
			</tr>
			<tr>
				<td>URL for Photo:</td>
				<td><input type="text" id="new_equipment_photo_file_name" size="59"></td>
			</tr>
			<tr>
				<td>Owner:</td>
				<td><input type="text" id="new_equipment_owner_id" size="59"></td>
			</tr>
		</table>
		
		<div style="padding-top:30px;padding-left:150px;">
			<div id="cancelmodalbutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="cancelModal();"><span>CANCEL</span></button></div>
			<div id="savemodalbutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="saveNewEquip();"><span>SAVE</span></button></div>
		</div>

	</div>





	<div style="display: none;" id="add_analytical_method_hidden">
	
		<div class="templateHeader">Add Analytical Method</div>

		<table>
			<tr>
				<td>Method Name:</td>
				<td>
					<input type="text" id="new_method_name" size="59" />
				</td>
			</tr>
			<tr>
				<td>Method Type:</td>
				<td>
					<select id="new_method_type_num">
						<option value="">select...</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Method Short Name:</td>
				<td>
					<input id="new_method_short_name" size="56"/>
				</td>
			</tr>
			<tr>
				<td>Lab Name:</td>
				<td>
					<input id="new_method_lab" size="56">
				</td>
				<!--
				<td>
					<a class="addnewlink" href="javascript:showNewOrg();">Add New Lab to Database</a>
				</td>
				-->
			</tr>
			<tr>
				<td>Description:</td>
				<td>
					<textarea id="new_method_description" cols="50" rows="7"></textarea>
				</td>
			</tr>
			<tr>
				<td>Link for More Information:</td>
				<td>
					<input id="new_method_link" size="56"/>
				</td>
			</tr>

			</table>

		<div style="padding-top:30px;padding-left:150px;padding-bottom:100px;">
			<div id="cancelmodalbutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="cancelModal();"><span>CANCEL</span></button></div>
			<div id="savemodalbutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="saveNewMeth();"><span>SAVE</span></button></div>
		</div>

		<div style="display:none;">
			<input id="new_method_lab_hidden"/>
		</div>
	
	</div>























</body>
</html>