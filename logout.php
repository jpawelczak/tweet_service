<?php
session_start ();
include_once 'include.php';

//set SESSION's value
if(!isset($_SESSION['user'])) {
    echo "No 'user' SESSION";
} else {
    $userObject = new User;
    $userObject->logout();
}

?>

<html lang="en-EN">
<head>
    <title>Logout from Twit service</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
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
                <li role="presentation"><a href="login.php">Login</a></li>
                <li role="presentation"><a href="registration.php">Registration</a></li>
            </ul>
        </nav>
    </div>

    <div class="jumbotron">
        <h1>Thank you for using the Twit-like service</h1>
        <p class="lead">Add messages and share them with your friends. It is super easy!</p>
        <p><a class="btn btn-lg btn-success" href="login.php" role="button">Add new twit</a></p>
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

</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>