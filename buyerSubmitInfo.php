<!DOCTYPE html>
<html>
<head>
<title>Post message</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php

function rightFormat($variable){
      $newFormat=stripslashes($variable);
      $newFormat=str_replace("~", "-", $newFormat);
      return $newFormat;
}
#create a file to store buyer's information
$BuyerDir="BuyersEOI.txt";
if (isset($_POST['submit'])){

  #validata some infor first
  $validation=True;
  if(!is_numeric($_POST['phone'])){
    $validation=False;
    echo "phone number format is incorrect!<br/>";
  }
  if(!is_numeric($_POST['serialNumber'])){
    $validation=False;
    echo "serial number format is incorrect!<br/>";
  }

 
  
  #get all the variables with right format
  if($validation==True){
    $name = rightFormat($_POST['name']);
    $phone = rightFormat($_POST['phone']);
    $price = rightFormat($_POST['price']);
    $serialNumber = rightFormat($_POST['serialNumber']);
    #save all the variable together
    $buyerRecord="$name~$phone~$price~$serialNumber\n";
	$buyerResource = fopen($BuyerDir, "ab");
		#check the handle exist
		if ($buyerResource  === FALSE){
			echo "There was an error saving your game information!\n";
		}
		else 
		{
		    #write record to the handle and close the handle
			fwrite($buyerResource, $buyerRecord);
			fclose($buyerResource);
			echo "Your game information has been saved.\n";
			#after store the record, empty the input area
            $name = "";
            $phone = "";
            $serialNumber = "";
            $price = "";

		}  
 }
 }
else 
{
            $name = "";
            $phone = "";
            $serialNumber = "";
            $price = "";
}

?>
<h1>buyer Information </h1>
<hr />
<form action="buyerSubmitInfo.php" method="POST">
<p>personal information</p>
  <input type="text" name="name" placeholder="name">
  <br/>
  <br/>
  <input type="text" name="phone" placeholder="phone number">
  <br/>
  <br/>
<p>interested game information</p>
  <input type="text" name="serialNumber" placeholder="serial number">
  <br/>
  <br/>
  <input type="text" name="price" placeholder="proposing price">
  <br/>
  <br/>
<input type="submit" name="submit" value="Submit" />
<input type="reset" name="reset" value="Reset" />
</form>
<hr />
<p>
<a href="MyGamehomePage.php">back to home page</a>
</p>
</body>
</html>
