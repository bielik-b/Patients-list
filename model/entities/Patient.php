<?php

namespace Model;

class Patient{
    const MALE = 0;
    const FEMALE = 1;

    private $id;
    private $name;
    private $gender;
    private $date;
    private $privilege;
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
        return $this;
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
        return $this;
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

    public function setFemaleGender(){
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
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * @param mixed $privilege
     */
    public function setPrivilege($privilege)
    {
        $this->privilege = $privilege;
        return $this;
    }

    public function isPrivilege()
    {
        return  $this->privilege;
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
        return $this;
    }


}