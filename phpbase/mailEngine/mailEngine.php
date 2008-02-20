<?php

	require_once("{$_SERVER['DOCUMENT_ROOT']}/ESGB/phpbase/setting.php");

	function sendMail($to, $subject, $message){
		$headers = "From:" . $from;
		mail($to, $subject, $message, $headers);
		return true;
	}
	function sendMailViaSMTP(){
		require_once "Mail.php";

		$from = "Sandra Sender <sender@example.com>";
		$to = "Ramona Recipient <recipient@example.com>";
		$subject = "Hi!";
		$body = "Hi,\n\nHow are you?";

		$headers = array ('From' => $from,
		'To' => $to,
		'Subject' => $subject);
		$smtp = Mail::factory('smtp',
		array ('host' => $smtpHost,
		 'auth' => true,
		 'username' => $userName,
		 'password' => $password));

		$mail = $smtp->send($to, $headers, $body);

		if (PEAR::isError($mail)) {
		echo("<p>" . $mail->getMessage() . "</p>");
		} else {
		echo("<p>Message successfully sent!</p>");
		}

	}

?>