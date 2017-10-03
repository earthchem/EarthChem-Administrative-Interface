<?php

/*
******************************************************************
EC Admin REST API
Action Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				action entries in the ECDB.
******************************************************************
*/

class ActionController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){

				$row = $this->db->get_row("select * from earthchem.action where action_num = $searchid");

				if($row->action_num){

						
						$data=$row;
						
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Action $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Action $id not found.";
			}

        } else {
        	
        	if($_GET){
        	
        		if($_GET['query']){

					$querystring = strtolower($_GET['query']);
					
					if($this->is_whole_int($querystring)){$numquery = " or action_num = $querystring";}
					
					$rows = $this->db->get_results("select * from earthchem.action where 
													--action_type_num in (3,11,12,25,19) and
													lower(action_name) like '%$querystring%' $numquery order by action_name;");
					
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						foreach($rows as $row){
							
							$num = $row->action_num;
							$name = $row->action_name;
							
							$thisresult['action_num']=$num;
							$thisresult['action_name']=$name;
					
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
		//deprecate
    }

    public function postAction($request) {
    
		header("Bad Request", true, 400);
		$data["Error"] = "Bad Request.";

        return $data;

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


