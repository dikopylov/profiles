<?php

namespace Model;

require_once __DIR__ . '/dataMysql.php';
require_once __DIR__ . '/IAction.php';
require_once __DIR__ . '/Action.php';
require_once __DIR__ . '/Profile.php';

class AddProfile extends Action implements IAction
{
    private $fullName;
    private $email;
    public $phone;

    public function __construct($fullName, $email, $phone)
    {
        $this->fullName = htmlentities($fullName);
        $this->email = htmlentities($email);
        $this->phone = htmlentities($phone);
    }

    public function setFullName($fullName) : string
    {
        return $this->fullName = htmlentities($fullName);
    }
    public function getFullName()
    {
        return $this->fullName;
    }

    public function setEmail($email)
    {
        return $this->email = htmlentities($email);
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    public function getPhone()
    {
        return $this->phone;
    }

    function run()
    {
        $mysqli = new \mysqli(host, user,password,database);

        mysqli_real_escape_string($mysqli, $lastName = explode(" ", $this->fullName)[0]);
        mysqli_real_escape_string($mysqli, $firstName = explode(" ", $this->fullName)[1]);
        mysqli_real_escape_string($mysqli, $patronymic = explode(" ", $this->fullName)[2]);
        $this->email = mysqli_real_escape_string($mysqli, $this->email);
        $this->phone = mysqli_real_escape_string($mysqli, $this->phone);

        $queryName = "INSERT INTO profile VALUES(NULL, '$firstName', '$patronymic', '$lastName')";
        $queryEmail = "INSERT INTO email VALUES(NULL, '$this->email', TRUE)";
        $queryPhone = "INSERT INTO phone VALUES(NULL, '$this->phone', TRUE)";

        if($mysqli->query($queryName) && $mysqli->query($queryEmail) && $mysqli->query($queryPhone))
        {
            header('Location: http://profil.es');
        }
        else die($mysqli->error);

        $mysqli->close();

    }

}