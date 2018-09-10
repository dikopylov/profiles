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

        //        $join = "SELECT profile.id, profile.first_name, profile.patronymic, profile.last_name
//            FROM profile
//            JOIN profile_email ON profile.id = profile_email.profile_id
//            JOIN profile_phone ON profile.id = profile_phone.profile_id";

        $query = "SELECT profile.id, profile.first_name, profile.patronymic, profile.last_name,
            profile_email.email_id, profile_phone.phone_id
            FROM ((profile
            JOIN profile_email ON profile.id = profile_email.profile_id)
            JOIN profile_phone ON profile.id = profile_phone.profile_id)";

        $queryEmail = "SELECT email.id, profile_email.profile_id, email.email, profile_email.is_main
            FROM profile_email
            JOIN email ON profile_email.email_id = email.id";

//        $queryEmailID = "SELECT email, is_main FROM email WHERE  "

        $queryFindEmail = "SELECT profile_email.email_id FROM profile_email WHERE profile_id =";

        $profiles = array();

        $resultEmail = array();
        if($result = $mysqli->query($query))
        {
            //var_dump($result);
//            $resultEmail = $mysqli->query($queryEmail)->fetch_all() or die($mysqli->error);
//            var_dump($resultEmail);
            while ($row = $result->fetch_assoc())
            {
////////////////////     ЗАПРОСЫ??
                $resultEmail = $mysqli->query($queryFindEmail . "{$row['id']}")->fetch_all() or die($mysqli->error);
                var_dump($resultEmail);
                $profile = new Profile($row['first_name'], $row['patronymic'],
                    $row['last_name'], $resultEmail, $row['number'], $row["id"]);

                $profiles[$row["id"]] = $profile;
            }
        }
        $mysqli->close();
        return $profiles;
    }

}
