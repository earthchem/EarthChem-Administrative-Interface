<?php

/*
******************************************************************
EC Admin REST API
Affiliation Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				affiliation entries in the ECDB.
******************************************************************
*/

class PersonAffiliationController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){

				$row = $this->db->get_row("select * from earthchem.person p, earthchem.affiliation a, earthchem.organization o  where 
											p.person_num = a.person_num and
											a.organization_num = o.organization_num and
											a.affiliation_num = $searchid");

				if($row->person_num){

						$data['affiliation_num'] = $row->affiliation_num;
						//$data['person_num'] = $row->person_num;
						$data['person_name'] = $row->last_name.", ".$row->first_name." ".$row->middle_name;
						$data['organization_name'] = $row->organization_name;
						
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Person $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Person $id not found.";
			}

        } else {
        	
        	if($_GET){
        	
        		if($_GET['query']){

					$querystring = strtolower($_GET['query']);
					
					if($this->is_whole_int($querystring)){$numquery = " or a.affiliation_num = $querystring";}
					
					$rows = $this->db->get_results("select * from earthchem.person p, earthchem.affiliation a, earthchem.organization o  where
													p.person_num = a.person_num and
													a.organization_num = o.organization_num and
													(
													lower(organization_name) like '%$querystring%' or
													lower(last_name)||', '||lower(first_name)||' '||lower(middle_name) like '%$querystring%' $numquery ) order by last_name, first_name
													;");
					
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						foreach($rows as $row){
							
							$num = $row->person_num;
							$name = $row->last_name.", ".$row->first_name." ".$row->middle_name;
							
							//$thisresult['person_num']=$num;
							//$thisresult['person_name']=$name;
							
							$thisresult['affiliation_num'] = $row->affiliation_num;
							//$data['person_num'] = $row->person_num;
							$thisresult['person_name'] = $row->last_name.", ".$row->first_name." ".$row->middle_name;
							$thisresult['organization_name'] = $row->organization_name;
					
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
    
        if(isset($request->url_elements[2])) {
        
			header("Bad Request", true, 400);
			$data["Error"] = "Invalid Request.";

        }else{



        }
        
        return $data;


	}

    public function putAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];


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


