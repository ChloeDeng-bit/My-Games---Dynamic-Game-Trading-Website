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
#create a file to store game information
$GameDir="GamesDirectory.txt";
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
  $email=$_POST['email'];
  if(filter_var($email, FILTER_VALIDATE_EMAIL)==False){
    echo "email format is incorrect!";
    $validation=False;
  }  
  
  #get all the variables with right format
  if($validation==True){
    $name = rightFormat($_POST['name']);
    $phone = rightFormat($_POST['phone']);
    $email = rightFormat($_POST['email']);
    $serialNumber = rightFormat($_POST['serialNumber']);
    $type = rightFormat($_POST['type']);
    $releaseYear = rightFormat($_POST['releaseYear']);
    $originalPackage= rightFormat($_POST['originalPackage']);
    $description = stripslashes($_POST['description']);
	$description = str_replace("~", "-", $description);
    $description = str_replace("\n", "-", $description);
    $ExistingSerialNumber = array();

    #if the file has record
	if (file_exists($GameDir) && filesize($GameDir)> 0) 
	{ 
	    #parse game text file to array
		$gameArray = file($GameDir);
		$count = count($gameArray);
		for ($i = 0; $i < $count; ++$i) {
		    
			$CurrRecord = explode("~", $gameArray[$i]);
			#set an array for all the serial number
			$ExistingSerialNumber[] = $CurrRecord[3];
		}
	}
    
    #check if serial number unique or not
	if (in_array($serialNumber,$ExistingSerialNumber)) 
	{
		echo "<p>The serial number you entered already exists!<br />\n";
		echo "Please enter a new serial number and try again.<br />\n";
		echo "Your serial number was not saved.</p>"; 
		$serialNumber = "";
	}
	else 
	{   #put all information in one record
		$gameRecord = "$name~$phone~$email~$serialNumber~$type~$description~$releaseYear~$originalPackage\n";
		#create handle and put pointer to the end
		$gameResource = fopen($GameDir, "ab");
		#check the handle exist
		if ($gameResource  === FALSE)
			echo "There was an error saving your game information!\n";
		else 
		{
		    #write record to the handle and close the handle
			fwrite($gameResource, $gameRecord);
			fclose($gameResource);
			echo "Your game information has been saved.\n";
			#after store the record, empty the input area
            $name = "";
            $phone = "";
            $email = "";
            $serialNumber = "";
            $type = "";
            $releaseYear = "";
            $originalPackage= "";
            $description= "";

		}
	}
    
  }
}
else 
{
            $name = "";
            $phone = "";
            $email = "";
            $serialNumber = "";
            $type = "";
            $releaseYear = "";
            $originalPackage= "";
            $description= "";
}

?>
<h1>Seller Information </h1>
<hr />
<form action="sellerSubmitInfo.php" method="POST">
<p>personal information</p>
  <input type="text" name="name" placeholder="name">
  <br/>
  <br/>
  <input type="text" name="phone" placeholder="phone number">
  <br/>
  <br/>
  <input type="text" name="email" placeholder="email">
  <br/>
  <br/>
<p>basic information</p>
  <input type="text" name="serialNumber" placeholder="serial number">
  <br/>
  <br/>
  <input type="text" name="type" placeholder="type">
  <br/>
  <br/>
  <textarea name="description" rows="6" cols="80" placeholder="short description"></textarea><br />
<p>details</p>
  <input type="text" name="releaseYear" placeholder="year of release">
  <br/>
  <br/>
  <input type="text" name="originalPackage" placeholder="original package">
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
