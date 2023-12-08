<?php
	
include("include/config.php");
include("include/mail.php");
include("include/create_otp.php");

//generate random number gotten from crud source code save.php
function generateRandomNumber($length=10,$number) {

	$generated_number = []; 
	for ($j=0; $j<(int)$number; $j++){
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		$generated_number[] = $randomString;
	}
    return $generated_number;
}


  function generate_otp($id, $email){

  	$otp =generateRandomNumber(4,1)[0];
  	$now = new DateTime('now', new DateTimeZone(date_default_timezone_get()));
    $exp_date= date_add($now,date_interval_create_from_date_string("1 hour"));

  	//prepare sql query
  	$sql='insert INTO authentication (id, otp, expired, created) VALUES('.$id.', "'.$otp.'", "'.$exp_date->format('Y-m-d H:i:s').' ", "'.$now->format('Y-m-d H:i:s').'")';
  	 $result= $con->query($sql);
     if($result){
          sendmail($email,"Jenny HMS","use the OTP  to login ".$otp, "no-reply@jennyhms.com");
      }


  }
 		

?>