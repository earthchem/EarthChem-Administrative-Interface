<?php

/*
******************************************************************
Vocabulary REST API
Country Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				country entries.
******************************************************************
*/

class countryController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("country","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from earthchem.country where country_num=$searchid");
				if($row->country_num){
						$num = $row->country_num;
						$preflabel = $row->country_name;
						$altlabel = $row->country_name;
						$definition = "country from EarthChem ODM2 database.";
					
						$data=$this->jsonObject("country", $num, $preflabel, $altlabel, $definition, "country");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Country $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Country $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from earthchem.country where lower(country_name) like '%$label%' order by country_name;
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->country_num;
							$preflabel = $row->country_name;
							$altlabel = $row->country_name;
							$definition = "Country from EarthChem ODM2 database.";
					
							$data['results'][]=$this->jsonObject("country", $num, $preflabel, $altlabel, $definition, "country");
							
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
				$rows = $this->db->get_results("select * from earthchem.country where country_name != '' order by country_name;");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->country_num;
					$preflabel = $row->country_name;
					$altlabel = $row->country_name;
					$definition = "Country from EarthChem ODM2 database.";
					
					$data['results'][]=$this->jsonObject("country", $num, $preflabel, $altlabel, $definition, "country");

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


