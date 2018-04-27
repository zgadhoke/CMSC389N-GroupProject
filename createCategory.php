<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<?php
session_start();

$host = "umdtalkdb.cqf37qcmlp7o.us-east-2.rds.amazonaws.com";
$user = "UMDtalk";
$password = "lkeMcds43#sd";
$database = "UMDtalk";

$db_connection = new mysqli($host, $user, $password, $database);
if ($db_connection->connect_error) {
    die($db_connection->connect_error);
    return -1;
}

/*//localDB
$servername = "cmsc389N-GroupProject";
$user = "user";
$password = "cmsc389N";

//Create Connection
$db_connection = new mysqli("localhost",$user,$password,$servername);

//Check Connection
if ($db_connection->connect_error) {
    die("Connection failed: " . $db_connection->connect_error);
}
//echo "Connected successfully";*/

$user = $_SESSION['user'];
$category = $_POST['category'];
$subject = $_POST['subject'];
$text = $_POST['text'];
$time = date('Y-m-d H:i:s');
$sql = ("INSERT INTO threads VALUES ('$user', '$time', '$category', '$subject', '$text')");
$result = $db_connection->query($sql);

if ($result) {
    $_SESSION["category"] = $category;
    echo "Your category has been created!<br>
    <form method=\"post\" action=\"thread.php\"> 
      <button class='btn btn-small btn-primary' type=\"submit\">Go to $category</button> 
    </form> ";

}
else {
    echo "Couldn't create category :(";
}

/* Freeing memory */
/*$result->close();*/
/* Closing connection */
/*$db_connection->close();*/

?>
<form method="post" action="categories.php">
    <button type="submit" class="btn btn-small">Return To Categories</button>
</form>
</body>
</html>


