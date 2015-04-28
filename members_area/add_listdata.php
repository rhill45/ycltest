<?php
//process pdf file upload
	if (isset($_FILES["flyer"]["name"]))
	{
		$allowedExtsf = array("pdf");
		$tempf = explode(".", $_FILES["flyer"]["name"]);
		$extensionf = end($tempf);
		if (($_FILES["flyer"]["type"] == "application/pdf") && ($_FILES["flyer"]["size"] < 524288000) && in_array($extensionf, $allowedExtsf)) 
		{

				  if (file_exists("../flyers/" . $_FILES["flyer"]["name"])) 
					   {
//if file exists, delete the file on the server
						  unlink("../flyers/" . $_FILES["flyer"]["name"]);
					   }
//move currrent pdf to the flyers folder
		move_uploaded_file($_FILES["flyer"]["tmp_name"],"../flyers/" . $_FILES["flyer"]["name"]);
//Make url of pdf file					
		$ad_link="http://www.mblistings.com/flyers/" . $_FILES["flyer"]["name"];
	  }
   }
	  else {
		  $ad_link = NULL;
	       }
  require('../dbcon2.php');
//Connection 1
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $stmt = $conn->prepare("UPDATE listings SET title = :title, address = :address, lot_size = :lot_size, zoning = :zoning, build_size = :build_size, sale_price = :sale_price, lease_price = :lease_price, comment = :comment, transaction = :transaction, ad_link = :ad_link WHERE id = :id");
//Bind
	  $stmt->bindParam(':id', $_POST['id']);
	  $stmt->bindParam(':title', $_POST['title']); 
	  $stmt->bindParam(':address', $_POST['address']);
	  $stmt->bindParam(':lot_size', $_POST['lot_size']);
	  $stmt->bindParam(':zoning', $_POST['zoning']);
	  $stmt->bindParam(':build_size', $_POST['build_size']);
	  $stmt->bindParam(':sale_price', $_POST['sale_price']);
	  $stmt->bindParam(':lease_price', $_POST['lease_price']);
	  $stmt->bindParam(':comment', $_POST['comment']);
	  $stmt->bindParam(':transaction', $_POST['transaction']);
	  $stmt->bindParam(':ad_link', $ad_link);
	$stmt->execute();
	
     $conn = null;
?>