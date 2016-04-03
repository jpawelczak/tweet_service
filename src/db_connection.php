<?php
class DbConnection
{
    //database login details
    private static $serverName = 'localhost';
    private static $userName = 'twit';
    private static $password = 'twit';
    private static $baseName = 'twitter_like';

    public static function getConnection()
    {
        //connect to the DB
        //self:: as we have static function
        $conn = new mysqli(self::$serverName, self::$userName, self::$password, self::$baseName);

        //test connection with the DB
        if ($conn->connect_error) {
            die("Error with connection: " . $conn->connect_error);
        } else {
            return $conn;
        }
    }
}

?>

