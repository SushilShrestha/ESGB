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
require_once("phpbase/database/baseModel.php");


// class temp extends baseModel{
// 	public $id;
// 	public $name;
// 	public $password;
// 	public $des;

<<<<<<< HEAD
// 	public function __construct($i=null, $n="", $p="", $d=""){
// 		parent::__construct();
// 		if ($i or $n or $p or $d){
// 			$this->id = $i;
// 			$this->name = $n;
// 			$this->password = $p;
// 			$this->des = $d;
// 		}
// 	}

// 	public function getFields(){
// 		return "id, name, password, des";
// 	}
// }

// $tempModel = new temp(null, "healthy", "healthy", "this is a description.");
=======
$tempModel = new temp(null, "healthy", "healthy", "this is a description.");
>>>>>>> 2905361481b8c595b981a856175fb79734c30caa
// echo "test";

// print_r($tempModel->selectAll(30,"name","DESC"));
// print_r($tempModel->filter(array("id"=>1, "name"=>"happy")));
// print_r ($tempModel->search(array("des"=>"is")));  #search function is not working and will be fixed later
// echo $tempModel->getTableName();
// print_r($tempModel->addToDB());
// print_r($tempModel->removeFromDB(array("id"=>"13","name"=>"healthy")));
//  $tempModel = $tempModel->selectUnique(array("id"=>1, "name"=>"happy"));
//  $tempModel->password ="tappy";
//  print_r($tempModel);
// print_r($tempModel->updateDB())
// $tem = array(4,5,2);
// if ($tem){
// 	print_r($tem);
// 	echo "done";
// }

// echo "index.php file";


<<<<<<< HEAD
// require_once("phpbase/userAuthentication/authenticate.php");
// $ua = new authentication();
// $username = "codegluttoners";
// $password = "codegluttoners";
// // var_dump($ua->authenticateUser($username, $password));
// var_dump($ua->authenticateUser());

require_once("phpbase/mailEngine/mailEngine.php");
sendMailViaSMTP();
=======
require_once("phpbase/userAuthentication/authenticate.php");
$ua = new authentication();
$username = "codegluttoners";
$password = "codegluttoners";
// var_dump($ua->authenticateUser($username, $password));
var_dump($ua->authenticateUser());
>>>>>>> 2905361481b8c595b981a856175fb79734c30caa
?>