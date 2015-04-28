<?
error_reporting(E_ALL); ini_set('display_errors', 1);
include 'dbconuser.php';
$first_name = mysqli_real_escape_string($con, $_POST['first_name']);
$last_name = mysqli_real_escape_string($con, $_POST['last_name']);
$email_address = mysqli_real_escape_string($con, $_POST['email_address']);
$psswrd1 = mysqli_real_escape_string($con, $_POST['psswrd1']);
$psswrd2 = mysqli_real_escape_string($con, $_POST['psswrd2']);
$authcode = mysqli_real_escape_string($con, $_POST['authcode']);

	if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
	include 'error_reg.htm';
	echo '<strong>You have entered an invalid email address!</strong> <br />';
	exit();
	
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
	echo '<strong>Your passwords did not match!</strong> <br />';
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
$scode= password_hash($psswrd1, PASSWORD_DEFAULT)."\n";
$psswrd3 = password_hash($psswrd2, PASSWORD_DEFAULT)."\n";

$sql = mysqli_query($con,"INSERT INTO users (first_name, last_name, email_address, password, signup_date, last_login, code)
		VALUES('$first_name', '$last_name', '$email_address', '$psswrd3', now(), now(), '$scode')") or die (mysqli_error());
if(!$sql){
	echo 'There has been an error creating your account. Please contact the webmaster.';
} else {
	$subject = "Account created for www.freezerbase.com";
	$message = "Dear $first_name $last_name,
	
	Thank you for registering at freezerbase.
	
	With your activated account you will be able to create a new database and invite other users to access it.
	
	To activate your Admin Access, please click here: http://www.ylctest.com/php/activate.php?code=$scode
	
	Once you activate your memebership, you will be able to login with your registered email address and password:
	
	email address: $email_address

***We will never email you your password, if you forget your password you will have to reset it*** Please contact us immediately if you ever receive a correspondance about resetting your password, when you did not request it***

We take your privacy and account security seriously!!! Please do not hesistate to contact us about any questions or concerns regarding your account.

	Thank you!
	
	This is an automated response, please do not reply!";
	
	mail($email_address, $subject, $message, "From: freezerbase.com<admin@freezerbase.com>\nX-Mailer: PHP/" . phpversion());
	include 'register_success.htm'; 
 	exit(); 
}
}
else
include 'error_authcode.htm';
exit()
?>