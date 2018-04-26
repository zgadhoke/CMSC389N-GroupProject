<?php
require_once("support.php");

session_start();

$host = "umdtalkdb.cqf37qcmlp7o.us-east-2.rds.amazonaws.com";
$user = "UMDtalk";
$password = "lkeMcds43#sd";
$database = "UMDtalk";

/* Connecting to the database */
$db_connection = new mysqli($host, $user, $password, $database);
if ($db_connection->connect_error) {
    die($db_connection->connect_error);
    return -1;
}

$thread_name = $_SESSION['thread'];
$body = "";

//building query to get posts for the thread
$query = "select * from posts where thread = ";
$query .= "\"$thread_name\"";
$query .= " order by time";

//getting selection as a multidimensional array
$result = $db_connection->query($query);
$posts = mysqli_fetch_all($result, MYSQLI_NUM);

$body .= <<<EOBODY
<div class="container-fluid">
    <h1>$thread_name</h1>

EOBODY;

foreach($posts as $post) {
    $user = $post[2];
    $time = $post[1];
    $text = $post[0];
    $body .= <<<EOBODY
        <div class="row">
            <div class="col-xs-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">User: $user</h4>
                    </div>
                    <div class="panel-body">
                        $text
                    </div>
                    <div class="panel-footer">
                        Posted at: $time
                    </div>
                </div>
            </div>
        </div>
EOBODY;
}

$body .= "</div>";

$page = generatePage($body);

echo $page;




?>