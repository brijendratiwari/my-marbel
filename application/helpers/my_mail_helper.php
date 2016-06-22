<?php

function mymail($email, $subject = FALSE, $message = FALSE, $headers = FALSE, $from = FALSE,$fromName=FALSE,$attachmentPath = '', $attachmentFileName = '') {

    $mail = new PHPMailer();

    
    $mail->IsSMTP(); // we are going to use SMTP
    
    $mail->SMTPAuth = true; // enabled SMTP authentication
    $mail->SMTPSecure = SMTP_Secure; // JOHNMOD
    $mail->Host = SMTP_HOST;      // setting GMail as our SMTP server
    $mail->Port = SMTP_PORT;                   // SMTP port to connect to GMail
    $mail->Username = SMTP_USERNAME;  // user email address
    $mail->Password = SMTP_PASSWORD;            // password in GMail
     
    if ($from != FALSE)
        $mail->SetFrom($from,$fromName);  //Who is sending the email
        
// $mail->AddReplyTo("ign@ignisitsolutions.com","Firstname Lastname");  //email address that receives the response
    if ($subject != FALSE) {
        $mail->Subject = $subject;
    }
    if ($message != FALSE) {
        $mail->Body = $message;
        $mail->AltBody = $message;
    }

    if (is_array($email) && count($email) > 0) {
        for ($i = 0; $i < count($email); $i++) {
            $destino = $email[$i]; // Who is addressed the email to

            $mail->AddAddress($destino, $destino);
        }
    } else {
        $destino = $email; // Who is addressed the email to
        $mail->AddAddress($destino, $destino);
    }

    if (!empty($attachmentPath)) {
			$file_to_attach = $attachmentPath;
			$mail->AddAttachment( $file_to_attach , $attachmentFileName );
		}
    //    $mail->AddAttachment("images/phpmailer.gif");      // some attached files
    //    $mail->AddAttachment("images/phpmailer_mini.gif"); // as many as you wan
    
    if (!$mail->Send()) {
        return FALSE;
    } else {
        return TRUE;
    }
}
