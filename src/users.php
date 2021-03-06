<?php
include_once 'db_connection.php';

class User
{
    //static methods always at the beginning and stating with cap letter
    static public function GetAllUsers(){
        $conn = DbConnection::getConnection();

        $getAllUsersQuery = 'SELECT id, name FROM Users';
        $usersTable = array();

        $result = $conn->query($getAllUsersQuery);

        if ($result->num_rows > 0) {

            //we take all elements from query and change to a table
            //to echo it on profile.php page
            while ($row = $result->fetch_assoc()) {
                $profile = new User();
                $profile->id = $row['id'];
                $profile->setName($row['name']);

                //adding the object to the table
                $usersTable[] = $profile;
            }

        }
        $conn->close();
        $conn = null;

        return $usersTable;
    }

    static public function getUserProfile($userid)
    {
        $conn = DbConnection::getConnection();

        $getUserQuery = 'SELECT id, name, email, description FROM Users
                        WHERE id="' . $userid . '";';
        $userProfile = array();

        $result = $conn->query($getUserQuery);

        if ($result->num_rows === 1) {

            //we take all elements from query and change to a table
            //to echo it on profile.php page
            while ($row = $result->fetch_assoc()) {
                $profile = new User();
                $profile->id = $row['id'];
                $profile->setName($row['name']);
                $profile->setEmail($row['email']);
                $profile->setDescription($row['description']);

                //adding the object to the table
                $userProfile[] = $profile;
            }

        }
        $conn->close();
        $conn = null;

        return $userProfile;
    }



    //order like in database
    private $id;
    private $name;
    private $email;
    private $password;
    private $salt;
    private $description;

    public function __construct()
    {
        //if I have an user in seesion, I take from the session details of the user
        //this way, getting messages or updating profile will not require login the user
        if (!empty($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $this->id = $user['id'];
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    //we accept users without username - we define null in the method
    public function addUser($email, $password, $username = null)
    {
        //we link methods in the class to addUser method
        //first, we generate, hash $password and link salt+password
        $this->generateSalt();
        $hashPassword = $this->hashPassword($password);
        $conn = DbConnection::getConnection();
        $insertUserQuery =
            'INSERT INTO Users (name, email, password, salt)
             VALUES ("' . $username . '", "' . $email . '", "' . $password . '", "' . $this->salt . '")';
        $result = $conn->query($insertUserQuery);
        //we check that if we recieve number error (errno) 1062 from mysqli, it means the email already exists
        if (!$result && $conn->errno == 1062) {
            return 'Email already exists';
        }

        $conn->close();
        $conn = null;

        return $result;
    }

    //we need to encrypt the password using MCRYPT_DEV_URANDOM method
    private function hashPassword($password)
    {
        //standard approach for hashing password
        $options = [
            'cost' => 11,
            'salt' => $this->salt
        ];

        //create the password with salt
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);
        return $hashedPassword;
    }

    private function generateSalt()
    {
        $this->salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
    }

    public function login($email, $password)
    {
        if (empty($email) || empty($password)) {
            return false;
        }
        $conn = DbConnection::getConnection();
        $getUserQuery = 'SELECT * FROM Users
                        WHERE email="' . $email . '";';
        $result = $conn->query($getUserQuery);
        if ($result->num_rows == 0) {
            echo 'User not found';
        }
        //we take from DB user's details (email, pswd, salt etc)
        $user = $result->fetch_assoc();
        //echo 'fetched user'.$user['name'];
        //we assign salt to $options above - hashedPassword will use salt
        /*
        $this->salt = $user['salt'];
        echo 'got salt from user'.$user['salt'];
        $hashedPassword = $this->hashPassword($password);
        if($hashedPassword != $user['password']) {
            echo 'Improper password';
        }
        */
        //we delete password from $user to set variable in the SESSION WITHOUT the password
        unset ($user['password'], $user['salt']);
        //we start session with user = $user to keep the user logged in on the website
        $_SESSION['user'] = $user;

        $conn->close();
        $conn = null;

        return true;
    }

    public function logout()
    {
        //delete data about user in session and also destroys the seesion
        //after that goes to login.php
        unset($_SESSION['user']);
        //session_destroy();
        //header("Location: login.php");
    }

    public function updateUserEmail($id, $newEmail)
    {
        //we can change email, but need to check if new email is unique
        $this->id = $id;
        $this->email = $newEmail;

        $conn = DbConnection::getConnection();
        if (strlen($newEmail) > 0) {
            $updateEmailQuery =
                'UPDATE Users
             SET email = "' . $this->email . '"
             WHERE id = "' . $this->id . '";';
        }

        $result = $conn->query($updateEmailQuery);
        //we check that if we recieve number error (errno) 1062 from mysqli, it means the email already exists
        if (!$result && $conn->errno == 1062) {
            echo 'Email already exists';
        }

        $conn->close();
        $conn = null;

        return $result;
    }

    public function updateUserName($id, $newName)
    {
        //we can change email, but need to check if new email is unique
        $this->id = $id;
        $this->name = $newName;

        $conn = DbConnection::getConnection();
        if (strlen($newName) > 0) {
            $updateNameQuery =
                'UPDATE Users
             SET name = "' . $this->name . '"
             WHERE id = "' . $this->id . '";';
        }

        $result = $conn->query($updateNameQuery);
        //we check that if we recieve number error (errno) 1062 from mysqli, it means the email already exists
        if (!$result && $conn->errno == 1062) {
            echo 'Email already exists';
        }

        $conn->close();
        $conn = null;

        return $result;
    }

    public function updateUserPassword($oldPassword, $newPassword, $confirmNewPassword)
    {
        $conn = DbConnection::getConnection();
        $getUserQuery = 'SELECT * FROM Users
                        WHERE id="' . $this->id . '";';
        $result = $conn->query($getUserQuery);
        if ($result->num_rows == 0) {
            return false;
        }
        $user = $result->fetch_assoc();
        $this->salt = $user['salt'];
        $hashedOldPassword = $this->hashPassword($oldPassword);
        if ($hashedOldPassword != $user = ['password']) {
            echo 'Old password incorrect';
        }

        if ($newPassword != $confirmNewPassword) {
            echo 'New passwords do not match';
        }
        $hashedNewPassword = $this->hashPassword($newPassword);
        $updateUserQuery = '
            UPDATE Users
            SET password="' . $hashedNewPassword . '"
            WHERE id= "' . $this->id . '";';

        $result = $conn->query($updateUserQuery);

        $conn->close();
        $conn = null;

        return $result;
    }

    public function deleteUser($id, $delprofilepswd)
    {
        $this->id = $id;
        $this->password = $delprofilepswd;

        $conn = DbConnection::getConnection();

        //get user's details to match password before deleting the profile
        $getUserQuery = 'SELECT * FROM Users
                        WHERE id="' . $this->id . '";';

        $result = $conn->query($getUserQuery);

        if ($result->num_rows == 0) {
            echo 'User not found';
        }
        //we take from DB user's details (email, pswd, salt etc)
        $user = $result->fetch_assoc();

        if ($user['password'] == $this->password) {
            $deleteUser = '
                    DELETE FROM Users
                    WHERE id ="' . $this->id . '";';
        }

        $deletedUser = $conn->query($deleteUser);

        $conn->close();
        $conn = null;

        unset($_SESSION['user']);

        return $deletedUser;
    }

    public function getAllMyTwits()
    {

    }

    public function getAllMessages()
    {

    }

    public function getAllFriends()
    {

    }
}

?>