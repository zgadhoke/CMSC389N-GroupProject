<head>
    <title>Categories</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<h3>Please Select A Category or <a href="createCategory.html">Create A New Category</a></h3>
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

        //$sql = ("select * from threads order by category");
        $sql = ("select distinct category from threads order by category");
        $result = $db_connection->query($sql);
        $count = mysqli_num_rows($result);

        if ($count == 0) {
            echo "<h3>No categories exist yet!</h3>";
        }
        
        while ($count > 0) {
            $row = $result->fetch_assoc();
            $_SESSION["category"] = $row[category];
            echo "<h2><a href='displayThread.php'>$row[category]</a></h2><br>";
            $count--;
        }


        /* Freeing memory */
        $result->close();
        /* Closing connection */
        $db_connection->close();
    ?>
</body>