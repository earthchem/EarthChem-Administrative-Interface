<?php

/*
******************************************************************
Vocab REST API
Author: Jason Ash (jasonash@ku.edu)
Description: This codebase allows end-users to communicate with
			 the Vocabulary System.
******************************************************************
*/

//Initialize Databases
require_once "../includes/db_web.php";
require_once "../includes/EC2ODM2DatabaseClass.php";

$db = new EC2ODM2Database($db_web);

//Load Base Controller
include "./controllers/RESTController.php";

//Load Additional Controllers
foreach (glob("./controllers/*.php") as $filename){
    include_once $filename;
}

include "./library/Request.php";
include "./views/ApiView.php";
include "./views/JsonView.php";
include "./views/HtmlView.php";

$request = new Request();

//log raw input for debug
if(file_exists("log.txt")){
	$rawinput = file_get_contents("php://input");
	file_put_contents ("log.txt", "\n\n************************************************************************************************************************\n\n", FILE_APPEND);
	file_put_contents ("log.txt", "REQUEST: ".ucfirst($request->url_elements[1])."\n\n", FILE_APPEND);
	file_put_contents ("log.txt", "REQUEST_URI: ".$_SERVER["REQUEST_URI"]."\n\n", FILE_APPEND);
	file_put_contents ("log.txt", "Raw Input:\n".$rawinput, FILE_APPEND);
}

// route the request to the right place
$controller_name = ucfirst($request->url_elements[1]) . 'Controller';

$showcontroller = $request->url_elements[1];
if($showcontroller==""){$showcontroller="null";}

if (class_exists($controller_name)) {
    $controller = new $controller_name();
    $controller->setDB($db);
    $action_name = strtolower($request->verb) . 'Action';
    $result = $controller->$action_name($request);
}else{
	//send an error header with brief explanation.
	header("Bad Request", true, 404);
	$result['Error']="No such controller (".$showcontroller.")";
	header('Content-Type: application/json; charset=utf8');

}

$view_name = ucfirst($request->apiformat) . 'View';
if(class_exists($view_name)) {
	$view = new $view_name();
	$view->render($result);
}else{
	header("Bad Request", true, 400);
	echo "Error: $request->format output not supported.";
}