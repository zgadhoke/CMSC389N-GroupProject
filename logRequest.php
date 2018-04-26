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

function login($username, $pass)
{

    $host = "umdtalkdb.cqf37qcmlp7o.us-east-2.rds.amazonaws.com";
    $user = "UMDtalk";
    $password = "lkeMcds43#sd";
    $database = "UMDtalk";

    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }


    //localDB
   /* $servername = "cmsc389N-GroupProject";
    $user = "user";
    $password = "cmsc389N";

    //Create Connection
    $db_connection = new mysqli("localhost",$user,$password,$servername);

    //Check Connection
    if ($db_connection->connect_error) {
        die("Connection failed: " . $db_connection->connect_error);
    }
    //echo "Connected successfully";*/

    $n = "name";
    /* Query */
    $username = mysqli_escape_string($db_connection, $username);
    $query = "select * from users where $n = '$username'";

    /* Executing query */
    $result = $db_connection->query($query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $db_pass = $row['password'];
    echo($row['password']);
    //Finding Password in database to compare too
    /*foreach ($row as $key => $value) {
        if ($key == "password") {
            $db_pass = $value;
            break; //1 password has been found for username
        }
    }*/

    if (!$result) { //Error talking to database
        die("Retrieval failed: " . $db_connection->error);
    } else if (password_verify($pass, $db_pass)) {//Successfully logged in
        $_SESSION['user'] = $username;
        $_SESSION['pass'] = $db_pass;
        $_SESSION['started'] = 1;
        $_SESSION['db_connection'] = $db_connection;
        header("Location: categories.php");
    } else {
        //Invalid Credentials
        echo "<h2>Username or Password does not exist</h2><br>";

        echo "<form method='post' action='loginScreen.html'> <button type='submit'> Try Again</button>
              </form> ";

    }

    /* Freeing memory */
    $result->close();
    /* Closing connection */
    //$db_connection->close();

}

if($_SESSION['started'] == 1) {
    header("Location: categories.php");
} else if (isset($_POST["username"]) && isset($_POST["password"])) {
    $u = $_POST["username"];
    $p = $_POST["password"];
    login($u, $p);
}


?>
</body>
</html>

