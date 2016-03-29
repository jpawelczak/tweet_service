<?php

include_once 'users.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    //verify if provided details are correct (e.g. not empty)
    //username doesn;t have to be provided - we do not check that
    if (isset($_POST['register'])) {
        if (empty($email) || empty($password) || empty($confirmPassword)) {
            $message = "Please add missing details in the form below";
        } elseif ($password != $confirmPassword) {
            $message = "Passwords do not match";
        } else {
            $userObject = new User;
            if ($userObject->addUser($email, $password, $username)) {
                $message = "User successfully added. Now you can <a href='login.php'>login</a>";
            }
        }
    }
}

?>

<html lang="en-EN">
<head>
    <title>Register to Twit service</title>
    <meta charset="utf-8">

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
                <li role="presentation"><a href="login.php">Login</a></li>
                <li role="presentation" class="active"><a href="registration.php">Registration</a></li>
            </ul>
        </nav>
    </div>

    <div class="content">

        <div class="jumbotron">
            <h1>Twit-like service</h1>
            <p class="lead">Add messages and share them with your friends. It is super easy!</p>
        </div>

        <?php
        //show message if error in $message above
        if (isset($message)) {
            echo "<div class=\"alert alert-warning\" role=\"alert\">";
            echo $message;
            echo '</div>';
        };
        ?>

        <h3>Register now:</h3>

        <div id="content">
            <form action="#" method="POST" class="form-signin">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">User name</label>
                    <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="confirmpassword">Confirm password</label>
                    <input type="password" name="confirmPassword" class="form-control" id="confirmPassword"
                           placeholder="Confirm password">
                </div>
                <button type="submit" name="register" class="btn btn-default">Submit</button>
            </form>
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

</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
</body>
</html>