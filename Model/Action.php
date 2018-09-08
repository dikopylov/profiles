<?php

namespace Model;

require_once __DIR__ . '/dataMysql.php';


abstract class Action
{

    public function protection($var)
    {
        $mysqli = new \mysqli(host, user,password,database);
        $var = (htmlentities(mysqli_real_escape_string($mysqli, $var)));
        $mysqli->close();
        return $var;
    }


}