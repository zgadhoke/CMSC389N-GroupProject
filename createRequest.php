<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<?php

function createNewUser($username, $pass)
{
    $host = "umdtalkdb.cqf37qcmlp7o.us-east-2.rds.amazonaws.com";
    $user = "UMDtalk";
    $password = "lkeMcds43#sd";
    $database = "UMDtalk";


    $passHash = password_hash($pass, PASSWORD_DEFAULT);

    /* Connecting to the database */
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
        return -1;
    }
    $n = "name";
    $check = ("select 1 from users where $n = '$username'");
    $checkResult = $db_connection->query($check);
    $count = mysqli_num_rows($checkResult);

    if ($count > 0) {
        echo "<h2>Username Already Exists :(</h2><br>";

        echo "<form method='post' action='signUp.html'>
                <button type='submit' class='btn btn-primary'>Go Back</button>
              </form>";
        $checkResult->close();
        $db_connection->close();
        return -1;
    }
    if (!$checkResult) {
        die("Insertion failed: " . $db_connection->error);
        return -1;
    }
    $checkResult->close();

    /* Query */
    $passHash = mysqli_escape_string($db_connection, $passHash);
    $username = mysqli_escape_string($db_connection, $username);

    $query = "insert into users values('$username', '$passHash')";
    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error);
        return -1;
    } else {
        echo "<h1>Welcome, $username</h1><br>";
        echo "<form method='post' action='loginScreen.html'> <button type='submit' class='btn btn-primary'>Go To Login</button>
              </form> ";
    }

    /* Closing connection */
    $db_connection->close();
    return 0;
}


if (isset($_POST["user"]) && isset($_POST["pass"])) {
    $u = $_POST["user"];
    $p = $_POST["pass"];
    createNewUser($u, $p);

}
?>
</body>
