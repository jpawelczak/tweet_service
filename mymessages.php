<?php
session_start();
include_once 'include.php';

//set SESSION's value
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
} else {
    $name = $_SESSION['user']['name'];
    $myUserId = $_SESSION['user']['id'];
    $myAllMessages = Message::GetAllMessagesForUser($conn, $myUserId);
    $myAllSentMessages = Message::GetAllSentMessagesForUser($conn, $myUserId);
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
                <li role="presentation" class="active"><a href="mymessages.php">My Messages</a></li>
                <li role="presentation"><a href="twits.php">All Twits</a></li>
                <li role="presentation"><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">Welcome <?php echo $name ?>!</h3>
    </div>

    <div id="content">

        <h3>All received messages:</h3>
        <?php
        if(count($myAllMessages) > 0) {
            foreach ($myAllMessages as $key => $myMessage) {
                echo "<div class='panel panel-default'>";
                echo "<div class='panel-body'>";
                if($myMessage->getOpenMessage() == 0 OR $myMessage->getOpenMessage() == null) {
                    echo "<a href='createmassage.php?messageId={$myMessage->getId()}&receiverId={$myMessage->getSenderId()}'><span class=\"glyphicon glyphicon-envelope\" aria-hidden=\"true\"></span>  Message for $name</a>";
                } else {
                    echo "<a href='createmassage.php?messageId={$myMessage->getId()}&receiverId={$myMessage->getSenderId()}'><span class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span> Message for $name</a>";
                }
                echo "<br />";
                $partMessage = substr($myMessage->getMessageText(), 0, 30);
                echo "<strong>Message:</strong> {$partMessage}...";
                echo "<br />";
                echo "<br /><a href='createmassage.php?messageId={$myMessage->getId()}&receiverId={$myMessage->getSenderId()}'>Read it</a>";
                echo "</div>";
                echo "<div class='panel-footer'>Received on {$myMessage->getCreatedDate()}</div>";
                $senderUserId = $myMessage->getSenderId();
                $senderDetails = User::getUserProfile($senderUserId);
                foreach($senderDetails as $key => $senderName) {
                    echo "<div class='panel-footer'>"."Sent by: <a href='userdetails.php?userId={$senderName->getId()}'> {$senderName->getName()} </a></div>";
                }
                echo "</div>";
            }
        } else {
            echo "<div class=\"alert alert-warning\" role=\"alert\">";
            echo "User hasn't received any messages yet";
            echo '</div>';
        }
        ?>

        <h3>All sent messages by <?php echo $name;?>:</h3>
        <?php
        if(count($myAllSentMessages) > 0) {
            foreach ($myAllSentMessages as $key => $mySentMessage) {
                echo "<div class='panel panel-default'>";
                echo "<div class='panel-body'>";
                $receiverId = $mySentMessage->getReceiverId();
                $receiverDetails = User::getUserProfile($receiverId);
                echo "<a href='createmassage.php?messageId={$mySentMessage->getId()}'><span class=\"glyphicon glyphicon-share-alt\" aria-hidden=\"true\"></span>  Message sent to {$receiverDetails[0]->getName()}</a>";
                echo "<br />";
                $partMessage = substr($mySentMessage->getMessageText(), 0, 30);
                echo "<strong>Message:</strong> {$partMessage}...";
                echo "<br />";
                echo "<br /><a href='createmassage.php?messageId={$mySentMessage->getId()}'>Read it</a>";
                echo "</div>";
                echo "<div class='panel-footer'>Sent on {$mySentMessage->getCreatedDate()}, by <a href='userdetails.php?userId={$mySentMessage->getId()}'> $name </a></div>";
                echo "</div>";
            }
        } else {
            echo "<div class=\"alert alert-warning\" role=\"alert\">";
            echo "User hasn't received any messages yet";
            echo '</div>';
        }
        ?>
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