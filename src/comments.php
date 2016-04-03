<?php


class Comment {
    //static methods at the beginning

    static public function GetAllCommentsForTwit(mysqli $conn, $twitId) {
        $allComments = array();

        $getAllCommentsForTwit = "SELECT *
                                  FROM Comments
                                  WHERE Comments.twit_id={$twitId}
                                  ORDER BY created_time DESC;";

        $result = $conn->query($getAllCommentsForTwit);
        if($result != FALSE) {
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $comment = new Comment();
                    //$student->loadFromDB($conn, $row['id']);
                    $comment->id = $row['id'];
                    $comment->setUserId($row['user_id']);
                    $comment->setTwitId($row['twit_id']);
                    $comment->setCommentText($row['comment_text']);
                    $comment->setCreatedTimeComment($row['created_time']);

                    //dodaje do bazy kazy element jako nastepny
                    //puste [] powoduja, ze element dodawany jako kolejny wiersz
                    $allComments[] = $comment;
                }
            }
        }
        return $allComments;
    }


    private $id;
    private $userId;
    private $twitId;
    private $commentText;
    private $createdTimeComment;


    public function __construct()
    {
        //create empty construct() to be able to manipulate the object and keep DB up-to-date

        //set the ID to -1 to make sure you will not save to DB accidentally
        $this->id = -1;
        $this->setUserId(-1);
        $this->setTwitId(-1);
        $this->setCommentText('');
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setTwitId($twitId)
    {
        $this->twitId = $twitId;
    }

    public function getTwitId()
    {
        return $this->twitId;
    }

    public function setCommentText($commentText)
    {
        $this->commentText = $commentText;
    }

    public function getCommentText()
    {
        return $this->commentText;
    }

    public function setCreatedTimeComment($currentTime)
    {
        $this->createdTimeComment = $currentTime;
    }

    public function getCreatedTimeComment()
    {
        return $this->createdTimeComment;
    }

    public function saveToDB($conn) {
        //checking if we create an object before saving details in DB
        if($this->id === -1) {
            //text max 60 chars
            $insertComment = "INSERT INTO Comments(user_id, twit_id, comment_text, created_time)
                              VALUES (
                              '{$this->getUserId()}',
                              '{$this->getTwitId()}',
                              '{$this->getCommentText()}',
                              '{$this->getCreatedTimeComment()}'
                              )";
            $result = $conn->query($insertComment);
            if($result === TRUE) {
                $this->id = $conn->insert_id;
                return true;
            }
        }
        return false;
    }

    //load specific comment's details
    public function loadFromDB(mysqli $conn, $idToFind) {

        $loadFromDBQuery = "SELECT * FROM Comments WHERE twit_id={$idToFind}";
        $result = $conn->query($loadFromDBQuery);
        if($result != FALSE) {
            if($result->num_rows === 0) {
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->setUserId($row['user_id']);
                $this->setTwitId($row['twit_id']);
                $this->setCommentText($row['comment_text']);
                $this->setCreatedTimeComment($row['created_time']);
            }
        }
    }
}