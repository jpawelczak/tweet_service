<?php
class Message {
    private $id;
    private $senderId;
    private $receiverId;
    private $messageText;
    private $openDate;

    public function __construct()
    {

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

    public function getOpenDate()
    {
        return $this->openDate;
    }

    public function setOpenDate($openDate)
    {
        $this->openDate = $openDate;
    }




}