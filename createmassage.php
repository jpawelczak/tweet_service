<?php
session_start();
include_once 'include.php';

//set SESSION's value
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
} else {
    $name = $_SESSION['user']['name'];
}

var_dump($_GET);
var_dump($_POST);

if (isset($_GET)) {
    $messageId = $_GET['messageId'];
    $receiverId = $_GET['receiverId'];
    $loadMessageObject = new Message();
    $loadMessageObject->loadFromDB($conn, $messageId);
    $loadMessageObject->setOpenMessage('1');
    $loadMessageObject->saveToDB($conn);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $myUserId = $_SESSION['user']['id'];
    $receiverId = $_GET['receiverId'];
    $newTextMessage = $_POST['textmessage'];
    $currentTime = date("Y-m-d h:i:s");

    if (isset($_SESSION['user']) && isset($_POST['sendmessage'])
        && strlen($newTextMessage) >= 1 && $myUserId != $receiverId) {
        $newMessageObject = new Message();
        $newMessageObject->setSenderId($myUserId);
        $newMessageObject->setReceiverId($receiverId);
        $newMessageObject->setMessageText($newTextMessage);
        $newMessageObject->setCreatedDate($currentTime);
        $newMessageObject->setOpenMessage(0);
        if ($newMessageObject->saveToDB($conn)) {
            $message = "Your message has been successfully sent! Get back to <a href='mymessages.php'>all messages</a>";
        }
    } else {
        $message = "Check if you added text to the textarea below";
    }
}


?>


<html lang="en-EN">
<head>
    <title>Reply to the message</title>
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
        <h3 class="text-muted">Welcome <?php echo $name ?>!</h3>
    </div>

    <div id="content">


        <?php
        if ($_GET['messageId']) {
            $messageId = $_GET['messageId'];
            $loadMessageObject = new Message();
            $loadMessageObject->loadFromDB($conn, $messageId);
            $loadMessageObject->setOpenMessage('1');
            $loadMessageObject->saveToDB($conn);

            echo "<h3>The massage:</h3>";
            echo "<div class='panel panel-default'>";
            echo "<div class='panel-body'><strong>Message: </strong>" . $loadMessageObject->getMessageText() . "</div>";
            $senderUserId = $loadMessageObject->getSenderId();
            $senderDetails = User::getUserProfile($senderUserId);
            echo "<div class='panel-footer'>Received on {$loadMessageObject->getCreatedDate()}</div>";
            foreach ($senderDetails as $key => $user) {
                echo "<div class='panel-footer'>" . "Sent by: <a href='userdetails.php?userId={$user->getId()}'>{$user->getName()}</a></div>";
            }
            echo "</div>";
        }
        ?>

        <h3>Send a message:</h3>
        <?php
        //show message if error in $message above
        if (isset($message)) {
            echo "<div class=\"alert alert-warning\" role=\"alert\">";
            echo $message;
            echo '</div>';
        }
        ?>

        <form action="#" method="POST" class="form-signin" id="message">
            <div class="form-group">
                <textarea rows="8" cols="60" name="textmessage" id="message" form="message"
                          placeholder="Enter your message here..."></textarea>
                <button type="submit" name="sendmessage" class="btn btn-default">Send message</button>
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