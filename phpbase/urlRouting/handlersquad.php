<?php
	$url = $_SERVER["REQUEST_URI"];
	$ua = split("/", $url);
	$ua = array_filter($ua, 'strlen');
	$cn = "";
	$fn = "";
	$args = array();
	foreach ($ua as $key => $value) {
		if (!$cn){
			$cn = $value;
			continue;
		}
		if (!$fn){
			$fn = $value;
			continue;
		}
		array_push($args, $value);
	}
	if (!$fn) $fn = "index";
	require_once("{$_SERVER['DOCUMENT_ROOT']}/ESGB/controllers/{$cn}.php");
	if (method_exists("$cn", "$fn")){
		call_user_func_array(array($cn, $fn), $args); 
	}else{
		echo "Error The function '%s' on the class '%s' doesnot exists. Try implementing the method in controller.";
		echo "<br /> {$_SERVER["REQUEST_URI"]} not found";
	}
	

?>