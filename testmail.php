<?php
	function sendmail($to, $subject, $message, $from){
	               //send email to user and admin
                      //copy the trading 
                       ini_set('display_errors', 1);
                       error_reporting(E_ALL);
                      // The content-type header must be set when sending HTML email
                       $headers = "MIME-Version: 1.0" . "\r\n";
                       $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                       $headers = "From:" . $from;
                       if(mail($to,$subject,$message, $headers)) {
                       		echo "Mail sent";
                       } else {
                          //log in email status
                        	echo "error sending mail";
                       }
}


sendmail("jeoebicom@gmail.com", "Local host test", "this is a test mail", "erepamofawe.mail@gmail.com");