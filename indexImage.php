<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BLOB Data Type Tutorial</title>
</head>

<body>
<form action="indexImage.php" method="POST" enctype="multipart/form-data">
	<input type="file" name="image"><input type="submit" name="submit" value="Upload">
</form>
<?php

if(isset($_POST['submit']))
{

    //Network DB
    $host = "umdtalkdb.cqf37qcmlp7o.us-east-2.rds.amazonaws.com";
    $user = "UMDtalk";
    $password = "lkeMcds43#sd";
    $database = "UMDtalk";

    /*$host = "localhost";
    $database = "cmsc389N-GroupProject";
    $user = "user";
    $password = "cmsc389N";*/

    /* Connecting to the database */
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
        return -1;
    }
	
	$imageName = $db_connection->real_escape_string($_FILES["image"]["name"]);
	$imageData = $db_connection->real_escape_string(file_get_contents($_FILES["image"]["tmp_name"]));
	$imageType = $db_connection->real_escape_string($_FILES["image"]["type"]);

	
	if(substr($imageType,0,5) == "image")
	{
		$db_connection->query("update users set profilePicture='$imageData' where name='harry'");	
		echo "Image Uploaded!";

		$res = $db_connection->query("select profilePicture from users where name='harry'");
		$res->data_seek(0);
		$imageData = $res->fetch_array(MYSQLI_ASSOC)['profilePicture']; 
		echo '<img src="data:image/jpeg;base64,'.base64_encode( $imageData ).'"/>';
	}
	else
	{
		echo "Only images are allowed!";
	}
	
}

?>



</body>
</html>