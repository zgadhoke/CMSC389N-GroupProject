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

//localDB
$servername = "cmsc389N-GroupProject";
$user = "user";
$password = "cmsc389N";

//Create Connection
$db_connection = new mysqli("localhost",$user,$password,$servername);

//Check Connection
if ($db_connection->connect_error) {
    die("Connection failed: " . $db_connection->connect_error);
}
//echo "Connected successfully";
$category = $_SESSION['category'];
echo $category;
$sql = ("select * from threads order by category");
$result = $db_connection->query($sql);


if($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $author = $row['user'];
        $time = $row['time'];
        $category = $row['category'];
        $subject = $row['subject'];
        $text = $row['text'];
        $text_short = substr($text, 0,20);

        echo "<h2><a href='displayPost.php'>$subject</a></h2><br>";
    }
}
else {
    die("Error: " . $db_connection->error);
    return -1;
}

?>
<form method="post" action="categories.php">
    <button type="submit" class="btn btn-small">Return To Categories</button>
</form>
</body>
</html>


