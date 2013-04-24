<?php
// try{
// 	$db = new PDO("mysql:host=localhost;dbname=ESGB","root","UBUNTU");
// 	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
// 	print("connection sucessful");
// }catch(PDOException $e){
// 	echo $e->getMessage();
// 	file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND); 
// }
// $db = null;
// print(phpinfo());
require_once("php/database/database.php");

$tempdb = new database();

echo "test";

?>