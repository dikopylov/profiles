<?php


namespace Model;

require_once __DIR__ . '/dataMysql.php';

class AddContact
{
    private $id;
    private $data;

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

    public function __construct($id, $data)
    {
        $this->id = $id;
        $this->data = $data;
    }

    public function run()
    {
        $mysqli = new \mysqli(host, user,password,database);

        $clearParameters = array(
            "id" => $this->id,
            "data" => $this->data
        );

        foreach ($clearParameters as $key => $clearParameter)
        {
            $clearParameters[$key] = $mysqli->real_escape_string($clearParameter);
        }

        var_dump(strpos ($clearParameters["data"], '@') === TRUE);
        var_dump($clearParameters["data"]);
        if (strpos ($clearParameters["data"], '@') == TRUE)
        {
            $query = "INSERT INTO email VALUES('{$clearParameters['id']}', '{$clearParameters['data']}', FALSE)";
        }
        else
        {
            $query = "INSERT INTO phone VALUES('{$clearParameters['id']}', '{$clearParameters['data']}', FALSE)";
        }


            $mysqli->query($query) or die($mysqli->error);

        $mysqli->close();
    }
}