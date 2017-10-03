<?php

/*
******************************************************************
EC Admin REST API
Result Template Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				result template entries in the ECDB.
******************************************************************
*/

class ResultTemplateController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from earthchem.result_template where result_template_num = $searchid");

				if($row->variable_num){

						$data=$row;
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Result template $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Result template $id not found.";
			}

        } else {
        	
        	if($_GET){
        	
        		if($_GET['query']){

					$querystring = strtolower($_GET['query']);
					
					if($this->is_whole_int($querystring)){$numquery = " or result_template_num = $querystring";}
					
					$rows = $this->db->get_results("select * from earthchem.result_template where lower(reporting_variable_name) like '%$querystring%' $numquery order by reporting_variable_name;");
					
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						foreach($rows as $row){
							
							$num = $row->result_template_num;
							$name = $row->reporting_variable_name;
							
							$thisresult['result_template_num']=$num;
							$thisresult['reporting_variable_name']=$name;
					
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

			if($p['reporting_variable_name']!=""){ $reporting_variable_name = "'".$p['reporting_variable_name']."',"; }else{ $reporting_variable_name = "null,"; }
			if($p['analysis_event']!=""){ $analysis_event = $p['analysis_event'].","; }else{ $analysis_event = "null,"; }
			if($p['variable_num']!=""){ $variable_num = $p['variable_num'].","; }else{ $variable_num = "null,"; }
			if($p['unit_num']!=""){ $unit_num = $p['unit_num'].","; }else{ $unit_num = "null,"; }
			if($p['uncertainty_type']!=""){ $uncertainty_type = $p['uncertainty_type'].","; }else{ $uncertainty_type = "null,"; }
			if($p['uncertainty_value']!=""){ $uncertainty_value = $p['uncertainty_value'].","; }else{ $uncertainty_value = "null,"; }
			if($p['description']!=""){ $description = "'".$p['description']."',"; }else{ $description = "null,"; }






/*
result_template_num
reporting_variable_name
analysis_event
variable_num
unit_num
uncertainty_type
uncertainty_value
description
*/

			
			$result_template_num = $this->db->get_var("select nextval('earthchem.result_template_result_template_num_seq')");
			$p['result_template_num']=$result_template_num;
			
			$query = "insert into earthchem.result_template (	result_template_num,
						reporting_variable_name,
						analysis_event,
						variable_num,
						unit_num,
						uncertainty_type,
						uncertainty_value,
						description
					) values (
						$result_template_num,
						$reporting_variable_name
						$analysis_event
						$variable_num
						$unit_num
						$uncertainty_type
						$uncertainty_value
						$description";
												
			
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
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from earthchem.result_template where result_template_num = $searchid");

				if($row->result_template_num){

					$id = (int)$request->url_elements[2];

					$p = $request->parameters;
						
					if($p['reporting_variable_name']!="")$reporting_variable_name = $p['reporting_variable_name'];
					if($p['analysis_event']!="")$analysis_event = $p['analysis_event'];
					if($p['variable_num']!="")$variable_num = $p['variable_num'];
					if($p['unit_num']!="")$unit_num = $p['unit_num'];
					if($p['uncertainty_type']!="")$uncertainty_type = $p['uncertainty_type'];
					if($p['uncertainty_value']!="")$uncertainty_value = $p['uncertainty_value'];
					if($p['description']!="")$description = $p['description'];


/*
reporting_variable_name
analysis_event
variable_num
unit_num
uncertainty_type
uncertainty_value
description
*/



					if($p['reporting_variable_name']!=""){$query.="reporting_variable_name = '$reporting_variable_name',\n";}else{$query.="reporting_variable_name = null,\n";}
					if($p['analysis_event']!=""){$query.="analysis_event = $analysis_event,\n";}else{$query.="analysis_event = null,\n";}
					if($p['variable_num']!=""){$query.="variable_num = $variable_num,\n";}else{$query.="variable_num = null,\n";}
					if($p['unit_num']!=""){$query.="unit_num = $unit_num,\n";}else{$query.="unit_num = null,\n";}
					if($p['uncertainty_type']!=""){$query.="uncertainty_type = $uncertainty_type,\n";}else{$query.="uncertainty_type = null,\n";}
					if($p['uncertainty_value']!=""){$query.="uncertainty_value = $uncertainty_value,\n";}else{$query.="uncertainty_value = null,\n";}
					if($p['description']!=""){$query.="description = '$description',\n";}else{$query.="description = null,\n";}


					$query = substr($query, 0, -2);

					$query = "update earthchem.result_template set
										$query
										where result_template_num = $id";

					//echo $query;exit();
					
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


