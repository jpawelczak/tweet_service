<?php
session_start();
include_once 'include.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_SESSION['user']['id'];
    $newTextTwit = $_POST['texttwit'];

    if (isset($_SESSION['user']) && isset($_POST['twit']) && strlen($_POST['texttwit']) <=140 && strlen($_POST['texttwit']) >=1 ) {
        $twitObject = new Tweet();
        $twitObject->setTwitText();
        if ($twitObject->addTwit()) {
            $message = "Your Twit successfully added!";
        }
    } else {
        $message = "Check if you added text to the textarea below";
    }
}

//set SESSION's value
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
} else {
    echo "SESSION 'user' has started";
    $name = $_SESSION['user']['name'];
}

?>


<html lang="en-EN">
<head>
    <title>Add twits</title>
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
                <li role="presentation"><a href="index.php">Home</a></li>
                <li role="presentation"><a href="profile.php">Profile</a></li>
                <li role="presentation" class="active"><a href="alltwits.php">Tweets</a></li>
                <li role="presentation"><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">Twits of <?php echo $name ?></h3>
    </div>

    <div id="content">

        <h3>Add new twits</h3>
        <?php
        //show message if error in $message above
        if (isset($message)) {
            echo "<div class=\"alert alert-warning\" role=\"alert\">";
            echo $message;
            echo '</div>';
        }
        ?>

        <form action="alltwits.php" method="POST" class="form-signin" id="twitform">
            <div class="form-group">
                <label for="twitform">Add text below (140 chars maximum)</label>
                <textarea rows="4" cols="40" name="texttwit" id="twitform" form="twitform" maxlength="140">Enter your twit here...</textarea>
                <button type="submit" name="twit" class="btn btn-default">Send twit</button>
            </div>
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

</div> <!-- /container -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>

</body>
</html>