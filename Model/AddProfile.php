<?php

namespace Model;

require_once __DIR__ . '/dataMysql.php';
require_once __DIR__ . '/IAction.php';
require_once __DIR__ . '/Action.php';
require_once __DIR__ . '/Profile.php';

class AddProfile extends Profile
{
    public function __construct($firstName, $patronymic, $lastName, $email, $phone)
    {
        parent::__construct($firstName, $patronymic, $lastName, $email, $phone);
    }

    function run()
    {
        $mysqli = new \mysqli(host, user,password,database);

        mysqli_real_escape_string($mysqli, $this->lastName);
        mysqli_real_escape_string($mysqli, $this->firstName);
        mysqli_real_escape_string($mysqli, $this->patronymic);
        $this->email = mysqli_real_escape_string($mysqli, $this->email);
        $this->phone = mysqli_real_escape_string($mysqli, $this->phone);

        $queries = array("INSERT INTO profile VALUES(
          NULL, '$this->lastName', '$this->patronymic', '$this->firstName')",
            "INSERT INTO email VALUES(NULL, '$this->email', TRUE)",
            "INSERT INTO phone VALUES(NULL, '$this->phone', TRUE)");

        foreach ($queries as $query)
        {
            if($mysqli->query($query))
            {
                continue;
            }
            else die($mysqli->error);
        }

        $mysqli->close();

    }

}