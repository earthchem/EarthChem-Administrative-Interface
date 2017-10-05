<?php

/*
******************************************************************
Vocabulary REST API
Uncertainty Type Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				uncertainty type entries.
******************************************************************
*/

class UncertaintyTypeController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("uncerttype","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from earthchem.dataquality_type where dataquality_type_num=$searchid");
				if($row->dataquality_type_num){
						$num = $row->dataquality_type_num;
						$preflabel = $row->dataquality_type_description;
						$altlabel = $row->dataquality_type_description;
						$definition = "Uncertainty Type from EarthChem ODM2 database.";
					
						$data=$this->jsonObject("uncertaintyType", $num, $preflabel, $altlabel, $definition, "uncerttype");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Uncertainty Type $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Uncertainty Type $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from earthchem.dataquality_type where lower(dataquality_type_description) like '%$label%' order by dataquality_type_description;
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->dataquality_type_num;
							$preflabel = $row->dataquality_type_description;
							$altlabel = $row->dataquality_type_description;
							$definition = "Uncertainty Type from EarthChem ODM2 database.";
					
							$data['results'][]=$this->jsonObject("uncertaintyType", $num, $preflabel, $altlabel, $definition, "uncerttype");
							
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
				$rows = $this->db->get_results("select * from earthchem.dataquality_type where dataquality_type_description is not null order by dataquality_type_description;");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->dataquality_type_num;
					$preflabel = $row->dataquality_type_description;
					$altlabel = $row->dataquality_type_description;
					$definition = "Uncertainty Type from EarthChem ODM2 database.";
					
					$data['results'][]=$this->jsonObject("uncertaintyType", $num, $preflabel, $altlabel, $definition, "uncerttype");

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


