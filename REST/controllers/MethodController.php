<?php

/*
******************************************************************
EC Admin REST API
Method Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				method entries in the ECDB.
******************************************************************
*/

class MethodController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from method where method_num = $searchid and status = 1");

				if($row->method_num){

						$data=$row;
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Method $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Method $id not found.";
			}

        } else {
        	
        	if($_GET){
        	
        		if($_GET['query']){

					$querystring = strtolower($_GET['query']);
					
					if($this->is_whole_int($querystring)){$numquery = " or method_num = $querystring";}
					
					$rows = $this->db->get_results("select * from method where lower(method_name) like '%$querystring%' or lower(method_code) like '%$querystring%' $numquery and status = 1 order by method_name;");
					
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						foreach($rows as $row){
							
							$num = $row->method_num;
							$name = $row->method_name;
							$short_name = $row->method_code;
							
							$thisresult['method_num']=$num;
							$thisresult['method_name']=$name;
							$thisresult['method_short_name']=$short_name;
					
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
				$row = $this->db->get_row("select * from method where method_num = $searchid");

				if($row->method_num){

					$id = (int)$request->url_elements[2];

					$query = "update method set
										status = 0
										where method_num = $id";

					$this->db->query($query);

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Method $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Method $id not found.";
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

			if($p['method_type_num']!=""){ $method_type_num = $p['method_type_num'].","; }else{ $method_type_num = "null,"; }
			if($p['method_code']!=""){ $method_code = "'".$p['method_code']."',"; }else{ $method_code = "null,"; }
			if($p['method_name']!=""){ $method_name = "'".$p['method_name']."',"; }else{ $method_name = "null,"; }
			if($p['method_description']!=""){ $method_description = "'".$p['method_description']."',"; }else{ $method_description = "null,"; }
			if($p['method_link']!=""){ $method_link = "'".$p['method_link']."',"; }else{ $method_link = "null,"; }
			if($p['organization_num']!=""){ $organization_num = $p['organization_num'].","; }else{ $organization_num = "null,"; }






/*
method_type_num
method_code
method_name
method_description
method_link
organization_num
*/

			
			$method_num = $this->db->get_var("select nextval('method_method_num_seq')");
			$p['method_num']=$method_num;
			
			$query = "insert into method (	method_num,
						method_type_num,
						method_code,
						method_name,
						method_description,
						method_link,
						organization_num
					) values (
						$method_num,
						$method_type_num
						$method_code
						$method_name
						$method_description
						$method_link
						$organization_num";
												
			
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
				$row = $this->db->get_row("select * from method where method_num = $searchid");

				if($row->method_num){

					$id = (int)$request->url_elements[2];

					$p = $request->parameters;
						
					if($p['method_type_num']!="")$method_type_num = $p['method_type_num'];
					if($p['method_code']!="")$method_code = $p['method_code'];
					if($p['method_name']!="")$method_name = $p['method_name'];
					if($p['method_description']!="")$method_description = $p['method_description'];
					if($p['method_link']!="")$method_link = $p['method_link'];
					if($p['organization_num']!="")$organization_num = $p['organization_num'];


					if($p['method_type_num']!=""){$query.="method_type_num = $method_type_num,\n";}else{$query.="method_type_num = null,\n";}
					if($p['method_code']!=""){$query.="method_code = '$method_code',\n";}else{$query.="method_code = null,\n";}
					if($p['method_name']!=""){$query.="method_name = '$method_name',\n";}else{$query.="method_name = null,\n";}
					if($p['method_description']!=""){$query.="method_description = '$method_description',\n";}else{$query.="method_description = null,\n";}
					if($p['method_link']!=""){$query.="method_link = '$method_link',\n";}else{$query.="method_link = null,\n";}
					if($p['organization_num']!=""){$query.="organization_num = $organization_num,\n";}else{$query.="organization_num = null,\n";}


					$query = substr($query, 0, -2);

					$query = "update method set
										$query
										where method_num = $id";

					$this->db->query($query);

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Method $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Method $id not found.";
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


