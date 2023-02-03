<?php

namespace Model;

class Patient{
    const MALE = 0;
    const FEMALE = 1;

    private $id;
    private $name;
    private $gender;
    private $date;
    private $priviege;
    private $doctorId;

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

    public function isGenderMale (){
        return  ($this->gender==self::MALE);
    }

    public function isGenderFemale (){
        return  !($this->isGenderMale());
    }

    public function setMaleGender (){
        return $this->gender = SELF::MALE;
    }

    public function setFemaleGender (){
        return $this->gender = SELF::FEMALE;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getPriviege()
    {
        return $this->priviege;
    }

    /**
     * @param mixed $priviege
     */
    public function setPriviege($priviege)
    {
        $this->priviege = $priviege;
    }

    /**
     * @return mixed
     */
    public function getDoctorId()
    {
        return $this->doctorId;
    }

    /**
     * @param mixed $doctorId
     */
    public function setDoctorId($doctorId)
    {
        $this->doctorId = $doctorId;
    }


}