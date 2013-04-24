<?php

try{
	$db = new PDO("mysql:host=localhost;dbname=ESGB","root","");
}catch(PDOException $e){
	echo $e->getMessage();
}

try{
	$db = new PDO('mysql:host=localhost;dbname=INFORMATION_SCHEMA',"root","");
	
	$sql = "CREATE DATABASE IF NOT EXISTS ESGB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
	$q = $db->query($sql) or die(print_r($db->errorInfo(), true));

	echo "done";
	if ($q->rowCount() == 0){
		# create new database
	}


}catch(PDOException $e){
	echo $e->getMessage();
}

?>

Call for volunteers,
We are builidng our very own Esgb website for that we are in need of some volunteers(esp. Designers). Intrested members please comment.