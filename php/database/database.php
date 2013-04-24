<?php
	
	//include information about database
	include("{$_SERVER['DOCUMENT_ROOT']}ESGB/php/setting.php");
	
	//base class that will be inherited in the coding
	class database{
		public function __construct(){
			$this->databaseConnect();
		}
		public function __destruct(){

		}
		private function createDatabase(){
			global $hostName, $dbUser,$dbPassword, $dbName;
			try{
				$dbh = new PDO('mysql:host='.$hostName.';dbname=INFORMATION_SCHEMA',$dbUser,$dbPassword);
				
				$sql = "CREATE DATABASE IF NOT EXISTS ".$dbName." DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
				$q = $dbh->query($sql) or die(print_r($db->errorInfo(), true));

				$dbh = null;
				return true;
			
			}catch(PDOException $e){
				echo $e->getMessage();
				return false;
			}
		}

		private function databaseConnect(){
			global $hostName, $dbUser,$dbPassword, $dbName;
			try{
				$db = new PDO("mysql:host=localhost;dbname=ESGB","root","");
				return true;

			}catch(PDOException $e){
				if ($this->createAndConnect()){
					return true;
				}else{
					echo "databaseconnect()".$e->getMessage();
					return false;
				}
			}
		}

		private function createAndConnect(){
			if ($this->createDatabase()){
				try{
					$dbh = new PDO("mysql:host=localhost;dbname=ESGB","root","");
					return true;
				}catch(PDOException $e){
					return false;
				}
			}
		}
	}

?>
