<?php

/*
******************************************************************
EC Admin REST API
Equipment Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				equipment entries in the ECDB.
******************************************************************
*/

class EquipmentController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){
				
				$query="select * from equipment where equipment_num = $searchid";
				
				//echo $query;exit();
				
				$row = $this->db->get_row($query);

				if($row->equipment_num){

						$data=$row;
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Equipment $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Equipment $id not found.";
			}

        } else {
        	
        	if($_GET){
        	
        		if($_GET['query']){

					$querystring = strtolower($_GET['query']);

					if($_GET['publiconly']=="yes"){
						$publicstring = " and eq.status = 1";
					}

					if($this->is_whole_int($querystring)){$numquery = " or equipment_num = $querystring";}
					
					$query = "select
								eq.equipment_num,
								eq.equipment_name,
								eq.status
										
													from equipment eq, equipment_type et 
													where 
													eq.equipment_type_num = et.equipment_type_num and
													(
													lower(equipment_name) like '%$querystring%' or
													lower(equipment_type_name) = '$querystring'
													$numquery 
													)
													$publicstring
													order by equipment_name;";
													
					//echo $query;exit();
					
					$rows = $this->db->get_results($query);
					
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						foreach($rows as $row){
							
							$num = $row->equipment_num;
							$name = $row->equipment_name;
							$status = $row->status;
							
							$thisresult['equipment_num']=$num;
							$thisresult['equipment_name']=$name;
							$thisresult['status']=$status;
					
							$data['results'][]=$thisresult;
							
						}
					}else{
						$data['resultcount']=0;
						$data['results']=array();
					}
        		
        		}else{
        		
					header("Bad Request", true, 400);
					$data["Error"] = "Invalid Query Parameter.";
        		
        		}
        	
        	}else{

				header("Bad Request", true, 400);
				$data["Error"] = "Invalid Request.";

				//list all person entries here
				/*
				$rows = $this->db->get_results("select * from taxonomic_classifier where taxonomic_classifier_type_cv='Mineral' order by taxonomic_classifier_name");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->taxonomic_classifier_num;
					$name = $row->taxonomic_classifier_name;
					$definition = "Mineral from EarthChem ODM2 database.";
					
					$data['results'][]=$this->jsonObject("mineral", $num, $name, $name, $definition, "min");
					
					//{"uri":"http:\/\/vocab.earthchemportal.org\/vocabulary\/person\/per2509","prefLabel":{"en":"Dahren, B."},"altLabel":{"en":"Dahren, B."},"definition":{"en":"Author from EarthChem Portal"}}

				}
				*/

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from equipment where equipment_num = $searchid");

				if($row->equipment_num){

					$id = (int)$request->url_elements[2];


					$this->db->query("
										update equipment set
										status = 0
										where equipment_num = $id
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Equipment $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Equipment $id not found.";
			}

        } else {

			header("Bad Request", true, 400);
			$data["Error"] = "Invalid Request.";

        }
        return $data;
    }

    public function postAction($request) {
    
        if(isset($request->url_elements[2])) {
        
			header("Bad Request", true, 400);
			$data["Error"] = "Invalid Request.";

        }else{

			$p = $request->parameters;

			if($p['equipment_code']==""){$p['equipment_code']="unknown";}
			
			if($p['equipment_code']!=""){ $equipment_code = "'".$p['equipment_code']."',"; }else{ $equipment_code = "null,"; }
			if($p['equipment_name']!=""){ $equipment_name = "'".$p['equipment_name']."',"; }else{ $equipment_name = "null,"; }
			if($p['equipment_type_num']!=""){ $equipment_type_num = $p['equipment_type_num'].","; }else{ $equipment_type_num = "null,"; }
			if($p['model_id']!=""){ $model_id = $p['model_id'].","; }else{ $model_id = "null,"; }
			if($p['equipment_serial_num']!=""){ $equipment_serial_num = $p['equipment_serial_num'].","; }else{ $equipment_serial_num = "null,"; }
			if($p['equipment_inventory_num']!=""){ $equipment_inventory_num = $p['equipment_inventory_num'].","; }else{ $equipment_inventory_num = "null,"; }
			if($p['equipment_owner_id']!=""){ $equipment_owner_id = "'".$p['equipment_owner_id']."',"; }else{ $equipment_owner_id = "null,"; }
			if($p['equipment_vendor_id']!=""){ $equipment_vendor_id = "'".$p['equipment_vendor_id']."',"; }else{ $equipment_vendor_id = "null,"; }
			if($p['equipment_phurchase_date']!=""){ $equipment_phurchase_date = "'".$p['equipment_phurchase_date']."',"; }else{ $equipment_phurchase_date = "null,"; }
			if($p['equipment_phurchase_order_num']!=""){ $equipment_phurchase_order_num = $p['equipment_phurchase_order_num'].","; }else{ $equipment_phurchase_order_num = "null,"; }
			if($p['equipment_photo_file_name']!=""){ $equipment_photo_file_name = "'".$p['equipment_photo_file_name']."',"; }else{ $equipment_photo_file_name = "null,"; }
			if($p['equipment_description']!=""){ $equipment_description = "'".$p['equipment_description']."',"; }else{ $equipment_description = "null,"; }
			if($p['status']!=""){ $status = $p['status'].","; }else{ $status = "1,"; }
			
			$equipment_num = $this->db->get_var("select nextval('equipment_equipment_num_seq')");
			$p['equipment_num']=$equipment_num;
			
			$query = "insert into equipment (	equipment_num,
						equipment_code,
						equipment_name,
						equipment_type_num,
						model_id,
						equipment_serial_num,
						equipment_inventory_num,
						equipment_owner_id,
						equipment_vendor_id,
						equipment_phurchase_date,
						equipment_phurchase_order_num,
						equipment_photo_file_name,
						equipment_description,
						status
					) values (
						$equipment_num,
						$equipment_code
						$equipment_name
						$equipment_type_num
						$model_id
						$equipment_serial_num
						$equipment_inventory_num
						$equipment_owner_id
						$equipment_vendor_id
						$equipment_phurchase_date
						$equipment_phurchase_order_num
						$equipment_photo_file_name
						$equipment_description
						$status";
												
			
			$query = substr($query, 0, -1);
			$query .= "\n);";

			$this->db->query($query);

			$data=$p;

        }
        
        return $data;


	}

    public function putAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from equipment where equipment_num = $searchid");

				if($row->equipment_num){

					$id = (int)$request->url_elements[2];

					$p = $request->parameters;
						
					if($p['equipment_code']!="")$equipment_code = $p['equipment_code'];
					if($p['equipment_name']!="")$equipment_name = $p['equipment_name'];
					if($p['equipment_type_num']!="")$equipment_type_num = $p['equipment_type_num'];
					if($p['model_id']!="")$model_id = $p['model_id'];
					if($p['equipment_serial_num']!="")$equipment_serial_num = $p['equipment_serial_num'];
					if($p['equipment_inventory_num']!="")$equipment_inventory_num = $p['equipment_inventory_num'];
					if($p['equipment_owner_id']!="")$equipment_owner_id = $p['equipment_owner_id'];
					if($p['equipment_vendor_id']!="")$equipment_vendor_id = $p['equipment_vendor_id'];
					if($p['equipment_phurchase_date']!="")$equipment_phurchase_date = $p['equipment_phurchase_date'];
					if($p['equipment_phurchase_order_num']!="")$equipment_phurchase_order_num = $p['equipment_phurchase_order_num'];
					if($p['equipment_photo_file_name']!="")$equipment_photo_file_name = $p['equipment_photo_file_name'];
					if($p['equipment_description']!="")$equipment_description = $p['equipment_description'];
					if($p['status']!="")$status = $p['status'];

					if($p['equipment_name']!=""){$query.="equipment_name = '$equipment_name',\n";}else{$query.="equipment_name = null,\n";}
					if($p['equipment_type_num']!=""){$query.="equipment_type_num = '$equipment_type_num',\n";}else{$query.="equipment_type_num = null,\n";}
					if($p['model_id']!=""){$query.="model_id = $model_id,\n";}else{$query.="model_id = null,\n";}
					if($p['equipment_serial_num']!=""){$query.="equipment_serial_num = $equipment_serial_num,\n";}else{$query.="equipment_serial_num = null,\n";}
					if($p['equipment_inventory_num']!=""){$query.="equipment_inventory_num = '$equipment_inventory_num',\n";}else{$query.="equipment_inventory_num = null,\n";}
					if($p['equipment_owner_id']!=""){$query.="equipment_owner_id = '$equipment_owner_id',\n";}else{$query.="equipment_owner_id = null,\n";}
					if($p['equipment_vendor_id']!=""){$query.="equipment_vendor_id = '$equipment_vendor_id',\n";}else{$query.="equipment_vendor_id = null,\n";}
					if($p['equipment_phurchase_date']!=""){$query.="equipment_phurchase_date = '$equipment_phurchase_date',\n";}else{$query.="equipment_phurchase_date = null,\n";}
					if($p['equipment_phurchase_order_num']!=""){$query.="equipment_phurchase_order_num = $equipment_phurchase_order_num,\n";}else{$query.="equipment_phurchase_order_num = null,\n";}
					if($p['equipment_photo_file_name']!=""){$query.="equipment_photo_file_name = '$equipment_photo_file_name',\n";}else{$query.="equipment_photo_file_name = null,\n";}
					if($p['equipment_description']!=""){$query.="equipment_description = '$equipment_description',\n";}else{$query.="equipment_description = null,\n";}
					if($p['status']!=""){$query.="status = $status,\n";}else{$query.="status = 1,\n";}
					
					$query = substr($query, 0, -2);

					$this->db->query("
										update equipment set
										$query
										where equipment_num = $id
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Equipment $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Equipment $id not found.";
			}

        } else {

			header("Bad Request", true, 400);
			$data["Error"] = "Invalid Request.";

        }
        return $data;
    }

    public function optionsAction($request) {
    	
		header("Bad Request", true, 400);
		$data["Error"] = "Bad Request.";

        return $data;
    }

    public function patchAction($request) {
    	
		header("Bad Request", true, 400);
		$data["Error"] = "Bad Request.";

        return $data;
    }

    public function copyAction($request) {
    	
		header("Bad Request", true, 400);
		$data["Error"] = "Bad Request.";

        return $data;
    }

    public function searchAction($request) {
    	
		header("Bad Request", true, 400);
		$data["Error"] = "Bad Request.";

        return $data;
    }
    
	public function is_whole_int($val) {
		$val = strval($val);
		$val = str_replace('-', '', $val);

		if (ctype_digit($val))
		{
			if ($val === (string)0)
				return true;
			elseif(ltrim($val, '0') === $val)
				return true;
		}

		return false;
	}


}


