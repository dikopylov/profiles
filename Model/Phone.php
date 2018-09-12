<?php


namespace Model;

require_once __DIR__ . '/dataMysql.php';

class Phone
{
    private $id;
    private $phone_id;
    private $isMain;
    private $data;

    public function setId($id)
    {
        return $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setData($phone_id)
    {
        return $this->phone_id = htmlentities($phone_id);
    }
    public function getData()
    {
        return $this->phone_id;
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
    }

    public function add($phone, $isMain)
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "id" => $this->id,
            "phone" => $phone,
            "isMain" => $isMain == NULL ? 0 : 1
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = $mysqli->real_escape_string($clearParameter);
        }

        $query = array(
            'AddPhone' => "INSERT INTO phone VALUES(NULL, '{$clearParameters['phone']}')",
            'IsNotMainPhone' => NULL,
            'AddProfilePhone' => NULL
        );

        $phone_id = 0;
        // Добавили новый имеил
        if($mysqli->query($query['AddPhone'])) {
            $phone_id = $mysqli->insert_id;
        }
        else
        {
            die($mysqli->error);
        }

        $query['IsNotMainPhone'] = "UPDATE profile_phone 
        SET is_main = 0 WHERE profile_id = '{$clearParameters['id']}'";

        $query['AddProfilePhone'] = "INSERT INTO profile_phone VALUES(
        NULL, '{$clearParameters['id']}', '$phone_id', '{$clearParameters['isMain']}'
        )";


        if ($clearParameters['isMain'] == TRUE)
        {
            // меняем данные в ячейке с 1 на 0
            if($mysqli->query($query['IsNotMainPhone']))
            {
                $mysqli->query($query['AddProfilePhone']) or die($mysqli->error);
            }
        }
        else
        {
            $mysqli->query($query['AddProfilePhone']) or die($mysqli->error);
        }

        $mysqli->close();
    }

    public function changeMainPhone($phone_id)
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "profile_id" => $this->id,
            "phone_id" => $phone_id,
            "isMain" => 1,
        );

        $query = array(
            'IsNotMainPhone' => "UPDATE profile_phone
            SET is_main = 0 WHERE profile_id = '{$clearParameters['profile_id']}' AND is_main = '1'",
            'IsMainPhone' => NULL
        );


//         меняем данные в ячейке с 1 на 0
        $mysqli->query($query['IsNotMainPhone']) or die($mysqli->error);
        $query['isMainPhone'] = "UPDATE profile_phone
        SET is_main = 1 WHERE profile_id = '{$clearParameters['profile_id']}' AND phone_id = '{$clearParameters['phone_id']}'";

        if($mysqli->query($query['IsNotMainPhone']))
        {
            $mysqli->query($query['isMainPhone']) or die($mysqli->error);
        }

        $mysqli->close();
    }


}

/*
 * Добавляю в email
 * Беру ID из email
 * добавляю в profile_email вверхний id, профайл ид, проверяю основной или нет
 */