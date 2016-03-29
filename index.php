<?php
session_start();
include_once 'users.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //verify if provided details are correct (e.g. not empty)
    //username doesn't have to be provided - we do not check that
    if (isset($_POST['login'])) {
        if (empty($email) || empty($password)) {
            $message = "Please add missing details in the form below";
        } else {
            $userObject = new User;
            /*
            if (isset($_SESSION['user'])) {
                $userObject->logout();
            }
            */
            $userObject->login($email, $password);
            $message = "You are logged. Now you can <a href='index.php'>go to main page</a>";

        }
    }
}

//set SESSION's value
if (!isset($_SESSION['user'])) {
    echo "error - no 'user' SESSION";
    //$userObject = new User;
    //$userObject->logout();
} else {
    echo "SESSION 'user' has started";
    $name = $_SESSION['user']['name'];
}

?>


<html lang="en-EN">
<head>
    <title>Login to Twit service</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="css/jumbotron-narrow.css" rel="stylesheet">

</head>
<body>

<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation" class="active"><a href="index.php">Home</a></li>
                <li role="presentation"><a href="profile.php">Profile</a></li>
                <li role="presentation"><a href="alltweets.php">Tweets</a></li>
                <li role="presentation"><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">Twits of <?php echo $name ?></h3>
    </div>

    <div class="jumbotron">
        <h1>Twit-like service</h1>
        <p class="lead">Add messages and share them with your friends. It is super easy!</p>
        <p><a class="btn btn-lg btn-success" href="addtweet.php" role="button">Add new twit</a></p>
    </div>

    <div class="row marketing">
        <div class="col-lg-6">
            <h4>Twit 1</h4>
            <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

            <h4>Twit 2</h4>
            <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet
                fermentum.</p>

            <h4>Twit 3</h4>
            <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
        </div>
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



