<?php
	
	session_start();

	/* Local variable setup */
	$host = "umdtalkdb.cqf37qcmlp7o.us-east-2.rds.amazonaws.com";
    $user = "UMDtalk";
    $password = "lkeMcds43#sd";
    $database = "UMDtalk";

    $userName = "zubin";

    if(isset($_SESSION['started']) && $_SESSION['started'] == 1) {
		$userName = $_SESSION['user'];
	}

	if(isset($_GET['bio'])) {
		$bio = $_GET['bio'];
	}

	$query = "update users set bio='$bio' where name='$userName'";

	$db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
        echo "connection failed";
    }

   $db_connection->query($query);
   echo "$bio";

?>