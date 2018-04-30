<head>
    <title>Categories</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="style.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>


    <table id="toolBar">
        <tr>
            <td><form action="createCategory.html" method="post"><button type="submit">Create a New Category</button> </form></td>
            <td><form action="viewProfile.php" method="post"><button type="submit">View/Edit Profile</button> </form></td>
            <td><form action="loginScreen.html" method="post"><button type="submit">LogOut</button> </form></td>
        </tr>
    </table>
    <hr>

<h2><u>Categories</u></h2>
    <?php
        session_start();

        if(isset($_POST['category'])) {
            $_SESSION['category'] = $_POST['category'];
            header("Location: thread.php");
        }
        /*
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
        */

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

        //$sql = ("select * from threads order by category");
        $sql = ("select distinct category from threads order by category");
        $result = $db_connection->query($sql);
        $count = mysqli_num_rows($result);

        if ($count == 0) {
            echo "<h3>No categories exist yet!</h3>";
        }

        echo "<form action='categories.php' method='post'>";
        while ($count > 0) {
            $row = $result->fetch_assoc();
            $category=$row['category'];
            echo "<button class='button' type='submit' name='category' value='$category'><h3>$category</h3></button><br>";
            $count--;
        }
        echo "</form>";

        /* Freeing memory */
        $result->close();
        /* Closing connection */
        $db_connection->close();
    ?>
</body>