<?php


namespace Model;

require_once __DIR__ . '/dataMysql.php';

class DeleteProfile
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function run()
    {
        $mysqli = new \mysqli(host, user,password,database);


        $queries = array("DELETE FROM profile WHERE id = '{$this->id}'",
            "DELETE FROM email WHERE profile_id = '{$this->id}'",
            "DELETE FROM phone WHERE profile_id = '{$this->id}'");

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