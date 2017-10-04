<?php

/*
******************************************************************
EC Admin REST API
Organization Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				organization entries in the ECDB.
******************************************************************
*/

class OrganizationController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from earthchem.organization where organization_num = $searchid");

				if($row->organization_num){

						$data=$row;
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Organization $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Organization $id not found.";
			}

        } else {
        	
        	if($_GET){
        	
        		if($_GET['query']){

					$querystring = strtolower($_GET['query']);
					
					if($this->is_whole_int($querystring)){$numquery = " or organization_num = $querystring";}
					
					$rows = $this->db->get_results("select * from earthchem.organization where 
													lower(organization_name) like '%$querystring%' or 
													lower(department) like '%$querystring%' or
													lower(organization_name)||' - '||lower(department) like '%$querystring%'
													$numquery order by organization_name;");
					
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						foreach($rows as $row){
							
							$num = $row->organization_num;
							$name = $row->organization_name;
							$department = $row->department;
							
							$thisresult['organization_num']=$num;
							$thisresult['organization_name']=$name;
							$thisresult['department']=$department;
					
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

			$p = $request->parameters;

			if($p['organization_type_num']!=""){ $organization_type_num = $p['organization_type_num'].","; }else{ $organization_type_num = "null,"; }
			if($p['organization_code']!=""){ $organization_code = "'".$p['organization_code']."',"; }else{ $organization_code = "'NA',"; }
			if($p['organization_name']!=""){ $organization_name = "'".$p['organization_name']."',"; }else{ $organization_name = "null,"; }
			if($p['organization_description']!=""){ $organization_description = "'".$p['organization_description']."',"; }else{ $organization_description = "null,"; }
			if($p['organization_link']!=""){ $organization_link = "'".$p['organization_link']."',"; }else{ $organization_link = "null,"; }
			if($p['parent_organization_num']!=""){ $parent_organization_num = $p['parent_organization_num'].","; }else{ $parent_organization_num = "null,"; }
			if($p['country_num']!=""){ $country_num = $p['country_num'].","; }else{ $country_num = "999,"; }
			if($p['department']!=""){ $department = "'".$p['department']."',"; }else{ $department = "null,"; }
			if($p['organization_unique_id']!=""){ $organization_unique_id = $p['organization_unique_id'].","; }else{ $organization_unique_id = "null,"; }
			if($p['organization_unique_id_type']!=""){ $organization_unique_id_type = "'".$p['organization_unique_id_type']."',"; }else{ $organization_unique_id_type = "null,"; }
			if($p['address_part1']!=""){ $address_part1 = "'".$p['address_part1']."',"; }else{ $address_part1 = "null,"; }
			if($p['address_part2']!=""){ $address_part2 = "'".$p['address_part2']."',"; }else{ $address_part2 = "null,"; }
			if($p['city']!=""){ $city = "'".$p['city']."',"; }else{ $city = "null,"; }
			if($p['state_num']!=""){ $state_num = $p['state_num'].","; }else{ $state_num = "null,"; }
			if($p['zip']!=""){ $zip = "'".$p['zip']."',"; }else{ $zip = "null,"; }






/*
organization_num
organization_type_num
organization_code
organization_name
organization_description
organization_link
parent_organization_num
country_num
department
organization_unique_id
organization_unique_id_type
address_part1
address_part2
city
state_num
zip
*/

			
			$organization_num = $this->db->get_var("select nextval('earthchem.organization_organization_num_seq')");
			$p['organization_num']=$organization_num;
			
			$query = "insert into earthchem.organization (organization_num,
						organization_type_num,
						organization_code,
						organization_name,
						organization_description,
						organization_link,
						parent_organization_num,
						country_num,
						department,
						organization_unique_id,
						organization_unique_id_type,
						address_part1,
						address_part2,
						city,
						state_num,
						zip
					) values (
						$organization_num,
						$organization_type_num
						$organization_code
						$organization_name
						$organization_description
						$organization_link
						$parent_organization_num
						$country_num
						$department
						$organization_unique_id
						$organization_unique_id_type
						$address_part1
						$address_part2
						$city
						$state_num
						$zip";
												
			
			$query = substr($query, 0, -1);
			$query .= "\n);";

			//echo $query;exit();
			
			
			$this->db->query($query);

			$data=$p;

        }
        
        return $data;


	}

    public function putAction($request) {
    
        if(isset($request->url_elements[2])) {

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


