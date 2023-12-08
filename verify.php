<?php 
session_start();
//include("include/header.php");
include("include/config.php");
$errorMessage = '';
if(isset($_POST["otp"])&& $_POST["otp"]!=''){
	$sqlQuery = "SELECT * FROM authentication WHERE otp='". $_POST["otp"]."' AND email='".$_SESSION['login']."'";
	$result = mysqli_query($con, $sqlQuery);
	$count = mysqli_num_rows($result);
	if(!empty($count)) {
		   $now = new DateTime('now', new DateTimeZone(date_default_timezone_get()));
          $valid_date= new DateTime($data['expired']);
           if($now < $valid_date ){
           		 $now = new DateTime('now', new DateTimeZone(date_default_timezone_get()));
                //check code is still valid
           		$sqlUpdate = "UPDATE authentication SET expired='".$now->format('Y-m-d H:i:s')."' WHERE otp = '" . $_POST["otp"] . "'";
				$result = mysqli_query($con, $sqlUpdate);
				if($_SESSION['userGroup']=='patient'){
					header("location: dashboard.php");

				}else if($_SESSION['userGroup']=='doctor'){
					header("location: doctor/dashboard.php");
				}else{
					header("location: admin/dashboard.php");
				}
				            }
            $errorMessage = "Invalid OTP!";

	} else {
		$errorMessage = "Invalid OTP!";
	}	
} else if(!empty($_POST["otp"])){
	$errorMessage = "Enter OTP!";	
}	
?>
<title>webdamn.com : Demo Login System with OTP using PHP & MySQL</title>
<?php include('inc/container.php');?>
<div class="container">	
	<div class="col-md-12">   
	<h2>Example: Login System with OTP using PHP & MySQL</h2>	
	</div>
	<div class="col-md-6">                    
		<div class="panel panel-info" >
			<div class="panel-heading">
				<div class="panel-title">Enter OTP</div>                        
			</div> 
			<div style="padding-top:30px" class="panel-body" >
				<?php if ($errorMessage != '') { ?>
					<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>                            
				<?php } ?>
				<form id="authenticateform" class="form-horizontal" role="form" method="POST" action="">  					
					<div style="margin-bottom: 25px" class="input-group">
						<label class="text-success">Check your email for OTP</label>
						<input type="text" class="form-control" id="otp" name="otp" placeholder="One Time Password">
	                    
					</div>                          
					<div style="margin-top:10px" class="form-group">                               
						<div class="col-sm-12 controls">
						  <input type="submit" name="authenticate" value="Submit" class="btn btn-success">						  
						</div>
					</div>                                
				</form>   
			</div>                     
		</div>  
	</div>
</div>	
<?php include('inc/footer.php');?>



