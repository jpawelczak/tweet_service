<?php
class Message {

    //static methods at the beginning

    static public function GetAllMessagesForUser(mysqli $conn, $receiverId) {
        $allMyMessages = array();

        $getAllMessagesForUser = "SELECT * FROM Messages
                                  WHERE receiver_id={$receiverId}";

        $result = $conn->query($getAllMessagesForUser);
        if($result != FALSE) {
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $myMessage = new Message();
                    $myMessage->id = $row['id'];
                    $myMessage->setSenderId($row['sender_id']);
                    $myMessage->setReceiverId($row['receiver_id']);
                    $myMessage->setMessageText($row['message_text']);
                    $myMessage->setCreatedDate($row['created_date']);
                    $myMessage->setOpenMessage($row['open_message']);
                    $allMyMessages[] = $myMessage;
                }
            }
        }
        return $allMyMessages;
    }

    //static methods at the beginning

    static public function GetAllSentMessagesForUser(mysqli $conn, $senderId) {
        $allMySentMessages = array();

        $getAllSentMessagesForUser = "SELECT *
                                      FROM  `Messages`
                                      LEFT JOIN Users ON Messages.sender_id = Users.id
                                      WHERE sender_id ={$senderId}";

        $result = $conn->query($getAllSentMessagesForUser);
        if($result != FALSE) {
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $mySentMessage = new Message();
                    $mySentMessage->id = $row['id'];
                    $mySentMessage->setSenderId($row['sender_id']);
                    $mySentMessage->setReceiverId($row['receiver_id']);
                    $mySentMessage->setMessageText($row['message_text']);
                    $mySentMessage->setCreatedDate($row['created_date']);
                    $mySentMessage->setOpenMessage($row['open_message']);
                    $allMySentMessages[] = $mySentMessage;
                }
            }
        }
        return $allMySentMessages;
    }


    private $id;
    private $senderId;
    private $receiverId;
    private $messageText;
    private $createdDate;
    private $openMessage;

    public function __construct()
    {
        //create empty construct() to be able to manipulate the object and keep DB up-to-date
        //set the ID to -1 to make sure you will not save to DB accidentally
        $this->id = -1;
        $this->setSenderId(-1);
        $this->setReceiverId(-1);
        $this->setMessageText('');
        $this->setCreatedDate('');
        $this->setOpenMessage(-1);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSenderId()
    {
        return $this->senderId;
    }

    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    public function getReceiverId()
    {
        return $this->receiverId;
    }

    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;
    }

    public function getMessageText()
    {
        return $this->messageText;
    }

    public function setMessageText($messageText)
    {
        $this->messageText = $messageText;
    }

    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    public function getOpenMessage()
    {
        return $this->openMessage;
    }

    public function setOpenMessage($openMessage)
    {
        $this->openMessage = $openMessage;
    }


    public function saveToDB(mysqli $conn)
    {
        //by checking if id = -1 we are checking if we are creating an object before saving details in DB
        if($this->id === -1) {
            $insertMessage = "INSERT INTO Messages(sender_id, receiver_id, message_text, created_date, open_message)
                              VALUES (
                              '{$this->getSenderId()}',
                              '{$this->getReceiverId()}',
                              '{$this->getMessageText()}',
                              '{$this->getCreatedDate()}',
                              '{$this->getOpenMessage()}'
                              );";
            $result = $conn->query($insertMessage);
            if($result === TRUE) {
                $this->id = $conn->insert_id;
                return true;
            }
        } else {
            $updateMessage = "UPDATE Messages SET
                             sender_id='{$this->getSenderId()}',
                             receiver_id='{$this->getReceiverId()}',
                             message_text='{$this->getMessageText()}',
                             created_date='{$this->getCreatedDate()}',
                             open_message='{$this->getOpenMessage()}'
                              WHERE id='{$this->getId()}'
                              ;";
            $result = $conn->query($updateMessage);
            if($result != FALSE) {
                return true;
            }
        }
        return false;
    }

    public function loadFromDB(mysqli $conn, $massageId)
    {
        $loadFromDBQuery = "SELECT * FROM Messages WHERE id={$massageId}";
        $result = $conn->query($loadFromDBQuery);
        if($result != FALSE) {
            if($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->setSenderId($row['sender_id']);
                $this->setReceiverId($row['receiver_id']);
                $this->setMessageText($row['message_text']);
                $this->setCreatedDate($row['created_date']);
                $this->setOpenMessage($row['open_message']);
            }
        }

    }
}