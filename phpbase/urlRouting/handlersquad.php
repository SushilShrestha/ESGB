<?php
	$url = $_SERVER["REQUEST_URI"];
	$ua = explode("/", $url);
	$ua = array_filter($ua, 'strlen');			// removing the empty array elements
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
	
	$docRoot = $_SERVER['DOCUMENT_ROOT'];
	$sCheck = substr($docRoot, strlen($docRoot)-1, strlen($docRoot));
	if ($sCheck != "/")
		$docRoot .= "/";

	require_once("{$docRoot}ESGB/phpbase/setting.php");
	if (!$fn and !$cn)
		$cn = $domainBaseHandler;
	if (!$fn) $fn = "index";
	
	require_once("{$docRoot}ESGB/controllers/{$cn}.php");
	if (method_exists("$cn", "$fn")){
		$cnO = new $cn();
		call_user_func_array(array($cnO, $fn), $args); 
		var_dump($_SERVER);
	}else{
		echo "Error The function '$fn' on the class '$cn' doesnot exists. Try implementing the method in controller.";
		echo "<br /> {$_SERVER["REQUEST_URI"]} not found";
	}
	

?>