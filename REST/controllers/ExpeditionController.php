<?php

/*
******************************************************************
EC Admin REST API
Expedition Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This controller enables the creation/retrieval of
				expedition entries in the ECDB.
******************************************************************
*/

class ExpeditionController extends RESTController
{
 
    public function getAction($request) {
    
        if(isset($request->url_elements[2])) {
			
			$id = $request->url_elements[2];
			$searchid = (int)$id;

			if(is_int($searchid) && $searchid!=0){

				$row = $this->db->get_row("select * from earthchem.action where action_num = $searchid");

				if($row->action_num){

						
						$data['expedition_num']=$row->action_num;
						$data['expedition_name']=$row->action_name;
						$data['expedition_type_num']=$row->action_type_num;
						$data['sponsor_organization']=$row->organization_num;
						$data['description']=$row->action_description;
						$data['begin_date_time']=$row->begin_date_time;
						$data['end_date_time']=$row->end_date_time;
						
						$eqs=$this->db->get_results("select e.equipment_num from earthchem.equipment e, earthchem.equipment_action ea
													where e.equipment_num = ea.equipment_num and
													ea.action_num = $row->action_num
													");
						
						$eqnums=array();
						foreach($eqs as $eq){
							$eqnums[]=$eq->equipment_num;
						}
						
						$data['equipment_nums']=$eqnums;
						
						$data['identifier']=$this->db->get_var("select an.annotation_text from earthchem.annotation an, earthchem.action_annotation aa 
																where aa.action_num = $row->action_num
																and aa.annotation_num = an.annotation_num
																and an.annotation_type_num = 39
																limit 1
																");
						
						$alternate_names=$this->db->get_results("select an.annotation_text from earthchem.annotation an, earthchem.action_annotation aa 
																where aa.action_num = $row->action_num
																and aa.annotation_num = an.annotation_num
																and an.annotation_type_num = 40
																
																");

						$anames = array();
						foreach($alternate_names as $an){
							$an = $an->annotation_text;
							$anames[]=$an;
						}

						if($anames==""){$anames=null;}
						
						$data['alternate_names']=$anames;
						
				}else{
					header("Not Found", true, 404);
					$data["Error"] = "Expedition $id not found.";
				}
			}else{
				header("Not Found", true, 404);
				$data["Error"] = "Expedition $id not found.";
			}

        } else {
        	
        	if($_GET){
        	
        		if($_GET['query']){

					$querystring = strtolower($_GET['query']);
					
					if($this->is_whole_int($querystring)){$numquery = " or action_num = $querystring";}
					
					$rows = $this->db->get_results("select * from earthchem.action where 
													action_type_num in (3,11,12,25,19)
													and lower(action_name) like '%$querystring%' $numquery order by action_name;");
					
					$data['resultcount']=count($rows);
					if(count($rows) > 0){
						$results = [];
						foreach($rows as $row){
							
							$num = $row->action_num;
							$name = $row->action_name;
							
							$thisresult['expedition_num']=$num;
							$thisresult['expedition_name']=$name;
					
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

			if($p['expedition_name']!=""){ $action_name = "'".$p['expedition_name']."',"; }else{ $action_name = "null,"; }
			if($p['expedition_type_num']!=""){ $action_type_num = $p['expedition_type_num'].","; }else{ $action_type_num = "null,"; }
			if($p['expedition_sponsor_organization']!=""){ $action_sponsor_organization = $p['expedition_sponsor_organization'].","; }else{ $action_sponsor_organization = "null,"; }
			if($p['expedition_description']!=""){ $action_description = "'".$p['expedition_description']."',"; }else{ $action_description = "null,"; }
			if($p['expedition_begin_date']!=""){ $begin_date_time = "'".$p['expedition_begin_date']."',"; }else{ $begin_date_time = "null,"; }
			if($p['expedition_end_date']!=""){ $end_date_time = "'".$p['expedition_end_date']."',"; }else{ $end_date_time = "null,"; }

			if($p['expedition_identifier']!="")$expedition_identifier = $p['expedition_identifier'];
			if($p['alternate_names']!="")$alternate_names = $p['alternate_names'];
			if($p['equipment_nums']!="")$equipment_nums = $p['equipment_nums'];

/*
expedition_name
expedition_type_num
expedition_sponsor_organization
expedition_description
expedition_begin_date
expedition_end_date
*/

			$id = $this->db->get_var("select nextval('earthchem.action_action_num_seq')");
			$p['expedition_num']=$id;
			
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
						$action_sponsor_organization
						$action_description
						$begin_date_time
						$end_date_time
						1";
												
			
			//$query = substr($query, 0, -1);
			$query .= "\n);";

			//print_r($query);exit();
			
			
			$this->db->query($query);

			//put in expedition_identifier
			if($expedition_identifier!=""){
				$new_annotation_num = $this->db->get_var("select nextval('earthchem.annotation_annotation_num_seq')");
				$this->db->query("insert into earthchem.annotation (	
													annotation_num,
													annotation_type_num,
													annotation_text,
													data_source_num,
													annotation_entered_time
												)values(
													$new_annotation_num,
													39,
													'$expedition_identifier',
													140,
													now()
												)
												");
				
				$this->db->query("insert into earthchem.action_annotation (action_num, annotation_num) values ($id, $new_annotation_num);");
				
			}
			
			//put in alternate names
			if(count($alternate_names)>0){
				foreach($alternate_names as $an){

					$new_annotation_num = $this->db->get_var("select nextval('earthchem.annotation_annotation_num_seq')");
					$this->db->query("insert into earthchem.annotation (	
														annotation_num,
														annotation_type_num,
														annotation_text,
														data_source_num,
														annotation_entered_time
													)values(
														$new_annotation_num,
														40,
														'$an',
														0,
														now()
													)
													");
													
					$this->db->query("insert into earthchem.action_annotation (action_num, annotation_num) values ($id, $new_annotation_num);");

				}
			}
			
			if(count($equipment_nums)>0){
				foreach($equipment_nums as $enum){
					$this->db->query("insert into earthchem.equipment_action (equipment_num, action_num) values ($enum,$id);");
				}
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
						
					if($p['expedition_name']!="")$expedition_name = $p['expedition_name'];
					if($p['expedition_type_num']!="")$expedition_type_num = $p['expedition_type_num'];
					if($p['expedition_sponsor_organization']!="")$expedition_sponsor_organization = $p['expedition_sponsor_organization'];
					if($p['expedition_description']!="")$expedition_description = $p['expedition_description'];
					if($p['expedition_begin_date']!="")$expedition_begin_date = $p['expedition_begin_date'];
					if($p['expedition_end_date']!="")$expedition_end_date = $p['expedition_end_date'];
					if($p['expedition_identifier']!="")$expedition_identifier = $p['expedition_identifier'];
					if($p['alternate_names']!="")$alternate_names = $p['alternate_names'];
					if($p['equipment_nums']!="")$equipment_nums = $p['equipment_nums'];

					if($expedition_name!=""){$query.="action_name = '$expedition_name',\n";}else{$query.="action_name = null,\n";}
					if($expedition_type_num!=""){$query.="action_type_num = $expedition_type_num,\n";}else{$query.="action_type_num = null,\n";}
					if($expedition_sponsor_organization!=""){$query.="organization_num = $expedition_sponsor_organization,\n";}else{$query.="organization_num = null,\n";}
					if($expedition_description!=""){$query.="action_description = '$expedition_description',\n";}else{$query.="action_description = null,\n";}
					if($expedition_begin_date!=""){$query.="begin_date_time = '$expedition_begin_date',\n";}else{$query.="begin_date_time = null,\n";}
					if($expedition_end_date!=""){$query.="end_date_time = '$expedition_end_date',\n";}else{$query.="end_date_time = null,\n";}

					$query = substr($query, 0, -2);

					$this->db->query("
										update earthchem.action set
										$query
										where action_num = $id
									");
					
					//delete from action_annotation
					$ann_nums = array();
					$db_ann_nums = $this->db->get_results("select aa.annotation_num from earthchem.action_annotation aa, earthchem.annotation ann
															where aa.annotation_num = ann.annotation_num
															and aa.action_num = $id");
					
					foreach($db_ann_nums as $db_ann_num){
						$ann_nums[]=$db_ann_num->annotation_num;
					}

					if(count($ann_nums) > 0){
						$ann_nums_string = implode(",",$ann_nums);
						$this->db->query("delete from earthchem.action_annotation where annotation_num in ($ann_nums_string);");
						$this->db->query("delete from earthchem.annotation where annotation_num in ($ann_nums_string);");
					}

					//delete from equipment_action
					$this->db->query("delete from earthchem.equipment_action where action_num = $id");

					//put in expedition_identifier
					if($expedition_identifier!=""){
						$new_annotation_num = $this->db->get_var("select nextval('earthchem.annotation_annotation_num_seq')");
						$this->db->query("insert into earthchem.annotation (	
															annotation_num,
															annotation_type_num,
															annotation_text,
															data_source_num,
															annotation_entered_time
														)values(
															$new_annotation_num,
															39,
															'$expedition_identifier',
															140,
															now()
														)
														");
						
						$this->db->query("insert into earthchem.action_annotation (action_num, annotation_num) values ($id, $new_annotation_num);");
						
					}
					
					//put in alternate names
					if(count($alternate_names)>0){
						foreach($alternate_names as $an){

							$new_annotation_num = $this->db->get_var("select nextval('earthchem.annotation_annotation_num_seq')");
							$this->db->query("insert into earthchem.annotation (	
																annotation_num,
																annotation_type_num,
																annotation_text,
																data_source_num,
																annotation_entered_time
															)values(
																$new_annotation_num,
																40,
																'$an',
																0,
																now()
															)
															");
															
							$this->db->query("insert into earthchem.action_annotation (action_num, annotation_num) values ($id, $new_annotation_num);");

						}
					}
					
					if(count($equipment_nums)>0){
						foreach($equipment_nums as $enum){
							$this->db->query("insert into earthchem.equipment_action (equipment_num, action_num) values ($enum,$id);");
						}
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


