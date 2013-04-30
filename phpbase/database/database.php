<?php
	
	//include information about database
	require_once("{$_SERVER['DOCUMENT_ROOT']}/ESGB/phpbase/setting.php");
	
	# database handler object
	$dbh = null;
	class database{
		public function __construct(){
			$this->databaseConnect();		#connect database
		}
		public function __destruct(){
			global $dbh;
			$dbh = null;			# disconnect database
		}

		private function createDatabase(){		# if not created, create the database
			global $dbh, $hostName, $dbUser,$dbPassword, $dbName;
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
			global $dbh, $hostName, $dbUser,$dbPassword, $dbName;
			try{				# try to connect the database
				$dbh = new PDO("mysql:host=".$hostName.";dbname=".$dbName, $dbUser, $dbPassword);
				return true;

			}catch(PDOException $e){		# database does not exists
				if ($this->createAndConnect()){				# create and connect the database
					return true;
				}else{										# failed to create and connect
					echo "databaseconnect()".$e->getMessage();
					$dbh = null;
					return false;
				}
			}
		}

		private function createAndConnect(){
			global $dbh, $hostName, $dbUser,$dbPassword, $dbName;
			if ($this->createDatabase()){		# if creation of databasei is sucessful, try connecting the database
				try{
					$dbh = new PDO("mysql:host=".$hostName.";dbname=".$dbName, $dbUser, $dbPassword);
					return true;
				}catch(PDOException $e){
					return false;
				}
			}
		}

		public static function isDBHLoaded(){		# to check whether database has been connected or not
			global $dbh;
			return ($dbh != null);
		}

	}



?>
