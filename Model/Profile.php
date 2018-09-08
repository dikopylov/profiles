<?php

namespace Model;

class Profile
{
    private $firstName;
    private $patronymic;
    private $lastName;
    private $email;
    private $phone;
    private $id;

    public function setFirstName($firstName) : string
    {
        return $this->firstName = $firstName;
    }
    public function getFirstName() : string
    {
        return $this->firstName;
    }

    public function setPatronymic($patronymic) : string
    {
        return $this->patronymic = $patronymic;
    }
    public function getPatronymic() : string
    {
        return $this->patronymic;
    }

    public function setLastName($lastName) : string
    {
        return $this->lastName = $lastName;
    }
    public function getLastName() : string
    {
        return $this->lastName;
    }

    public function setEmail($email) : string
    {
        return $this->email = $email;
    }
    public function getEmail() : string
    {
        return $this->email;
    }

    public function setPhone($phone) : int
    {
        return $this->phone = $phone;
    }
    public function getPhone()
    {
        return $this->phone;
    }

    public function setId($id)
    {
        return $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }

    function __construct($id, $firstName, $patronymic, $lastName, $email, $phone)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->patronymic = $patronymic;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function show()
    {
        printf("%s %s  %s  %s %d", $this->getFirstName(), $this->getPatronymic(),
            $this->getLastName(), $this->getEmail(), $this->getPhone());
    }



}