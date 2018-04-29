<?php

	require_once("support.php");
	session_start();

	/* Default userName for testing purposes is zubin. This will should be blank otherwise and 
	 * below userName is set by the session variable */
	$userName = "zubin";
	//	print_r($_SESSION);
	if(isset($_SESSION['started']) && $_SESSION['started'] == 1) {
		$userName = $_SESSION['user'];
	}

	/* Local variable setup */
	$host = "umdtalkdb.cqf37qcmlp7o.us-east-2.rds.amazonaws.com";
    $user = "UMDtalk";
    $password = "lkeMcds43#sd";
    $database = "UMDtalk";

	$postsArray = array();
	$threadsArray = array();
	$bio = "";

	/* db queries for user's posts, threads, and biography */
    $query_bio = "select bio from users where name='$userName'";
    $query_posts = "select * from posts where user='$userName'";
    $query_threads = "select * from threads where user='$userName'";
    /* End local variable declarations */

    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
        echo "connection failed";
        return -1;
    }

    $result = $db_connection->query($query_bio);
	$result->data_seek(0);
	$bio = $result->fetch_array(MYSQLI_ASSOC)['bio']; 
	if (!$bio) $bio = "No biography added yet";
	

	/* Get all of the users posts from the db and set posts array */
    $result = $db_connection->query($query_posts);
	$rows = $result->num_rows;
	for ($idx = 0; $idx < $rows; $idx++) {
		$result->data_seek($idx);
		$postsArray[$idx] = $result->fetch_array(MYSQLI_ASSOC);
	} 
	
	/* Get all of the users threads from the db and set threads array */
	$result = $db_connection->query($query_threads);
	$rows = $result->num_rows;
	for ($idx = 0; $idx < $rows; $idx++) {
		$result->data_seek($idx);
		$threadsArray[$idx] = $result->fetch_array(MYSQLI_ASSOC);
	} 

	$result->close();

	//print_r($postsArray);
	//echo "<br />";
	//print_r($threadsArray);

    $htmlOpeningTags = <<<TAG
  	<h1>Your Profile</h1>
    <h4>Username: $userName</h4>
	<div class="container-fluid profile">
TAG;

	$htmlProfileInfo = <<<PIC
	<div class="profile-picture-frame">
		<!-- This element might become dynamically generated to be an img tag if we 
			add user ability to upload profile pictures -->
		<span class="profile-picture glyphicon glyphicon-align-center glyphicon-paperclip"></span>
	</div>
	<span class='biography'>
		<h5>Bio:</h5>
		<div id="bio">
			<em id="bio-text">$bio</em><span id="edit-bio" class="glyphicon glyphicon-pencil"></span>
		</div>
	</span>
PIC;


    $body = $htmlOpeningTags.$htmlProfileInfo."</div><h1 class='below-profile'>Your Posts</h1>";
	// add each post and thread as marked up to the $body variable
    foreach ($postsArray as $idx => $assoc) {
    	$body .= createPostsDisplay($assoc['text'], $assoc['time'], $assoc['thread']);
    }
    $body .= "<h1>Your Threads</h1>";
    foreach ($threadsArray as $idx => $assoc) {
    	$body .= createThreadsDisplay($assoc['text'], $assoc['time'], $assoc['category'], $assoc['subject']);
    }

    $body .= "<script <script src='asyncProfileUpdate.js'></script>";

    echo generatePage($body);

    /* Helper functions to generate list of posts and threads */
    function createPostsDisplay(string $text, string $time, string $thread) : string {
    	$str = <<<EOBODY
        <div class="row">
            <div class="col-xs-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Posted in: $thread</h4>
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
		return $str;
    }

    function createThreadsDisplay(string $text, string $time, string $category, string $subj) : string {
    	$subject = "No subject";
    	if ($subj) 
    		$subject = $subj;

    	$str = <<<EOBODY
        <div class="row">
            <div class="col-xs-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Category: $category</h4>
                    </div>
                    <div class="panel-body">
                        <h5>$subject</h5>
                        <em>$text</em>
                    </div>
                    <div class="panel-footer">
                        Posted at: $time
                    </div>
                </div>
            </div>
        </div>
EOBODY;
		return $str;
    }

?>
