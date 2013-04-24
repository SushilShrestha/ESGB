<?php
	
	//include information about database
	include("{$_SERVER['DOCUMENT_ROOT']}/ESGB/php/setting.php");
	
	//base class that will be inherited in the coding
	class database{

		private $dbh;

		public function __construct(){
			$this->databaseConnect();
		}
		public function __destruct(){
			$this->dbh = null;
		}
		private function createDatabase(){
			global $hostName, $dbUser,$dbPassword, $dbName;
			try{
				$this->dbh = new PDO('mysql:host='.$hostName.';dbname=INFORMATION_SCHEMA',$dbUser,$dbPassword);
				
				$sql = "CREATE DATABASE IF NOT EXISTS ".$dbName." DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
				$q = $this->dbh->query($sql) or die(print_r($db->errorInfo(), true));

				$this->dbh = null;
				return true;
			
			}catch(PDOException $e){
				echo $e->getMessage();
				return false;
			}
		}

		private function databaseConnect(){
			global $hostName, $dbUser,$dbPassword, $dbName;
			try{
				$this->dbh = new PDO("mysql:host=".$hostName.";dbname=".$dbName, $dbUser, $dbPassword);
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
			global $hostName, $dbUser,$dbPassword, $dbName;
			if ($this->createDatabase()){
				try{
					$this->dbh = new PDO("mysql:host=".$hostName.";dbname=".$dbName, $dbUser, $dbPassword);
					return true;
				}catch(PDOException $e){
					return false;
				}
			}
		}
	}

?>
