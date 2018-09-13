<?php


namespace Model;

require_once __DIR__ . '/Database.php';

/**
 * Class Phone
 * @package Model
 */
class Phone
{

    private $id;
    private $number;
    private $isMain;

    /**
     * @param $id
     * @return int
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
     * @param $number
     * @return int
     */
    public function setNumber($number): int
    {
        $this->number = $number;
    }

    /**
     * @return int
     */
    public function getNumber() : int
    {
        return $this->number;
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
     * Phone constructor.
     * @param $number
     * @param $isMain
     * @param null $id
     */
    public function __construct($number, $isMain, $id = NULL)
    {
        $this->id = $id;
        $isMain == NULL ? $this->isMain = FALSE : $this->isMain = $isMain;
        $this->number = $number;
    }

}
