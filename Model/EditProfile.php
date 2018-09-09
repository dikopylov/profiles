<?php

namespace Model;

require_once __DIR__ . '/dataMysql.php';
require_once __DIR__ . '/Profile.php';

// Изменить
class EditProfile extends Profile
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function run()
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