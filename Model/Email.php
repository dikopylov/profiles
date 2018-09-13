<?php


namespace Model;

require_once __DIR__ . '/Database.php';

/**
 * Class Email
 * @package Model
 */
class Email
{

    private $id;
    private $email;
    private $isMain;

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id) : int
    {
        return $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param $email
     * @return string
     */
    public function setEmail($email) : string
    {
        return $this->email = htmlentities($email);
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param $isMain
     * @return bool
     */
    public function setIsMain($isMain) : bool
    {
        return $this->isMain = $isMain;
    }

    /**
     * @return bool
     */
    public function getIsMain() : bool
    {
        return $this->isMain;
    }

    /**
     * Email constructor.
     * @param $email
     * @param $isMain
     * @param null $id
     */
    public function __construct($email, $isMain, $id = NULL)
    {
        $this->email = $email;
        $isMain == NULL ? $this->isMain = FALSE : $this->isMain = $isMain;

        $this->id = $id;
    }
}
