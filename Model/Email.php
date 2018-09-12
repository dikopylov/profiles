<?php


namespace Model;

require_once __DIR__ . '/dataMysql.php';

class Email
{
    private $id;
//    private $email;
//    private $isMain;

    public function setId($id)
    {
        return $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setEmail($email)
    {
        return $this->email = htmlentities($email);
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setIsMain($isMain) : bool
    {
        return $this->isMain = $isMain;
    }
    public function getIsMain()
    {
        return $this->isMain;
    }


    public function __construct($id)
    {
        $this->id = $id;
        ;
    }

    public function add($email, $isMain)
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "id" => $this->id,
            "email" => $email,
            "isMain" => $isMain == NULL ? $isMain = 0 :  $isMain = 1
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = $mysqli->real_escape_string($clearParameter);
        }

        $query = array(
            'AddEmail' => "INSERT INTO email VALUES(NULL, '{$clearParameters['email']}')",
            'IsNotMainEMail' => NULL,
            'AddProfileEmail' => NULL
        );

        $mail_id = 0;
        // Добавили новый имеил
        if($mysqli->query($query['AddEmail'])) {
            $mail_id = $mysqli->insert_id;
        }
        else
        {
            die($mysqli->error);
        }

        $query['IsNotMainEMail'] = "UPDATE profile_email 
        SET is_main = 0 WHERE profile_id = '{$clearParameters['id']}' AND is_main = 1";

        $query['AddProfileEmail'] = "INSERT INTO profile_email VALUES(
        NULL, '{$clearParameters['id']}', '$mail_id', '{$clearParameters['isMain']}'
        )";

        if ($clearParameters['isMain'] == TRUE)
        {
            // меняем данные в ячейке с 1 на 0
            if($mysqli->query($query['IsNotMainEMail']))
            {
                $mysqli->query($query['AddProfileEmail']) or die($mysqli->error);
            }
        }
        else
        {
            $mysqli->query($query['AddProfileEmail']) or die($mysqli->error);
        }

        $mysqli->close();
    }

    public function changeMainEmail($email_id)
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "profile_id" => $this->id,
            "email_id" => $email_id,
            "isMain" => 1,
        );

        $query = array(
            'IsNotMainEMail' => "UPDATE profile_email
            SET is_main = 0 WHERE profile_id = '{$clearParameters['profile_id']}' AND is_main = '1'",
            'IsMainEMail' => NULL
        );


//         меняем данные в ячейке с 1 на 0
        $mysqli->query($query['IsNotMainEMail']) or die($mysqli->error);
        $query['isMainEMail'] = "UPDATE profile_email
        SET is_main = 1 WHERE profile_id = '{$clearParameters['profile_id']}' AND email_id = '{$clearParameters['email_id']}'";

        if($mysqli->query($query['IsNotMainEMail']))
        {
            $mysqli->query($query['isMainEMail']) or die($mysqli->error);
        }

        $mysqli->close();
    }

}

/*
 * Добавляю в email
 * Беру ID из email
 * добавляю в profile_email вверхний id, профайл ид, проверяю основной или нет
 */