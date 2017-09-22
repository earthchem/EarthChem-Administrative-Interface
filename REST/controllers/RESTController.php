<?php

/*
******************************************************************
ECDB REST API
REST Controller
Author: Jason Ash (jasonash@ku.edu)
Description: This is the base controller for the ECDB API.
				All other controllers stem from this class.
******************************************************************
*/

class RESTController
{
 	
 	public function setDB($db){
 		$this->db = $db;
 	}

 	public function dumpVar($var){
 		echo "<pre>";
 		print_r($var);
 		echo "</pre>";
 	}


}
