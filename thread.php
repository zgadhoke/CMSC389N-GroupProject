<?php
require_once("support.php");

session_start();

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


echo "<table id=\"toolBar\">
    <tr>
        <td><form action=\"categories.php\" method=\"post\"><button type=\"submit\">Back to Categories</button> </form></td>
        <td><form action=\"viewProfile.php\" method=\"post\"><button type=\"submit\">View/Edit Profile</button> </form></td>
        <td><form action=\"loginScreen.html\" method=\"post\"><button type=\"submit\">LogOut</button> </form></td>
    </tr>
</table>
<hr>";

$thread_name = $_SESSION['category'];
$body = "";
if(isset($_POST['submitPost'])) {
    $post = $_POST['newPost'];
    $user = $_SESSION['user'];
    $date = date('Y/m/d H:i:s');
    $thread = $thread_name;
    $subject = '';
    $query = "insert into threads values('$user', '$date', '$thread', '$subject', '$post')";
    $result = $db_connection->query($query);
    if(!$result) {
        echo "messed up" . $db_connection->error;
    }
}


//building query to get posts for the thread
$query = "select * from threads where category = ";
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
    $user = $post[0];
    $time = $post[1];
    $text = $post[4];
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

$body .= <<<EOBODY
    <div class="row">
        <div class="col-xs-4">
            <div class="container-fluid">
                <form action="{$_SERVER['PHP_SELF']}" method="post">
                <strong>New Post: </strong><br>
                <textarea name="newPost" rows="6" cols="50"></textarea><br>
                <input type="submit" name="submitPost" value="Submit Post">
                </form>
            </div>
        </div>
    </div>
EOBODY;


$page = generatePage($body);

echo $page;




?>
