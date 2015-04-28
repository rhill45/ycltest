<?
error_reporting(E_ALL); ini_set('display_errors', 1);
include 'dbconuser.php';
$first_name = mysqli_real_escape_string($con, $_POST['first_name']);
$last_name = mysqli_real_escape_string($con, $_POST['last_name']);
$email_address = mysqli_real_escape_string($con, $_POST['email_address']);
$psswrd1 = mysqli_real_escape_string($con, $_POST['psswrd1']);
$psswrd2 = mysqli_real_escape_string($con, $_POST['psswrd2']);
$authcode = mysqli_real_escape_string($con, $_POST['authcode']);
$access='braccia2014';


if ($authcode==$access)


{
	if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
	include 'error_reg.htm';
	echo '<strong>You have entered an invalid email address!</strong> <br />';
	exit();
}
	
if((!$first_name) || (!$last_name) || (!$email_address))


{
	include 'error_reg.htm';
	echo '<strong>You are missing some required information!</strong> <br />';
	if(!$first_name){
		echo "First Name is a required field. Please enter it below.<br />";
	}
	if(!$last_name){
		echo "Last Name is a required field. Please enter it below.<br />";
	}
	if(!$email_address){
		echo "Email Address is a required field. Please enter it below.<br />";
	}
	 
	exit(); 
}


if ($psswrd1 != $psswrd2) {
	echo '<strong>You passwords did not match!</strong> <br />';
	include 'error_reg.htm';
	
	exit();
}

 $sql_email_check = mysqli_query($con,"SELECT email_address FROM users WHERE email_address='$email_address'");

 
 $email_check = mysqli_num_rows($sql_email_check);

 
 if(($email_check > 0)){
	 echo "<strong>Your email address has already been used by another member in our database. Please submit a different Email address!<br />";
	 include 'error_reg.htm';
 		
 		unset($email_address); 	

 	exit(); }

function makeRandomPassword() {
  $salt = "abchefghjkmnpqrstuvwxyz0123456789";
  srand((double)microtime()*1000000); 
  	$i = 0;
  	while ($i <= 7) {
    		$num = rand() % 33;
    		$tmp = substr($salt, $num, 1);
    		$pass = $num . $tmp;
    		$i++;
  	}
  	return $pass;
}

$random_password = makeRandomPassword();

$scode = md5($random_password);
$psswrd3 = md5($psswrd2);

$sql = mysqli_query($con,"INSERT INTO users (first_name, last_name, email_address, password, signup_date, code)
		VALUES('$first_name', '$last_name', '$email_address', '$psswrd3', now(), '$scode')") or die (mysqli_error());
if(!$sql){
	echo 'There has been an error creating your account. Please contact the webmaster.';
} else {
	$subject = "Administrative Membership to www.mblistings.com";
	$message = "Dear $first_name $last_name,
	Thank you for registering at http://www.mblistings.com
	
	With Admin Access you will be able to update content on your website.
	
	To activate your Admin Access, please click here: http://www.mblistings.com/members_area/activate.php?code=$scode
	
	Once you activate your memebership, you will be able to login with your registered email address and password:
	
	email address: $email_address
	password: $psswrd2 
	
	Thank you!
	
	This is an automated response, please do not reply!";
	
	mail($email_address, $subject, $message, "From: mblistings.com<admin@mblistings.com>\nX-Mailer: PHP/" . phpversion());
	include 'register_success.htm'; 
 	exit(); 
}
}
else
include 'error_authcode.htm';
exit()
?>