<?php

/*
******************************************************************
Vocabulary REST API
State Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				state entries.
******************************************************************
*/

class StateController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			$id = $request->url_elements[2];
			$searchid = (int) str_replace("state","",$id);

			if(is_int($searchid)){
				$row = $this->db->get_row("select * from earthchem.state where state_num=$searchid");
				if($row->state_num){
						$num = $row->state_num;
						$preflabel = $row->state_name;
						$altlabel = $row->state_name;
						$definition = "State from EarthChem ODM2 database.";
					
						$data=$this->jsonObject("state", $num, $preflabel, $altlabel, $definition, "state");
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "State $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "State $id not found.";
			}


        } else {
        	
        	if($_GET){
        	
        		if($_GET['label']){

					$label = strtolower($_GET['label']);
					
					$rows = $this->db->get_results("select * from earthchem.state where lower(state_name) like '%$label%' order by state_name;
													
													");
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						$data['resultcount']=count($rows);
						foreach($rows as $row){
							
							$num = $row->state_num;
							$preflabel = $row->state_name;
							$altlabel = $row->state_name;
							$definition = "State from EarthChem ODM2 database.";
					
							$data['results'][]=$this->jsonObject("state", $num, $preflabel, $altlabel, $definition, "state");
							
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
				$rows = $this->db->get_results("select * from earthchem.state where state_name != '' order by state_name;");
				$data['resultcount']=count($rows);
				foreach($rows as $row){
					
					$num = $row->state_num;
					$preflabel = $row->state_name;
					$altlabel = $row->state_name;
					$definition = "State from EarthChem ODM2 database.";
					
					$data['results'][]=$this->jsonObject("state", $num, $preflabel, $altlabel, $definition, "state");

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


