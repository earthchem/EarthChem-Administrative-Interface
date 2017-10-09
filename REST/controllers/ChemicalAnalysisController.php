<?php

/*
******************************************************************
EC Admin REST API
Chemical Analysis Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				chemical analysis entries in the ECDB.
******************************************************************
*/

class ChemicalAnalysisController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){

				$row = $this->db->get_row("select * from earthchem.action where action_num = $searchid and status=1");

				if($row->action_num){

						
						$data['chemical_analysis_num']=$row->action_num;
						$data['chemical_analysis_name']=$row->action_name;
						$data['chemical_analysis_type_num']=$row->action_type_num;
						$data['method_num']=$row->method_num;
						$data['lab_num']=$row->organization_num;
						$data['description']=$row->action_description;
						$data['begin_date_time']=$row->begin_date_time;
						$data['end_date_time']=$row->end_date_time;
						
						
						$data['equipment_num']=$this->db->get_var("select e.equipment_num from earthchem.equipment e, earthchem.equipment_action ea
													where e.equipment_num = ea.equipment_num and
													ea.action_num = $row->action_num
													");
						
						$data['personaffiliation_num']=$this->db->get_var("select a.affiliation_num from earthchem.affiliation a, earthchem.action_by ab
													where a.affiliation_num = ab.affiliation_num and
													ab.action_num = $row->action_num
													");
						
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Chemical Analysis $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Chemical Analysis $id not found.";
			}

        } else {
        	
        	if($_GET){
        	
        		if($_GET['query']){

					$querystring = strtolower($_GET['query']);
					
					if($this->is_whole_int($querystring)){$numquery = " or action_num = $querystring";}
					
					$rows = $this->db->get_results("select * from (
														select
														act.action_num,
														act.action_name,
														act.action_type_num,
														act.method_num,
														act.organization_num,
														act.action_description,
														act.begin_date_time,
														act.end_date_time,
														act.status,
													
														(select method_name from earthchem.method where method_num = act.method_num) as method_name,
														
														(select organization_name from earthchem.organization where organization_num = act.organization_num) as lab_name,
													
														(select e.equipment_name from earthchem.equipment e, earthchem.equipment_action ea
															where e.equipment_num = ea.equipment_num and
															ea.action_num = act.action_num) as equipment_name,
													
														(select e.equipment_num from earthchem.equipment e, earthchem.equipment_action ea
															where e.equipment_num = ea.equipment_num and
															ea.action_num = act.action_num) as equipment_num,
													
														(select a.affiliation_num from earthchem.affiliation a, earthchem.action_by ab
															where a.affiliation_num = ab.affiliation_num and
															ab.action_num = act.action_num) as affiliation_num
													
														from earthchem.action act where 
														action_type_num in (20,28,29,30,31)
													) foo where 
													lower(action_name) like '%$querystring%' 
													--or lower(lab_name) like '%$querystring%'
													--or lower(method_name) like '%$querystring%'
													--or lower(equipment_name) like '%$querystring%'
													and status = 1
													$numquery order by action_name
													
													
													
													
													");
					
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						foreach($rows as $row){
							
							$action_num = $row->action_num;
							$thisresult['chemical_analysis_num']=$row->action_num;
							$thisresult['chemical_analysis_name']=$row->action_name;
							$thisresult['chemical_analysis_type_num']=$row->action_type_num;
							$thisresult['method_num']=$row->method_num;
							$thisresult['lab_num']=$row->organization_num;
							$thisresult['description']=$row->action_description;
							$thisresult['begin_date_time']=$row->begin_date_time;
							$thisresult['end_date_time']=$row->end_date_time;
							$thisresult['equipment_num']=$row->equipment_num;
							$thisresult['personaffiliation_num']=$row->affiliation_num;
							
							$thisresult['lab_name']=$row->lab_name;
							$thisresult['method_name']=$row->method_name;
							$thisresult['equipment_name']=$row->equipment_name;
					
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

        	}
        	
        	

        }
        return $data;
    }

    public function deleteAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from earthchem.action where action_num = $searchid");

				if($row->action_num){

					$id = (int)$request->url_elements[2];
					
					$this->db->query("update earthchem.action set status=0 where action_num = $searchid");

					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Chemical Analysis $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Chemical Analysis $id not found.";
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

			if($p['chemical_analysis_name']!=""){ $action_name = "'".$p['chemical_analysis_name']."',"; }else{ $action_name = "null,"; }
			if($p['chemical_analysis_type_num']!=""){ $action_type_num = $p['chemical_analysis_type_num'].","; }else{ $action_type_num = "null,"; }
			if($p['description']!=""){ $action_description = "'".$p['description']."',"; }else{ $action_description = "null,"; }
			if($p['begin_date_time']!=""){ $begin_date_time = "'".$p['begin_date_time']."',"; }else{ $begin_date_time = "null,"; }
			if($p['end_date_time']!=""){ $end_date_time = "'".$p['end_date_time']."',"; }else{ $end_date_time = "null,"; }
			if($p['method_num']!=""){ $method_num = $p['method_num'].","; }else{ $method_num = "null,"; }
			if($p['lab_num']!=""){ $organization_num = $p['lab_num'].","; }else{ $organization_num = "null,"; }

			$id = $this->db->get_var("select nextval('earthchem.action_action_num_seq')");
			$p['chemical_analysis_num']=$id;
			
			$query = "insert into earthchem.action (	action_num,
						action_name,
						action_type_num,
						organization_num,
						action_description,
						begin_date_time,
						end_date_time,
						method_num
					) values (
						$id,
						$action_name
						$action_type_num
						$organization_num
						$action_description
						$begin_date_time
						$end_date_time
						$method_num";
												
			
			$query = substr($query, 0, -1);
			$query .= "\n);";

			//echo "$query\n\n\n";
			
			$this->db->query($query);

			//put in equipment
			if($p['equipment_num']!=""){
				$equipment_num=$p['equipment_num'];
				
				$query = "insert into earthchem.equipment_action (action_num,equipment_num)values($id,$equipment_num)";
				
				//echo "$query\n\n\n";
				
				$this->db->query($query);
			}

			//put in equipment
			if($p['personaffiliation_num']!=""){
				$personaffiliation_num=$p['personaffiliation_num'];
				
				$query = "insert into earthchem.action_by (action_num,affiliation_num,is_action_lead)values($id,$personaffiliation_num,0)";
				
				//echo "$query\n\n\n";exit();
				
				$this->db->query($query);exit();
			}

			$data=$p;

        }
        
        return $data;


	}

    public function putAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){
				$row = $this->db->get_row("select * from earthchem.action where action_num = $searchid");

				if($row->action_num){

					$id = (int)$request->url_elements[2];

					$p = $request->parameters;

					$p['chemical_analysis_num']=$id;
	
					if($p['chemical_analysis_name']!="")$chemical_analysis_name = $p['chemical_analysis_name'];
					if($p['chemical_analysis_type_num']!="")$chemical_analysis_type_num = $p['chemical_analysis_type_num'];
					if($p['description']!="")$description = $p['description'];
					if($p['begin_date_time']!="")$begin_date_time = $p['begin_date_time'];
					if($p['end_date_time']!="")$end_date_time = $p['end_date_time'];
					if($p['method_num']!="")$method_num = $p['method_num'];
					if($p['lab_num']!="")$lab_num = $p['lab_num'];

					if($chemical_analysis_name!=""){$query.="action_name = '$chemical_analysis_name',\n";}else{$query.="action_name = null,\n";}
					if($chemical_analysis_type_num!=""){$query.="action_type_num = '$chemical_analysis_type_num',\n";}else{$query.="action_type_num = null,\n";}
					if($description!=""){$query.="action_description = '$description',\n";}else{$query.="action_description = null,\n";}
					if($begin_date_time!=""){$query.="begin_date_time = '$begin_date_time',\n";}else{$query.="begin_date_time = null,\n";}
					if($end_date_time!=""){$query.="end_date_time = '$end_date_time',\n";}else{$query.="end_date_time = null,\n";}
					if($method_num!=""){$query.="method_num = '$method_num',\n";}else{$query.="method_num = null,\n";}
					if($lab_num!=""){$query.="organization_num = '$lab_num',\n";}else{$query.="organization_num = null,\n";}

					$query = substr($query, 0, -2);

					$query = "
										update earthchem.action set
										$query
										where action_num = $id
									";
					
					//echo "$query\n\n\n";
					
					$this->db->query($query);
					
					//delete from equipment_action
					$this->db->query("delete from earthchem.equipment_action where action_num = $id");
					
					//delete from action_by
					$this->db->query("delete from earthchem.action_by where action_num = $id");
					
					//put in equipment
					if($p['equipment_num']!=""){
						$equipment_num=$p['equipment_num'];
						
						$query = "insert into earthchem.equipment_action (action_num,equipment_num)values($id,$equipment_num)";
						
						//echo "$query\n\n\n";
						
						$this->db->query($query);
					}

					//put in equipment
					if($p['personaffiliation_num']!=""){
						$personaffiliation_num=$p['personaffiliation_num'];
						
						$query = "insert into earthchem.action_by (action_num,affiliation_num,is_action_lead)values($id,$personaffiliation_num,0)";
						
						//echo "$query\n\n\n";exit();
						
						$this->db->query($query);
					}


					$data['Success']="true";
	
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Equipment $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Equipment $id not found.";
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


