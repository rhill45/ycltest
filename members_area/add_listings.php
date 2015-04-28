<?php 
ob_start();
session_start();
require_once ('verify.php'); 
$page_title = 'add_listings.php';
$sid = session_id();
$first_name=$_SESSION['first_name'];
$last_name=$_SESSION['last_name'];
$email_address=$_SESSION['email_address'];
		include ("../dbcon.php");
		$query="SELECT * FROM users WHERE email_address='$email_address'";
		$result=mysqli_query($con,$query);
		$data=mysqli_fetch_assoc($result);
	 		$userid = $data['userid'];
			$password = $data['password'];
			$signup_date = $data['signup_date'];
			$last_login = $data['last_login'];

// Check for a $page_title value:
if (!isset($page_title)) {
	$page_title = 'User Registration';
}
// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['email_address'])) {
	
	$url = BASE_URL . ''; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="icon" type="image/ico" href="http://www.mblistings.com/favicon.ico"/>
<title>Add Listings</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<link href="../css/cropper.min.css" rel="stylesheet">
<link href="../css/crop-avatar.css" rel="stylesheet">
<link href="../css/style_members_area.css" rel="stylesheet" />
<script type="text/javascript">
    function countChars(countfrom,displayto) {
        var len = document.getElementById(countfrom).value.length;
            document.getElementById(displayto).innerHTML = len
            ;}
</script>
</head>
<body>
<div id="loading-indicator" style="display:none"> </div>
<div id="container">
  <div id="head">
    <div id="logo">
      <div><img src="../0images/logo.png" alt="mblistings.com logo"/></div>
    </div>
    <ul id="menu">
      <li><a href="add_listings.php"><strong>Add listings</strong></a></li>
      <li><a href="edit_listings.php">Edit Listings</a></li>
      <li><a href="delete_listings.php">Delete Listings</a></li>
      <li><a href="../listings.php" target="_blank">View Listings (website)</a></li>
      <li><a href="settings.php">Account Settings</a></li>
      <li><a href="logout.php">Log Out</a></li>
      <li style="float:right;"><a href="../index.php"><img src="../0images/home-icon.png"  height="22" alt="mblistings.com home icon"/></a></li>
    </ul>
  </div>
  <div id="area"></div>
  <div class="main_listings" style="border:none;">
    <h1 align="left">ADMINISTRATORS PAGE</h1>
    <h2 align="left">Add Listings</h2>
    <h4 class="instruction" align="left">Click the image below to add a new listing:</h4>
    <div class="admin_listing_content">
      <div class="add_left"> 
        <!-- Begin Crop -->
        <div id="crop-avatar" class="container">
          <div class="bigpicture"> <img src="" > </div>
          <div class="avatar-view" title="Add new listing"> <img src="../0images/cropy.jpg" alt="Listing Image" width="400px"> </div>
          <div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="avatar-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form name="avatar-form" class="avatar-form" method="post" action="crop-avatar.php" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h1 class="modal-title" id="avatar-modal-label">Add new listing: Image</h1>
                  </div>
                  <div class="modal-body">
                    <div class="avatar-body">
                      <div class="avatar-upload">
                        <input class="avatar-src" name="avatar_src" type="hidden" >
                        <input class="avatar-data" name="avatar_data" type="hidden" >
                        <legend>
                        Image
                        <h6 style="display: inline;">Required</h6>
                        </legend>
                        <label for="avatarInput">Select image from computer</label>
                        <input style="display: inline; margin-left:10px;" class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                      </div>
                      <!-- Crop and preview -->
                      <div class="row">
                        <div class="col-md-9">
                          <div class="avatar-wrapper"></div>
                        </div>
                        <div class="col-md-3">
                          <div class="avatar-preview preview-lg"></div>
                          <div class="avatar-preview preview-md"></div>
                          <div class="avatar-preview preview-sm"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                    <button id="nxtbutt" class="btn btn-primary avatar-save" disabled type="submit">Save Image</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="add_right">
        <h4 class="instructiondata" style="padding-top:20px">Click the button below to add your pdf file and data:</h4>
        <button type="button" class="btn btn-success btn-sm" style="width: 100%;" data-toggle="modal" data-target="#modal1">Click here to add to this listing</button>
        <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
               <form name="data-form" class="data-form" method="post" action="add_data.php" enctype="multipart/form-data">
               <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h1 class="modal-title" id="avatar-modal-label">Add new listing: File and Data</h1>
                  </div>
              <div class="modal-body">
                <fieldset>
                  <legend>
                  PDF File Upload
                  <h6 style="display: inline;">Required</h6>
                  </legend>
                  <label for="fileUpload">Select pdf file from computer</label>
                  <input style="display: inline; margin-left:10px;" class="fileUpload" name="flyer" type="file"  />
                </fieldset>
                <legend>Listing Data</legend>
                <P class="h4" style="display: inline;">Title</P>
                <h6 style="display: inline;">Title is Required - Maximum 57 Characters</h6>
                <br />
                <textarea name="title" cols="60" rows="1" required id="title" placeholder="Required (Max 57)" onmouseout="countChars('title','charcount1');" onkeydown="countChars('title','charcount1');"
onkeyup="countChars('title','charcount1');"></textarea>
                <span id="charcount1">0</span> characters entered.<br>
                <br />
                <P class="h4">Address</P>
                <textarea name="address" cols="60" rows="1" id="address" placeholder="Maximum 50 characters. Defaults to BLANK." onmouseout="countChars('address','charcount2');" onkeydown="countChars('address','charcount2');"
onkeyup="countChars('address','charcount2');"></textarea>
                <span id="charcount2">0</span> characters entered.<br>
                <br />
                <P class="h4">Lease Price</P>
                <textarea name="lease_price" id="lease_price" cols="60" rows="1" placeholder="Maximum 40 Characters. Defaults to n/a."
onkeyup="countChars('lease_price','charcount3');" onkeydown="countChars('lease_price','charcount3');" onmouseout="countChars('lease_price','charcount3');"></textarea>
                <span id="charcount3">0</span> characters entered.<br>
                <br />
                <P class="h4">Sale Price</P>
                <textarea name="sale_price" id="sale_price"  cols="60" rows="1" placeholder="Maximum 30 Characters. Defaults to n/a."
onkeyup="countChars('sale_price','charcount4');" onkeydown="countChars('sale_price','charcount4');" onmouseout="countChars('sale_price','charcount4');"></textarea>
                <span id="charcount4">0</span> characters entered.<br>
                <br />
                <P class="h4">Lot Size</P>
                <textarea name="lot_size" id="lot_size"  cols="60" rows="1" placeholder="Maximum 30 Characters. Defaults to n/a."
onkeyup="countChars('lot_size','charcount5');" onkeydown="countChars('lot_size','charcount5');" onmouseout="countChars('lot_size','charcount5');"></textarea>
                <span id="charcount5">0</span> characters entered.<br>
                <br />
                <P class="h4">Building Size</P>
                <textarea name="build_size" id="build_size"  cols="60" rows="1" placeholder="Maximum 30 Characters. Defaults to n/a."
onkeyup="countChars('build_size','charcount6');" onkeydown="countChars('build_size','charcount6');" onmouseout="countChars('build_size','charcount6');"></textarea>
                <span id="charcount6">0</span> characters entered.<br>
                <br />
                <P class="h4">Zoning</P>
                <textarea name="zoning" id="zoning"  cols="60" rows="1" placeholder="Maximum 30 Characters. Defaults to n/a."
onkeyup="countChars('zoning','charcount7');" onkeydown="countChars('zoning','charcount7');" onmouseout="countChars('zoning','charcount7');"></textarea>
                <span id="charcount7">0</span> characters entered.<br>
                <br />
                <P class="h4">Comment</P>
                <textarea name="comment" id="comment"  cols="60" rows="1" placeholder="Maximum 30 Characters. Defaults to BLANK."
onkeyup="countChars('comment','charcount8');" onkeydown="countChars('comment','charcount8');" onmouseout="countChars('comment','charcount8');"></textarea>
                <span id="charcount8">0</span> characters entered.<br>
                <br />
                <h2>Listing Designation</h2>
                <fieldset style="padding-left:5px;">
                  <legend>
                  Designation
                  <h6 style="display: inline;">Required - Defaults to "Listings"</h6>
                  </legend>
                  <p>
                    <input name="transaction" type="radio" value="0" checked="checked"/>
                    <label>Listings</label>
                    <input style="margin-left:25px;" name="transaction" type="radio" value="1"/>
                    <label>Recent Transactions</label>
                  </p>
                  <p>
                    <input name="transaction" type="radio"  value="2"/>
                    <label>Both</label>
                    <input style="margin-left:44px;"  name="transaction" type="radio" value="3"/>
                    <label>Save, don't publish</label>
                  </p>
                </fieldset>
              </div>
              <div class="modal-footer">
                <input class="avatar-src" name="avatar_src" type="hidden">
                <input type="hidden" name="id" value="">
                <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                <button id="nxtbutttwo" class="btn btn-primary avatar-save" type="submit">Save Listing</button>
              </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
            </div>
          </div>
        </div>
      </div>
    <div class="add_display">
      <ul>
        <li>
          <p><span class="collab">Title: </span><strong>'.$row['title'].'</strong></p>
        </li>
        <li style="color: #FF0004">
          <p><span class="collab" style="color: #FF4245">Comment: </span> '.$row['comment'].'</p>
        </li>
        <li>
          <p><span class="collab">Address: </span> '.$row['address'].'</p>
        </li>
        <li>
          <p><span class="collab">Sale Price: </span> '.$row['sale_price'].'</p>
        </li>
        <li>
          <p><span class="collab">Lease Price: </span> '.$row['lease_price'].'</p>
        </li>
        <li>
          <p><span class="collab">Lot Size: </span> '.$row['lot_size'].'</p>
        </li>
        <li>
          <p><span class="collab">Building Size: </span> '.$row['build_size'].'</p>
        </li>
        <li>
          <p><span class="collab">Zoning: </span> '.$row['zoning'].'</p>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="spacer"></div>
</div>
<script Content-Type: application/javascript src="//code.jquery.com/jquery-1.11.1.min.js"></script> 
<script>
$("#avatarInput").on("change", function() {
    $("#nxtbutt").prop('disabled', !$(this).val()); 
});	
$(document).ready(function(){
	$(".add_right").hide();
	$(".add_display").hide();
	$(".bigpicture").hide();
	$(".instructiondata").hide();
});
$( "#nxtbutt" ).click(function () {
	$(document).ajaxSend(function(event, request, settings) {
    $('#loading-indicator').show();
});
	$(".add_right").show();
	$(".bigpicture").show();
	$(".add_display").hide();
	$("#avatar-modal").hide();
	$(".avatar-view").hide();
	$(document).ajaxComplete(function(event, request, settings) {
    setTimeout(function() {
		$('#loading-indicator').hide();
		$('#modal1').modal('show');
	}, 3000);
	
});
	
});

$( "#nxtbutttwo" ).click(function () {
		$(".instruction").hide();
	$(".instructiondata").show(); 
	$(".add_right").show();
	$(".add_display").show();
});

        </script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script> 
<script Content-Type: application/javascript src="../js/cropper.min.js"></script> 
<script Content-Type: application/javascript src="../js/crop-avatar.js"></script>
</body>
</html>
