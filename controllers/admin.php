<?php
require_once("{$_SERVER['DOCUMENT_ROOT']}ESGB/phpbase/userAuthentication/authenticate.php");
class admin{
	function memberform(){
		include("{$_SERVER['DOCUMENT_ROOT']}ESGB/views/addmember.php");
	}
	function addmember(){
		var_dump($_POST);
		$userH = new authUser(null, $_POST['firstname'], $_POST['lastname'], $_POST['firstname'].$_POST['lastname'], $_POST['password'], $_POST['emailid'], "member", $_POST['batch'], $_POST['program']);
		$userH->addToDB();
		echo "done";
		$this->memberform();
	}
}

?>