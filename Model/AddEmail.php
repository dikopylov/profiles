<?php


namespace Model;

require_once __DIR__ . '/dataMysql.php';

class AddEmail
{
    private $id;
    private $data;
    private $isMain;

    public function setId($id)
    {
        return $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setData($data)
    {
        return $this->data = htmlentities($data);
    }
    public function getData()
    {
        return $this->data;
    }

    public function setIsMain($isMain) : bool
    {
        return $this->isMain = $isMain;
    }
    public function getIsMain()
    {
        return $this->isMain;
    }


    public function __construct($id, $data, $isMain)
    {
        $this->id = $id;
        $this->data = $data;
        $this->isMain = $isMain;
    }

    public function run()
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "id" => $this->id,
            "data" => $this->data,
            "isMain" => $this->isMain == NULL ? 0 : 1
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = $mysqli->real_escape_string($clearParameter);
        }

        $queryAddEmail = "INSERT INTO email VALUES(NULL, '{$clearParameters['data']}')";

        $mail_id = 0;
        // Добавили новый имеил
        if($mysqli->query($queryAddEmail)) {
            $mail_id = $mysqli->insert_id;
        }
        else
        {
            die($mysqli->error);
        }

        $queryIsNotMainEMail = "UPDATE profile_email 
        SET is_main = 0 WHERE profile_id = '{$clearParameters['id']}'";

        $queryAddProfileEmail = "INSERT INTO profile_email VALUES(
        NULL, '{$clearParameters['id']}', '$mail_id', '{$clearParameters['isMain']}'
        )";

        if ($clearParameters['isMain'] == TRUE)
        {
            // меняем данные в ячейке с 1 на 0
            if($mysqli->query($queryIsNotMainEMail))
            {
                $mysqli->query($queryAddProfileEmail) or die($mysqli->error);
            }
        }
        else
        {
            $mysqli->query($queryAddProfileEmail) or die($mysqli->error);
        }

        $mysqli->close();
    }
}

/*
 * Добавляю в email
 * Беру ID из email
 * добавляю в profile_email вверхний id, профайл ид, проверяю основной или нет
 */