<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="style.css" rel="stylesheet">
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

    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
        echo "connection failed";
        return -1;
    }


    $passHash = password_hash($pass, PASSWORD_DEFAULT);

    $n = "name";
    $check = ("select * from users where $n = '$username'");
    $checkResult = $db_connection->query($check);
    $result =  $checkResult->fetch_assoc();
   
    if ($username == $result["name"]) {
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

    $query = "insert into users values('$username', '$passHash', NULL)";
    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error);
        return -1;
    } else {
        echo "<h1>Welcome, $username</h1><br>";
        echo "<form method='post' action='loginScreen.html'> <button type='submit' class='btn btn-primary btn-small'>Go To Login</button>
              </form> ";
    }

    /* Closing connection */
    $db_connection->close();
    return 0;
}


if (isset($_POST["user"]) && isset($_POST["password"])) {
    $u = $_POST["user"];
    $p = $_POST["password"];

    createNewUser($u, $p);
}
?>
</body>
