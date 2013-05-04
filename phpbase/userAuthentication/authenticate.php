<?php
	
	//include authentication information
	require_once("{$_SERVER['DOCUMENT_ROOT']}/ESGB/phpbase/setting.php");
	
	require_once("{$_SERVER['DOCUMENT_ROOT']}/ESGB/phpbase/database/baseModel.php");
	# model for the authentication...
	class authUser extends baseModel{
		public $id;
		public $firstname;
		public $lastname;
		public $loginid;
		public $password;
		public $emailid;
		public $usergroup;
		public $batch;
		public $program;

		public function __construct($i=null, $fn="", $ln="", $lid="", $p = "", $eid = "", $ug = "", $ba = "", $pg = ""){
			parent::__construct();

			if ($i or $fn or $ln or $lid or $p or $eid or $ug or $ba or $pg){
				$this->id = $i;
				$this->firstname = $fn;
				$this->lastname = $ln;
				$this->loginid = $lid;
				$this->password = $p;
				$this->emailid = $eid;
				$this->usergroup = $ug;
				$this->batch = $ba;
				$this->program = $pg;
			}
		}

		public function getFields(){
			return "id, firstname, lastname, loginid, password, emailid, usergroup, batch, program";
		}
	}
	
	class authenticate{
		private $db;

		public function __construct(){
			$this->db = new authUser();
		}

		public function authenticateUser($loginId = "", $password = ""){
			if ( $loginId and $password){
				$user = $this->isUserValid($loginId, $password);
				if ($user){
					$this->setCookieSquad($user['id'], $user["firstname"], $user["lastname"], $user['password']);
					return true;
				}
			}else{
				return $this->isValidUserToken();
			}
			return false;
		}

		public function isUserValid($loginId, $password){
			$hp = $this->getHashedCode($password);
			$user = $this->db->selectUnique(array('loginid'=>$loginId, "password"=>$hp));
			return $user;
		}
		public function isValidUserToken(){
			if (isset($_COOKIE['name']) and isset($_COOKIE['token'])){
				$token = $_COOKIE['token'];
				$userName = $_COOKIE['name'];
				
				list($i, $h, $t) = explode("|", $token);
				list($fn, $ln) = explode(" ", $userName);

				$user = $this->db->selectUnique(array('id'=>$i));
				$rTok = $this->getSaltedToken($user['id'], $user['firstname'], $user['lastname'], $user['password'], $t);

				return $rTok==$token;

			}
			return false;
		}
		private function getHashedCode($s){
			$hc = hash("sha256", $s);
			return $hc;
		}
		private function getSaltedToken($uid, $fn, $ln, $ps, $r=""){
			$r = ($r)?$r:time();
			$jumbletumble = $ps[0].$this->getHashedCode($r).$ps.$ln.$fn;
			$token = $this->getHashedCode($jumbletumble);
			return $uid."|".$token."|".$r;
		}

		private function setCookieSquad($uid, $fn, $ln, $ps){
			$tk = $this->getSaltedToken($uid, $fn, $ln, $ps);
			$userName = $fn." ".$ln;

			setcookie("name", $userName, time()+86400);
			setcookie("token", $tk, time()+86400);

		}

		public function deleteCookie(){
			if (isset($_COOKIE['name']) and isset($_COOKIE['token'])){
				setcookie("name", "", time()-10);
				setcookie("token", "", time()-10);
			}
			return true;
		}
		// public function createTable(){
		// 	$sql = "CREATE TABLE `esgb`.`authUsers` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `firstname` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `lastname` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `loginid` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `password` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, `emailid` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, `usergroup` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT \'member\', UNIQUE (`loginid`, `emailid`)) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;";
		// }
		

	}

?>