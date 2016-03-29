<?php
session_start ();

include_once 'users.php';

//set SESSION's value
if(!isset($_SESSION['user'])) {
    echo "error - no 'user' SESSION";
    var_dump($_SESSION);
} else {
    echo "SESSION user has started";
    var_dump($_SESSION);
}

?>

<html lang="en-EN">
<head>
    <title>Login to Twit service</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/jumbotron-narrow.css" rel="stylesheet">

</head>
<body>
<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="index.php">Home</a></li>
                <li role="presentation" class="active"><a href="login.php">Login</a></li>
                <li role="presentation"><a href="registration.php">Registration</a></li>
            </ul>
        </nav>
    </div>

    <div class="content">

        <?php
        //show message if error in $message above
        if(isset($message)) {
            echo "<div class=\"alert alert-warning\" role=\"alert\">";
            echo $message;
            echo '</div>';
        }
        ?>

        <form action="index.php" method="POST" class="form-signin">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
            <button type="submit" name="login" class="btn btn-default">Login</button>
        </form>

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