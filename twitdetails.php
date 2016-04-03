<?php
session_start();
include_once 'include.php';

//set SESSION's value
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
} else {
    $name = $_SESSION['user']['name'];
}

//possibility to add comment to the twit
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $userIdComment = $_SESSION['user']['id'];
    $twitId = $_GET['twitId'];
    $textComment = $_POST['textcomment'];
    $currentTime = date("Y-m-d h:i:s");

    $newComment = new Comment();
    $newComment->setUserId($userIdComment);
    $newComment->setTwitId($twitId);
    $newComment->setCommentText($textComment);
    $newComment->setCreatedTimeComment($currentTime);
    $newComment->saveToDB($conn);

}

//Showing all twits of a user
if (isset($_GET['twitId'])) {
    $twitId = $_GET['twitId'];
    $resultTwitDetailsQuery = Tweet::getTwitDetails($twitId);

    $showComments = Comment::GetAllCommentsForTwit($conn, $twitId);
    $numberOfComments = count($showComments);

}



//presenting all comments to the twit



?>


<html lang="en-EN">
<head>
    <title>Details of the Twit</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/jumbotron-narrow.css" rel="stylesheet">


</head>
<body>

<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="index.php">My Twits</a></li>
                <li role="presentation"><a href="profile.php">My Profile</a></li>
                <li role="presentation"><a href="mymessages.php">My Messages</a></li>
                <li role="presentation"><a href="twits.php">All Twits</a></li>
                <li role="presentation"><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">Welcom <?php echo $name ?>!</h3>
    </div>

    <div id="content">
        <h3>Details of the twit</h3>

            <?php

            foreach($resultTwitDetailsQuery as $twit){
                echo "<div class='panel panel-default'>";
                echo "<div class='panel-body'>{$twit->getTwitText()}</div>";
                echo "<div class='panel-footer'>Created time: {$twit->getCreatedTime()}</div>";
                $twitUserId = $twit->getUserId();
                $twitUserDetails = User::getUserProfile($twitUserId);
                foreach($twitUserDetails as $key => $user) {
                    echo "<div class='panel-footer'>"."Created by: {$user->getName()}, "."<a href='userdetails.php?userId={$user->getId()}'>Check user's profile</a></div>";
                }
                echo "<div class='panel-footer'>Nr of comments: {$numberOfComments}</div>";

                echo "</div>";
            }
            ?>
        <br />

        <h3>Add comment to the twit</h3>
        <form action="#" method="POST" class="form-signin" id="textcomment">
            <div class="form-group">
                <textarea rows="4" cols="30" name="textcomment" id="textcomment" form="textcomment" maxlength="60" placeholder="Add comment below (60 chars maximum)"></textarea><br/>
            </div>
            <button type="submit" name="comment" class="btn btn-primary btn-lg">Send comment</button>
        </form>
        <br />

        <h3>List of all comments</h3>
        <?php

        if(count($showComments) > 0) {
            foreach ($showComments as $key => $comment) {
                echo "<div class='panel panel-default'>";
                echo "<div class='panel-body'>{$comment->getCommentText()}</div>";
                $commentUserId = $comment->getUserId();
                $commentUserDetails = User::getUserProfile($commentUserId);
                echo "<div class='panel-footer'>Created time: {$comment->getCreatedTimeComment()}</div>";
                echo "<div class='panel-footer'>Created by: {$commentUserDetails[0]->getName()},
                    <a href='userdetails.php?userId={$commentUserDetails[0]->getId()}'>Check user's profile</a></div>";
                echo "</div>";
            }
        }else {
            echo "<div class=\"alert alert-warning\" role=\"alert\">";
            echo "The twit hasn't received any comments yet";
            echo '</div>';
        }
        ?>
        <br />

    </div>
    <nav>
        <ul class="nav nav-pills pull-right">
            <li role="presentation"><a href="login.php">Login</a></li>
            <li role="presentation"><a href="registration.php">Registration</a></li>
        </ul>
    </nav>
    <footer class="footer">
        <p>&copy; Jakub Pawelczak</p>
    </footer>

</div> <!-- /container -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>

</body>
</html>



