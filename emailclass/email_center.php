<?php 

$path = $_SERVER['DOCUMENT_ROOT'];

    require_once($path."/emailclass/class.phpmailer.php");
    require_once($path."/emailclass/class.smtp.php"); 

	//// Email Central inc file send email alert
	

   // $emailto = "greg@newagetouch.com";

//	if($emailto != '13866318311@mymetropcs.com'){   
//   	$bcc = 1;
//	$emailbcc = '13866318311@mymetropcs.com';
//	} 

	if(!isset($subject)){
	$subject = "Open Cloud Start Password Reset";
	}
	

////////////////////////////////////////////////////////////////
//  Setup following variables before requiring this 
//  file.
//  $emailto = 'customer email address'
//  $subject = 'email subject'
//  $body = 'html email'
//  $altbody = 'text email'
//  $attachfile = 0 - no   1 - yes
//  $reqfilename = 'path to file and filename'
//  $filename = 'customer seen filename'
//  $filetype = 1 - image/tif  2- application/pdf



$mail = new PHPMailer();
$mail->IsSendmail();        // set mailer to use SMTP
$mail->Host = "localhost";  // specify main and backup server
$mail->SMTPAuth = false;     // turn on SMTP authentication
$mail->Username = "greg@newagetouch.com";  // SMTP username
$mail->Password = "x6bj71006A"; // SMTP password
$mail->From = "no-reply@opencloudstart.com";
$mail->FromName = "OCS";
$mail->AddAddress($emailto);
if(isset($bcc)){

	$mail->AddBCC($emailbcc);

};

$mail->AddReplyTo("no-reply@opencloudstart.com", "No Reply");
$mail->WordWrap = 50;                                 // set word wrap to 50 characters

if(isset($attachfile)){

	$mail->AddAttachment($reqfilename,$filename,'base64',$filetype);         // add attachments

}

if(isset($attach2ndfile)){

	$mail->AddAttachment($req2filename,$filename2,'base64',$filetype2);

};



$mail->Subject = $subject;
$mail->Body    = $body;
$mail->AltBody = $altbody;


if(!$mail->Send())

{

   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;

}


