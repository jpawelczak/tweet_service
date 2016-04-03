<?php
session_start();
include_once 'include.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_SESSION['user']['id'];
    $newEmail = $_POST['newemail'];
    $newUserName = $_POST['newusername'];
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];
    $delprofilepswd = $_POST['delprofilepswd'];

    if (isset($_POST['emailchange'])) {
        $userObject = new User;
        if ($userObject->updateUserEmail($userid, $newEmail)) {
            $message = "profile updated with new email";
        }
    } else {
        $message = "current and new email is the same";
    }

    if (isset($_POST['namechange'])) {
        if ($_SESSION['user']['name'] != $newUserName) {
            $userObject = new User;
            if ($userObject->updateUserName($userid, $newUserName)) {
                $message = "profile updated with new name";
            }
        } else {
            $message = "current and new name is the same";
        }
    }

    if (isset($_POST['resetpassword'])) {
        if ($_SESSION['user']) {
            $userObject = new User;
            if ($userObject->updateUserPassword($oldpassword, $newpassword, $confirmpassword)) {
                $message = "your password has been updated";
            }
        } else {
            $message = "current and new name is the same";
        }
    }

    if (isset($_POST['deleteprofile'])) {
        if ($_SESSION['user']) {
            $userObject = new User();
            if ($userObject->deleteUser($userid, $delprofilepswd)) {
                $message = "your profile has been deleted - log out";
            }
        } else {
            $message = "current and new name is the same";
        }
    }
}

//set SESSION's value
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
} else {
    $name = $_SESSION['user']['name'];
}

if (isset($_SESSION['user']['name'])) {
    $useridSession = $_SESSION['user']['id'];
    $userDetails = User::getUserProfile($useridSession);
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
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/jumbotron-narrow.css" rel="stylesheet">


</head>
<body>

<div class="container">
    <div class="header clearfix">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="index.php">My Twits</a></li>
                <li role="presentation" class="active"><a href="profile.php">My Profile</a></li>
                <li role="presentation"><a href="mymessages.php">My Messages</a></li>
                <li role="presentation"><a href="twits.php">All Twits</a></li>
                <li role="presentation"><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">Welcome <?php echo $name ?>!</h3>
    </div>

    <div id="content">
        <h3>Your current details</h3>
            <?php

            foreach($userDetails as $key => $user){
                echo "<div class='panel panel-default'>";
                echo "<div class='panel-body'>Full name: {$user->getName()}</div>";
                echo "<div class='panel-footer'>Email: {$user->getEmail()}</div>";
                echo "<div class='panel-footer'>Description: {$user->getDescription()}</div>";
                echo "</div>";
            }

            ?>

        <h3>Update your details</h3>
        <?php
        //show message if error in $message above
        if (isset($message)) {
            echo "<div class=\"alert alert-warning\" role=\"alert\">";
            echo $message;
            echo '</div>';
        }
        ?>

        <form action="#" method="POST" class="form-signin">
            <div class="form-group">
                <label for="changeEmail">Change your email</label>
                <input type="text" name="newemail" class="form-control" id="changeEmail" placeholder="New Email">
                <button type="submit" name="emailchange" class="btn btn-default">Update email</button>
            </div>
            <div class="form-group">
                <label for="changeUserName">Change your User name</label>
                <input type="text" name="newusername" class="form-control" id="changeUserName"
                       placeholder="New user name">
                <button type="submit" name="namechange" class="btn btn-default">Update user name</button>
            </div>
        </form>

        <h3>Update your password</h3>

        <div id="content">
            <form action="#" method="POST" class="form-signin">
                <div class="form-group">
                    <label for="oldpassword">Password</label>
                    <input type="password" name="oldpassword" class="form-control" id="oldpassword"
                           placeholder="Your current password">
                </div>
                <div class="form-group">
                    <label for="newpassword">New password</label>
                    <input type="password" name="newpassword" class="form-control" id="newpassword"
                           placeholder="New password">
                </div>
                <div class="form-group">
                    <label for="confirmpassword">Confirm password</label>
                    <input type="password" name="confirmpassword" class="form-control" id="confirmPassword"
                           placeholder="Confirm password">
                </div>
                <button type="submit" name="resetpassword" class="btn btn-default">Change password</button>
            </form>
        </div>

        <h3>Delete your profile</h3>

        <div id="content">
            <form action="#" method="POST" class="form-signin">
                <div class="form-group">
                    <label for="delprofpswd">Confirm password</label>
                    <input type="password" name="delprofilepswd" class="form-control" id="delprofpswd"
                           placeholder="Your password">
                    <button type="submit" name="deleteprofile" class="btn btn-default">Delete profile</button>
                </div>
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

</div> <!-- /container -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>

</body>
</html>



