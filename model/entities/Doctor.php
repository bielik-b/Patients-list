<?php

namespace Model;

class Doctor{
    private $id;
    private $name;
    private $specialization;
    private $expirience;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSpecialization()
    {
        return $this->specialization;
    }

    /**
     * @param mixed $specialization
     */
    public function setSpecialization($specialization)
    {
        $this->specialization = $specialization;
    }

    /**
     * @return mixed
     */
    public function getExpirience()
    {
        return $this->expirience;
    }

    /**
     * @param mixed $expirience
     */
    public function setExpirience($expirience)
    {
        $this->expirience = $expirience;
    }
}