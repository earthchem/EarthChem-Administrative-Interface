<?php

/*
******************************************************************
EC Admin REST API
Measured Variable Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				variable entries in the ECDB.
******************************************************************
*/

class MeasuredVariableController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){

				$row = $this->db->get_row("select * from variable where variable_num = $searchid");

				if($row->variable_num){

						
						$data['variable_num']=$row->variable_num;
						$data['variable_name']=$row->variable_name;
						$data['variable_code']=$row->variable_code;
						$data['variable_type_num']=$row->variable_type_num;
						$data['variable_definition']=$row->variable_definition;
						$data['status']=$row->status;

						
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Variable $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Variable $id not found.";
			}

        } else {
        	
        	if($_GET){
        	
        		if($_GET['query']){

					$querystring = strtolower($_GET['query']);
					
					if($this->is_whole_int($querystring)){$numquery = " or variable_num = $querystring";}
					
					$rows = $this->db->get_results("select * from variable where 
													(lower(variable_name) like '%$querystring%' $numquery) order by variable_name;");
					
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						foreach($rows as $row){
							
							$num = $row->variable_num;
							$name = $row->variable_name;
							$status = $row->status;
							
							$thisresult['variable_num']=$num;
							$thisresult['variable_name']=$name;
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

				$rows = $this->db->get_results("select * from variable order by variable_name;");
				
				$data['resultcount']=count($rows);

				$results = [];
				foreach($rows as $row){
					
					$thisresult['variable_num']=$row->variable_num;
					$thisresult['variable_name']=$row->variable_name;
					$thisresult['variable_code']=$row->variable_code;
					$thisresult['variable_type_num']=$row->variable_type_num;
					$thisresult['variable_definition']=$row->variable_definition;
					$thisresult['status']=$row->status;
		
					$data['results'][]=$thisresult;

				}

        	}

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from variable where variable_num = $searchid");

				if($row->variable_num){

					$id = (int)$request->url_elements[2];

					$this->db->query("
										update variable set
										status = 0
										where variable_num = $id
									");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Variable $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Variable $id not found.";
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

			if($p['variable_name']!=""){ $variable_name = "'".$p['variable_name']."',"; }else{ $variable_name = "null,"; }
			if($p['variable_type_num']!=""){ $variable_type_num = $p['variable_type_num'].","; }else{ $variable_type_num = "null,"; }
			if($p['variable_code']!=""){ $variable_code = "'".$p['variable_code']."',"; }else{ $variable_code = "null,"; }
			if($p['variable_definition']!=""){ $variable_definition = "'".$p['variable_definition']."',"; }else{ $variable_definition = "null,"; }
			if($p['status']!=""){ $status = $p['status'].","; }else{ $status = "1,"; }
			

			$id = $this->db->get_var("select nextval('variable_variable_num_seq')");
			$p['variable_num']=$id;
			
			$query = "insert into variable (	variable_num,
						variable_name,
						variable_type_num,
						variable_code,
						variable_definition,
						status
					) values (
						$id,
						$variable_name
						$variable_type_num
						$variable_code
						$variable_definition
						$status";
												
			
			$query = substr($query, 0, -1);
			$query .= "\n);";

			//print_r($query);exit();
			
			
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
				$row = $this->db->get_row("select * from action where action_num = $searchid");

				if($row->action_num){

					$id = (int)$request->url_elements[2];

					$p = $request->parameters;
						
					if($p['variable_name']!="")$variable_name = $p['variable_name'];
					if($p['variable_code']!="")$variable_code = $p['variable_code'];
					if($p['variable_type_num']!="")$variable_type_num = $p['variable_type_num'];
					if($p['variable_definition']!="")$variable_definition = $p['variable_definition'];
					if($p['status']!="")$status = $p['status'];

					if($variable_name!=""){$query.="variable_name = '$variable_name',\n";}else{$query.="variable_name = null,\n";}
					if($variable_code!=""){$query.="variable_code = '$variable_code',\n";}else{$query.="variable_code = null,\n";}
					if($variable_type_num!=""){$query.="variable_type_num = $variable_type_num,\n";}else{$query.="variable_type_num = null,\n";}
					if($variable_definition!=""){$query.="variable_definition = '$variable_definition',\n";}else{$query.="variable_definition = null,\n";}
					if($status!=""){$query.="status = $status,\n";}else{$query.="status = 1,\n";}

					$query = substr($query, 0, -2);

					$this->db->query("
										update variable set
										$query
										where variable_num = $id
									");
					

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Variable $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Variable $id not found.";
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


