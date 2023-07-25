<?php
// function __autoload($classname) {	// This function just work with PHP vervion <= 7.4
function myAutoload($classname) {
	if(strpos($classname, 'controller'))
		$filename = "controllers/". $classname .".php";
	else if(strpos($classname, 'model'))
		$filename = "models/". $classname .".php";
	else if(strpos($classname, 'helpers')) 
		$filename = "views/helpers/". $classname .".php";
	else if(strpos($classname, '_Component')) {
		$comFolder = str_split($classname, strrpos($classname, '_'))[0];
		$filename = "components/".$comFolder.'/'. $classname .".php";
	}
	else if($classname == "ConnectDb")	$filename = "config/". $classname .".php";
	
	if (is_file($filename)) include_once($filename);
	else exit("Your request file dose not exist!");
}

// This function work with PHP vervion 7.0 and higher
 spl_autoload_register('myAutoload');
?>
