<?php

namespace Model;

abstract class Data{
    const FILE = 0;

    private $error;
    private $user;

    public function setCurrentUser($userName)
    {
        $this->user = $this->readUser($userName);
    }

    public function checkRight($object, $right)
    {
        return $this->user->checkRight($object, $right);
    }

    public function readPatients($doctorId)
    {
        if($this->user->checkRight('patient', 'view')){
            $this->error="";
            return $this->getPatients($doctorId);
        } else{
            $this->error = "You have no permissions to view patients";
            return false;
        }
    }
    protected abstract function getPatients($doctorId);

    public function readPatient($doctorId, $id)
    {
        if($this->user->checkRight('patient', 'view')){
            $this->error="";
            return $this->getPatient($doctorId, $id);
        } else{
            $this->error = "You have no permissions to view patient";
            return false;
        }
    }
    protected abstract function getPatient($doctorId, $id);

    public function readDoctors()
    {
        if($this->checkRight('doctor', 'view')){
            $this->error = "";
            return $this->getDoctors();
        }else{
            $this->error = "You have no permission to view doctors";
            return false;
        }
    }
    protected abstract function getDoctors();

    public function readDoctor($id)
    {
        if($this->checkRight('doctor', 'view')){
            $this->error = "";
            return $this->getDoctor($id);
        }else{
            $this->error = "You have no permission to view doctor";
            return false;
        }
    }
    protected abstract function getDoctor($id);

    public function readUsers()
    {
        if ($this->checkRight('user', 'admin')){
            $this->error="";
            return $this->getUsers();
        }else{
            $this->error = "You have no permissions to administrate users";
            return false;
        }
    }

    protected abstract function getUsers ();

    public function readUser($id)
    {
        $this->error="";
        return $this->getUser($id);
    }
    protected abstract function getUser($id);

    public function writePatient(Patient $patient)
    {
        if ($this->checkRight('patient', 'edit')){
            $this->error="";
            $this->setPatient($patient);
            return true;
        }else{
            $this->error="You have no permissions to edit patients";
            return false;
        }
    }
    protected abstract function setPatient(Patient $patient);

    public function writeDoctor(Doctor $doctor)
    {
        if ($this->checkRight('doctor', 'edit')){
            $this->error="";
            $this->setDoctor($doctor);
            return  true;
        }else{
            $this->error= "You have no permissions to edit doctors";
            return false;
        }
    }
    protected abstract function setDoctor(Doctor $doctor);

    public function writeUser(User $user)
    {
        if ($this->checkRight('user', 'admin')){
            $this->error="";
            $this->setUser($user);
            return true;
        }else{
            $this->error= "You have no permissions to administrate users";
            return false;
        }
    }
    protected abstract function setUser(User $user);

    public function removePatient(Patient $patient)
    {
        if ($this->checkRight('patient', 'delete')){
            $this->error="";
            $this->delPatient($patient);
            return true;
        }else{
            $this->error= "You have no permissions to delete patients";
            return false;
        }
    }
    protected abstract function delPatient(Patient $patient);

    public function addPatient(Patient $patient)
    {
        if($this->checkRight('patient', 'create')){
            $this->error="";
            $this->insPatient($patient);
            return true;
        }else{
            $this->error = "You have no permissions to create patients";
            return false;
        }
    }
    protected abstract function insPatient(Patient $patient);

    public function removeDoctor($doctorId)
    {
        if($this->checkRight('doctor', 'delete')){
            $this->error="";
            $this->delDoctor($doctorId);
            return true;
        }else{
            $this->error= "You have no permissions to delete doctors";
            return false;
        }
    }
    protected abstract function delDoctor($doctorId);

    public function addDoctor()
    {
        if($this->checkRight('doctor', 'create')){
            $this->error="";
            $this->insDoctor();
            return true;
        }else{
            $this->error = "You have no permissions to create doctors";
            return false;
        }
    }
    protected abstract function insDoctor();

    public function getError()
    {
        if($this->error){
            return $this->error;
        }
        return false;
    }

    public static function makeModel($type)
    {
        if($type == self::FILE){
            return new FileData();
        }
        return new FileData();
    }

}