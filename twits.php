<?php
session_start();
include_once 'include.php';

//set SESSION's value
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
} else {
    $name = $_SESSION['user']['name'];
    $userAllTwits = new Tweet();
    $resultAllTwitsQuery = Tweet::getAllTwits();

}

?>


<html lang="en-EN">
<head>
    <title>User's details</title>
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
                <li role="presentation" class="active"><a href="twits.php">All Twits</a></li>
                <li role="presentation"><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">Welcome <?php echo $name ?>!</h3>
    </div>


    <div id="content">

        <h3>All twits</h3>

        <?php

        if(count($resultAllTwitsQuery) > 0) {
            foreach ($resultAllTwitsQuery as $key => $twit) {
                echo "<div class='panel panel-default'>";
                echo "<div class='panel-body'>{$twit->getTwitText()}</div>";
                echo "<div class='panel-footer'>Created time: {$twit->getCreatedTime()}</div>";
                $twitUserDetails = User::getUserProfile($twit->getUserId());
                foreach($twitUserDetails as $key => $user) {
                    echo "<div class='panel-footer'>"."Created by: {$user->getName()}, "."<a href='userdetails.php?userId={$user->getId()}'>Check user's profile</a></div>";
                }
                $showComments = Comment::GetAllCommentsForTwit($conn, $twit->getTwitId());
                $numberOfComments = count($showComments);
                echo "<div class='panel-footer'>Nr of comments: {$numberOfComments}, <a href='twitdetails.php?twitId={$twit->getTwitId()}'>Read comments</a></div>";
                echo "</div>";
            }
        } else {
            echo "<div class=\"alert alert-warning\" role=\"alert\">";
            echo "Error - No twits to show!";
            echo '</div>';
        }

        ?>

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



