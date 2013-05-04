<?php
	require_once("{$_SERVER['DOCUMENT_ROOT']}ESGB/phpbase/userAuthentication/authenticate.php");

	class ESGB{
		public function index(){
			$auth = new authenticate();
			if ($auth->authenticateUser())
				$this->blog();
			else
				$this->landingPage();
		}
		public function blog(){
			print "this is the blog";
		}
		public function landingPage(){
			print "this is the landing page.";
		}
	}
?>