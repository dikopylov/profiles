<?php

namespace Model;

require_once __DIR__ . '/IAction.php';
require_once __DIR__ . '/Profile.php';

class UnloadingProfiles implements IAction
{
    // Выгрузка профайлов из БД в объекты
    public function run()
    {
        $mysqli = new \mysqli(host, user,password,database);

        $query = "SELECT * FROM profile 
                  JOIN phone ON profile.id = phone.id 
                  JOIN email ON profile.id = email.id";

        $profiles = array();

        if($result = $mysqli->query($query))
        {
            while ($row = $result->fetch_assoc())
            {
//                echo $row["id"] . ' ' . $row['first_name'] . ' ' . $row['patronymic'] . ' ' .
//                    $row['last_name'] . ' ' . $row['number'] . ' ' . $row['email'];

                $profile = new Profile($row["id"], $row['first_name'], $row['patronymic'],
                    $row['last_name'], $row['email'], $row['number']);

                array_push($profiles, $profile);
//                echo '<br>';
            }
        }
        $mysqli->close();
        return $profiles;
    }

}

