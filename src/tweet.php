<?php
include_once 'users.php';
include_once 'db_connection.php';

Class Tweet {

    //static methods at the top
    static function getTwitDetails($twitId)
    {
        $conn = DbConnection::getConnection();

        $getTwitDetails = "SELECT * FROM Twits WHERE twit_id={$twitId};";
        $twitDetails = array();

        $result = $conn->query($getTwitDetails);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $twit = new Tweet();
                $twit->twitId = $row['twit_id'];
                $twit->setUserId($row['user_id']);
                $twit->setTwitText($row['twit_text']);
                $twit->setCreatedTime($row['created_time']);

                //dodaje do bazy kazy element jako nastepny
                //puste [] powoduja, ze element dodawany jako kolejny wiersz
                $twitDetails[] = $twit;
            }
        }


        $conn->close();
        $conn = null;

        return $twitDetails;
    }

    static public function getAllMyTwits($userId)
    {

        $conn = DbConnection::getConnection();

        $getAllTwits = "SELECT * FROM Twits WHERE user_id={$userId} ORDER BY created_time DESC;";
        $allMyTwits = array();

        $result = $conn->query($getAllTwits);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $twit = new Tweet();
                $twit->twitId = $row['twit_id'];
                $twit->setUserId($row['user_id']);
                $twit->setTwitText($row['twit_text']);
                $twit->setCreatedTime($row['created_time']);

                //dodaje do bazy kazy element jako nastepny
                //puste [] powoduja, ze element dodawany jako kolejny wiersz
                $allMyTwits[] = $twit;
            }


        }
        $conn->close();
        $conn = null;

        return $allMyTwits;
    }

    static public function getAllTwits()
    {

        $conn = DbConnection::getConnection();

        $getAllTwits = "SELECT * FROM Twits ORDER BY created_time DESC;";
        $allTwits = array();

        $result = $conn->query($getAllTwits);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $twit = new Tweet();
                $twit->twitId = $row['twit_id'];
                $twit->setUserId($row['user_id']);
                $twit->setTwitText($row['twit_text']);
                $twit->setCreatedTime($row['created_time']);

                //dodaje do bazy kazy element jako nastepny
                //puste [] powoduja, ze element dodawany jako kolejny wiersz
                $allTwits[] = $twit;
            }


        }
        $conn->close();
        $conn = null;

        return $allTwits;
    }

    private $twitId;
    private $userId;
    private $twitText;
    private $created_time;

    public function __construct()
    {
        //if I have an user in seesion, I take from the session details of the user
        //this way, getting messages or updating profile will not require login the user
        if (!empty($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $this->setUserId($user['id']);
        }
    }

    public function getTwitId()
    {
        return $this->twitId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setTwitText($twitText)
    {
        $this->twitText = $twitText;
    }

    public function getTwitText()
    {
        return $this->twitText;
    }

    public function setCreatedTime($created_time)
    {
        $this->created_time = $created_time;
    }

    public function getCreatedTime()
    {
        return $this->created_time;
    }


    public function addTwit()
    {
        $conn = DbConnection::getConnection();

        $currentTime = date("Y-m-d h:i:s");

        $insertTwitQuery =
            "INSERT INTO Twits (user_id, twit_text, created_time)
             VALUES ({$this->getUserId()}, '{$this->getTwitText()}', '{$currentTime}')";

        $result = $conn->query($insertTwitQuery);

        $conn->close();
        $conn = null;

        return $result;
    }

}