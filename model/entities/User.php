<?php

namespace Model;

class User{
    private $username;
    private $password;
    private $rights;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function checkPassword ($password){
        if($this->password == $password){
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getRights()
    {
        return $this->rights;
    }

    public function getRight($id){
        return $this->rights[$id];
    }

    /**
     * @param mixed $rights
     */
    public function setRights($rights)
    {
        $this->rights = $rights;
        return $this;
    }

    public function checkRight($object, $right)
    {
        if($object == 'doctor' && $right == 'view' && $this->getRight(0)) {
            return true;
        }
        if($object == 'doctor' && $right == 'create' && $this->getRight(1)) {
            return true;
        }
        if($object == 'doctor' && $right == 'edit' && $this->getRight(2)) {
            return true;
        }
        if($object == 'doctor' && $right == 'delete' && $this->getRight(3)) {
            return true;
        }
        if($object == 'patient' && $right == 'view' && $this->getRight(4)) {
            return true;
        }
        if($object == 'patient' && $right == 'create' && $this->getRight(5)) {
            return true;
        }
        if($object == 'patient' && $right == 'edit' && $this->getRight(6)) {
            return true;
        }
        if($object == 'patient' && $right == 'delete' && $this->getRight(7)) {
            return true;
        }
        if($object == 'user' && $right == 'admin' && $this->getRight(8)) {
            return true;
        }
        return false;
    }
}