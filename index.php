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
							<div id="deletebutton" style="float:left;padding-right:20px;"><button class="menubutton" onClick="doDelete();"><span>DELETE</span></button></div>
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
						<option value="1">Not Applicable</option>
						<option value="2">Unknown</option>
						<option value="3">Association</option>
						<option value="4">Center</option>
						<option value="5">College</option>
						<option value="6">Company</option>
						<option value="7">Consortium</option>
						<option value="8">Department</option>
						<option value="9">Division</option>
						<option value="10">Foundation</option>
						<option value="11">Funding Organization</option>
						<option value="12">Government Agency</option>
						<option value="13">Hospital</option>
						<option value="14">Institute</option>
						<option value="15">Laboratory</option>
						<option value="16">Library</option>
						<option value="17">Museum</option>
						<option value="18">Program</option>
						<option value="19">Publisher</option>
						<option value="20">Research organization</option>
						<option value="21">School</option>
						<option value="22">Student Organization</option>
						<option value="23">University</option>
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
						<option value="6">Alabama</option>
						<option value="5">Alaska</option>
						<option value="10">Arizona</option>
						<option value="8">Arkansas</option>
						<option value="11">California</option>
						<option value="12">Colorado</option>
						<option value="13">Connecticut</option>
						<option value="15">Delaware</option>
						<option value="16">Florida</option>
						<option value="17">Georgia</option>
						<option value="19">Hawaii</option>
						<option value="21">Idaho</option>
						<option value="22">Illinois</option>
						<option value="23">Indiana</option>
						<option value="20">Iowa</option>
						<option value="24">Kansas</option>
						<option value="25">Kentucky</option>
						<option value="26">Louisiana</option>
						<option value="29">Maine</option>
						<option value="28">Maryland</option>
						<option value="27">Massachusetts</option>
						<option value="30">Michigan</option>
						<option value="31">Minnesota</option>
						<option value="34">Mississippi</option>
						<option value="32">Missouri</option>
						<option value="35">Montana</option>
						<option value="38">Nebraska</option>
						<option value="42">Nevada</option>
						<option value="39">New Hampshire</option>
						<option value="40">New Jersey</option>
						<option value="41">New Mexico</option>
						<option value="43">New York</option>
						<option value="36">North Carolina</option>
						<option value="37">North Dakota</option>
						<option value="44">Ohio</option>
						<option value="45">Oklahoma</option>
						<option value="46">Oregon</option>
						<option value="47">Pennsylvania</option>
						<option value="49">Rhode Island</option>
						<option value="50">South Carolina</option>
						<option value="51">South Dakota</option>
						<option value="52">Tennessee</option>
						<option value="53">Texas</option>
						<option value="55">Utah</option>
						<option value="58">Vermont</option>
						<option value="56">Virginia</option>
						<option value="59">Washington</option>
						<option value="61">West Virginia</option>
						<option value="60">Wisconsin</option>
						<option value="62">Wyoming</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Country:</td>
				<td>
					<select id="new_organization_country">
						<option value="">select...</option>
						<option value="4">Afghanistan</option>
						<option value="8">Albania</option>
						<option value="12">Algeria</option>
						<option value="16">American Samoa</option>
						<option value="20">Andorra</option>
						<option value="24">Angola</option>
						<option value="660">Anguilla</option>
						<option value="10">Antarctica</option>
						<option value="28">Antigua and Barbuda</option>
						<option value="32">Argentina</option>
						<option value="51">Armenia</option>
						<option value="36">Australia</option>
						<option value="40">Austria</option>
						<option value="31">Azerbaijan</option>
						<option value="44">Bahamas</option>
						<option value="48">Bahrain</option>
						<option value="50">Bangladesh</option>
						<option value="52">Barbados</option>
						<option value="112">Belarus</option>
						<option value="56">Belgium</option>
						<option value="84">Belize</option>
						<option value="204">Benin</option>
						<option value="60">Bermuda</option>
						<option value="64">Bhutan</option>
						<option value="68">Bolivia, Plurinational State of</option>
						<option value="70">Bosnia and Herzegovina</option>
						<option value="72">Botswana</option>
						<option value="74">Bouvet Island</option>
						<option value="76">Brazil</option>
						<option value="86">British Indian Ocean Territory</option>
						<option value="96">Brunei Darussalam</option>
						<option value="100">Bulgaria</option>
						<option value="854">Burkina Faso</option>
						<option value="108">Burundi</option>
						<option value="116">Cambodia</option>
						<option value="120">Cameroon</option>
						<option value="124">Canada</option>
						<option value="132">Cape Verde</option>
						<option value="136">Cayman Islands</option>
						<option value="140">Central African Republic</option>
						<option value="148">Chad</option>
						<option value="152">Chile</option>
						<option value="156">China</option>
						<option value="162">Christmas Island</option>
						<option value="166">Cocos (Keeling) Islands</option>
						<option value="170">Colombia</option>
						<option value="174">Comoros</option>
						<option value="178">Congo</option>
						<option value="180">Congo, the Democratic Republic of the</option>
						<option value="184">Cook Islands</option>
						<option value="188">Costa Rica</option>
						<option value="384">Cote d'Ivoire</option>
						<option value="191">Croatia</option>
						<option value="192">Cuba</option>
						<option value="196">Cyprus</option>
						<option value="203">Czech Republic</option>
						<option value="208">Denmark</option>
						<option value="262">Djibouti</option>
						<option value="212">Dominica</option>
						<option value="214">Dominican Republic</option>
						<option value="218">Ecuador</option>
						<option value="818">Egypt</option>
						<option value="222">El Salvador</option>
						<option value="226">Equatorial Guinea</option>
						<option value="232">Eritrea</option>
						<option value="233">Estonia</option>
						<option value="231">Ethiopia</option>
						<option value="238">Falkland Islands (Malvinas)</option>
						<option value="234">Faroe Islands</option>
						<option value="242">Fiji</option>
						<option value="246">Finland</option>
						<option value="250">France</option>
						<option value="254">French Guiana</option>
						<option value="258">French Polynesia</option>
						<option value="260">French Southern Territories</option>
						<option value="266">Gabon</option>
						<option value="270">Gambia</option>
						<option value="268">Georgia</option>
						<option value="276">Germany</option>
						<option value="288">Ghana</option>
						<option value="292">Gibraltar</option>
						<option value="300">Greece</option>
						<option value="304">Greenland</option>
						<option value="308">Grenada</option>
						<option value="312">Guadeloupe</option>
						<option value="316">Guam</option>
						<option value="320">Guatemala</option>
						<option value="324">Guinea</option>
						<option value="624">Guinea-Bissau</option>
						<option value="328">Guyana</option>
						<option value="332">Haiti</option>
						<option value="334">Heard Island and McDonald Islands</option>
						<option value="336">Holy See (Vatican City State)</option>
						<option value="340">Honduras</option>
						<option value="344">Hong Kong</option>
						<option value="348">Hungary</option>
						<option value="352">Iceland</option>
						<option value="356">India</option>
						<option value="360">Indonesia</option>
						<option value="364">Iran, Islamic Republic of</option>
						<option value="368">Iraq</option>
						<option value="372">Ireland</option>
						<option value="376">Israel</option>
						<option value="380">Italy</option>
						<option value="388">Jamaica</option>
						<option value="392">Japan</option>
						<option value="400">Jordan</option>
						<option value="398">Kazakhstan</option>
						<option value="404">Kenya</option>
						<option value="296">Kiribati</option>
						<option value="408">Korea, Democratic People's Republic of</option>
						<option value="410">Korea, Republic of</option>
						<option value="414">Kuwait</option>
						<option value="417">Kyrgyzstan</option>
						<option value="418">Lao People's Democratic Republic</option>
						<option value="428">Latvia</option>
						<option value="422">Lebanon</option>
						<option value="426">Lesotho</option>
						<option value="430">Liberia</option>
						<option value="434">Libyan Arab Jamahiriya</option>
						<option value="438">Liechtenstein</option>
						<option value="440">Lithuania</option>
						<option value="442">Luxembourg</option>
						<option value="446">Macao</option>
						<option value="807">Macedonia, the former Yugoslav Republic of</option>
						<option value="450">Madagascar</option>
						<option value="454">Malawi</option>
						<option value="458">Malaysia</option>
						<option value="462">Maldives</option>
						<option value="466">Mali</option>
						<option value="470">Malta</option>
						<option value="584">Marshall Islands</option>
						<option value="474">Martinique</option>
						<option value="478">Mauritania</option>
						<option value="480">Mauritius</option>
						<option value="175">Mayotte</option>
						<option value="484">Mexico</option>
						<option value="583">Micronesia, Federated States of</option>
						<option value="498">Moldova, Republic of</option>
						<option value="492">Monaco</option>
						<option value="496">Mongolia</option>
						<option value="500">Montserrat</option>
						<option value="504">Morocco</option>
						<option value="508">Mozambique</option>
						<option value="104">Myanmar</option>
						<option value="516">Namibia</option>
						<option value="520">Nauru</option>
						<option value="524">Nepal</option>
						<option value="528">Netherlands</option>
						<option value="530">Netherlands Antilles</option>
						<option value="540">New Caledonia</option>
						<option value="554">New Zealand</option>
						<option value="558">Nicaragua</option>
						<option value="562">Niger</option>
						<option value="566">Nigeria</option>
						<option value="570">Niue</option>
						<option value="574">Norfolk Island</option>
						<option value="580">Northern Mariana Islands</option>
						<option value="578">Norway</option>
						<option value="998">Not Applicable</option>
						<option value="512">Oman</option>
						<option value="586">Pakistan</option>
						<option value="585">Palau</option>
						<option value="275">Palestinian Territory, Occupied</option>
						<option value="591">Panama</option>
						<option value="598">Papua New Guinea</option>
						<option value="600">Paraguay</option>
						<option value="604">Peru</option>
						<option value="608">Philippines</option>
						<option value="612">Pitcairn</option>
						<option value="616">Poland</option>
						<option value="620">Portugal</option>
						<option value="630">Puerto Rico</option>
						<option value="634">Qatar</option>
						<option value="638">Reunion</option>
						<option value="642">Romania</option>
						<option value="643">Russian Federation</option>
						<option value="646">Rwanda</option>
						<option value="654">Saint Helena</option>
						<option value="659">Saint Kitts and Nevis</option>
						<option value="662">Saint Lucia</option>
						<option value="666">Saint Pierre and Miquelon</option>
						<option value="670">Saint Vincent and the Grenadines</option>
						<option value="882">Samoa</option>
						<option value="674">San Marino</option>
						<option value="678">Sao Tome and Principe</option>
						<option value="682">Saudi Arabia</option>
						<option value="686">Senegal</option>
						<option value="891">Serbia and Montenegro</option>
						<option value="690">Seychelles</option>
						<option value="694">Sierra Leone</option>
						<option value="702">Singapore</option>
						<option value="703">Slovakia</option>
						<option value="705">Slovenia</option>
						<option value="90">Solomon Islands</option>
						<option value="706">Somalia</option>
						<option value="710">South Africa</option>
						<option value="239">South Georgia and the South Sandwich Islands</option>
						<option value="724">Spain</option>
						<option value="144">Sri Lanka</option>
						<option value="736">Sudan</option>
						<option value="740">Suriname</option>
						<option value="744">Svalbard and Jan Mayen</option>
						<option value="748">Swaziland</option>
						<option value="752">Sweden</option>
						<option value="756">Switzerland</option>
						<option value="760">Syrian Arab Republic</option>
						<option value="158">Taiwan, Province of China</option>
						<option value="762">Tajikistan</option>
						<option value="834">Tanzania, United Republic of</option>
						<option value="764">Thailand</option>
						<option value="626">Timor-Leste</option>
						<option value="768">Togo</option>
						<option value="772">Tokelau</option>
						<option value="776">Tonga</option>
						<option value="780">Trinidad and Tobago</option>
						<option value="788">Tunisia</option>
						<option value="792">Turkey</option>
						<option value="795">Turkmenistan</option>
						<option value="796">Turks and Caicos Islands</option>
						<option value="798">Tuvalu</option>
						<option value="800">Uganda</option>
						<option value="804">Ukraine</option>
						<option value="784">United Arab Emirates</option>
						<option value="826">United Kingdom</option>
						<option value="840">United States</option>
						<option value="581">United States Minor Outlying Islands</option>
						<option value="999">Unknown</option>
						<option value="858">Uruguay</option>
						<option value="860">Uzbekistan</option>
						<option value="548">Vanuatu</option>
						<option value="862">Venezuela, Bolivarian Republic of</option>
						<option value="704">Viet Nam</option>
						<option value="92">Virgin Islands, British</option>
						<option value="850">Virgin Islands, U.S.</option>
						<option value="876">Wallis and Futuna</option>
						<option value="732">Western Sahara</option>
						<option value="887">Yemen</option>
						<option value="894">Zambia</option>
						<option value="716">Zimbabwe</option>
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
						<option value="1">Ship</option>
						<option value="2">AUV</option>
						<option value="3">HOV</option>
						<option value="4">ROV</option>
						<option value="5">Submersible / HOV</option>
						<option value="6">LaboratoryInstrument</option>
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
						<option value="1">Not Applicable</option>
						<option value="2">Unknown</option>
						<option value="3">Lab Analyses</option>
						<option value="4">Sampling Technique</option>
						<option value="5">Sample Preparation</option>
						<option value="6">Sample Preservation</option>
						<option value="7">Sample Fractionation</option>
						<option value="8">Navigation</option>
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