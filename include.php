<?php
include_once './src/db_connection.php';
include_once './src/users.php';
include_once './src/tweet.php';
include_once './src/comments.php';
include_once './src/messages.php';

$conn = DbConnection::getConnection();