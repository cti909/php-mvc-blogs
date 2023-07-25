<?php
include_once('config/main.php');
include_once("config/autoload.php");
$cn = isset($_GET["ctl"])? $_GET["ctl"]: "home";
if(!is_file('controllers/'.$cn.'_controller.php')) 	$cn = 'staticpages';
$c = $cn."_controller";
// echo $_GET["ctl"];
$controller = new $c();
//test git
?>

