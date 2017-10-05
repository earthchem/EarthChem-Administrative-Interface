<?php

/*
******************************************************************
Vocabulary REST API
Equipment Type Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				equipment type entries.
******************************************************************
*/

class EquipmentTypeController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("eqtype","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from earthchem.equipment_type where equipment_type_num=$searchid");
				if($row->equipment_type_num){
						$num = $row->equipment_type_num;
						$preflabel = $row->equipment_type_name;
						$altlabel = $row->equipment_type_description;
						$definition = "Equipment Type from EarthChem ODM2 database.";
					
						$data=$this->jsonObject("equipmentType", $num, $preflabel, $altlabel, $definition, "eqtype");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Equipment Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Equipment Type $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from earthchem.equipment_type where lower(equipment_type_name) like '%$label%' order by equipment_type_name;
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->equipment_type_num;
							$preflabel = $row->equipment_type_name;
							$altlabel = $row->equipment_type_description;
							$definition = "Equipment Type from EarthChem ODM2 database.";
					
							$data['results'][]=$this->jsonObject("equipmentType", $num, $preflabel, $altlabel, $definition, "eqtype");
							
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

				//list all action_type entries here
				$rows = $this->db->get_results("select * from earthchem.equipment_type order by equipment_type_name;");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->equipment_type_num;
					$preflabel = $row->equipment_type_name;
					$altlabel = $row->equipment_type_description;
					$definition = "Equipment Type from EarthChem ODM2 database.";
					
					$data['results'][]=$this->jsonObject("equipmentType", $num, $preflabel, $altlabel, $definition, "eqtype");

				}

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {

    }

    public function postAction($request) {

    }

    public function putAction($request) {
    	
		header("Bad Request", true, 400);
		$data["Error"] = "Bad Request.";

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


}


