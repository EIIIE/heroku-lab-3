<?php

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$connection = new PDO('pgsql:host=ec2-54-75-246-50.eu-west-1.compute.amazonaws.com dbname=d12a1pg72pshjv user=vemfvefnvlsszu password=22ab652a2dcebd4b67c980b0a7477189463e1b05f688de5aa39b723604624e33');

if (!$connection) {
    echo "no connect ";
} else {
echo "connect";
//вход под существующем пользователем
    if (isset($_POST['username']) && isset($_POST['pass'])) {
        echo "вход под существующем пользователем ";
        $responceApp = new User_Data($_POST['username'], $_POST['pass'], $connection);
        echo $responceApp->getUserData();

    }
    else {
    echo "не вход под существующем пользователем ";}


//создание нового пользователя
    if (isset($_POST['new-username']) && isset($_POST['new-pass'])) {
        echo "создание нового пользователя ";
        $responceApp = new User_Data($_POST['new-username'], $_POST['new-pass'], $connection);
        echo $responceApp->setNewUser();
    }
    else {
    echo "не оздание нового пользователя ";
    }
}

// класс для обработки полученных данных
class User_Data
{

    private $username;
    private $password;
    private $connection;
    private $logintime;


    function User_Data($username, $password, $connection)
    {

        $this->password = md5($password . "salt=)");
        $this->username = $username;
        $this->connection = $connection;
        $this->logintime = date('U');

    }
function getUserData()
    {

        if ($this->userIsset()) {

            $query = $this->connection->query("UPDATE users SET logintime='$this->logintime' WHERE username='$this->username' AND password='$this->password' ");
            $query = $this->connection->query("SELECT id, username, password, logintime FROM users ORDER BY logintime DESC ");
            $rows = array();

            foreach ($query as $r) {
                $rows[] = $r;
            }

            return json_encode($rows);

        } else {
            $wrong = "wrong password or username";
            return $wrong;
        }

    }

    function userIsset()
    {

        $search_user = $this->connection->query("SELECT id FROM users WHERE username='$this->username' AND password='$this->password'");
        $user_valid = $search_user->fetchColumn();
        if ($user_valid > 0)
            return true;
        else
            return false;

    }

    function loginIsset()
    {

        $search_user = $this->connection->query("SELECT id, username, password, logintime FROM users WHERE username='$this->username'");
        $user_valid = $search_user->fetchColumn();
        if ($user_valid > 0)
            return true;
        else
            return false;

    }

    function setNewUser()
    {

        if (!$this->loginIsset()) {
            $add_user = $this->connection->query("INSERT INTO users (username, password, logintime) VALUES ('$this->username', '$this->password', '$this->logintime');");
            return $this->getUserData();
        } else {
$userExists = "user with this login already exists";
            return $userExists;
        }
    }

}


?>
