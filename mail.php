<?php

require_once "phpmailer/PHPMailerAutoload.php";


function smtpmailer($to, $to_name, $from, $from_name, $subject, $body) {

	//PHPMailer Object
	$mail = new PHPMailer;

	//From email address and name
	$mail->From = $from;
	$mail->FromName = $from_name;

	//To address and name
	$mail->addAddress($to, $to_name);
	// $mail->addAddress("recepient1@example.com"); //Recipient name is optional

	//Address to which recipient will reply
	$mail->addReplyTo($from, "Reply");

	//CC and BCC
	// $mail->addCC("cc@example.com");
	// $mail->addBCC("bcc@example.com");

	//Send HTML or Plain Text email
	$mail->isHTML(true);

	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AltBody = "This is the plain text version of the email content";

	if(!$mail->send())
	{
	    echo "Mailer Error: " . $mail->ErrorInfo;
	}
	else
	{
	    echo "Message has been sent successfully";
	}

}
//smtpmailer('nusrohdev@gmail.com','Nusroh Dev', 'syazwanasman@gmail.com', 'Syazwan Asman', 'Ini ada tajuk', 'This is content of the email.');
