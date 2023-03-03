<?php

namespace Model;

class FileData extends Data
{
    const DATA_PATH = __DIR__ . '/../data/';
    const PATIENT_FILE_TEMPLATE = '/^patient-\d\d.txt\z/';
    const DOCTOR_FILE_TEMPLATE = '/^doctor-\d\d\z/';

    protected function getPatients($doctorId)
    {
        $Patients = array();
        $conts = scandir(self::DATA_PATH . $doctorId);
        foreach ($conts as $node){
            if (preg_match(self::PATIENT_FILE_TEMPLATE, $node)){
                $Patients[] = $this->getPatient($doctorId,$node);
            }
        }
        return $Patients;
    }
    protected function getPatient($doctorId, $id)
    {
        $f = fopen(self::DATA_PATH . $doctorId . "/" . $id, "r");
        $rowStr = fgets($f);
        $rowArr = explode(";", $rowStr);
        $Patient = (new Patient())
            -> setId($id)
            -> setName($rowArr[0])
            -> setDate(new \DateTime($rowArr[2]))
            -> setPrivilege($rowArr[3]);
        if($rowArr[1] == 'чол'){
            $Patient -> setMaleGender();
        }else{
            $Patient -> setFemaleGender();
        }
        fclose($f);
        return $Patient;
    }

    protected function getDoctors()
    {
        $doctors = array();
        $conts = scandir(self::DATA_PATH);
        foreach ($conts as $node){
            if(preg_match(self::DOCTOR_FILE_TEMPLATE, $node)){
                $doctors[] = $this -> getDoctor($node);
            }
        }
        return $doctors;
    }

    protected function getDoctor($id)
    {
       $f = fopen(self::DATA_PATH . $id . "/doctor.txt", "r");
       $drStr = fgets($f);
       $drArr = explode(";", $drStr);
       fclose($f);

       $doctor = (new Doctor());
       $doctor->setId($id);
       $doctor->setName($drArr[0]);
       $doctor->setSpecialization($drArr[1]);
       $doctor->setExpirience($drArr[2]);

       return $doctor;
    }

    protected function getUsers()
    {
        $users = array();
        $f = fopen(self::DATA_PATH . "users.txt", "r");
        while(!feof($f)){
            $rowStr = fgets($f);
            $rowArr = explode(";", $rowStr);
            if(count($rowArr)==3){
                $user = (new User())
                    ->setUsername($rowArr[0])
                    ->setPassword($rowArr[1])
                    ->setRights(substr($rowArr[2],0,9));
                $users[] = $user;
            }
        }
        fclose($f);
        return $users;
    }

    protected function getUser($id)
    {
        $users = $this->getUsers();
        foreach ($users as $user){
            if($user->getUserName() == $id){
                return $user;
            }
        }
        return false;
    }

    protected function setPatient(Patient $patient)
    {
        $f = fopen(self::DATA_PATH . $patient->getDoctorId() . "/" . $patient->getId(), "w");
        $privilege=0;
        if($patient->isPrivilege()){
            $privilege = 1;
        }
        $gender = 'жін';
        if($patient->isGenderMale()){
            $gender = 'чол';
        }
        $drArr = array($patient->getName(),$gender,$patient->getDate()->format('Y-M-D'), $privilege,);
        $drStr = implode(";", $drArr);
        fwrite($f, $drStr);
        fclose($f);
    }

    protected function setDoctor(Doctor $doctor)
    {
        $f = fopen(self::DATA_PATH . $doctor->getId() . "/doctor.txt", "w");
        $drArr = array($doctor->getName(), $doctor->getSpecialization(), $doctor->getExpirience(),);
        $drStr = implode(";", $drArr);
        fwrite($f,$drStr);
        fclose($f);
    }
    protected function setUser (User $user)
    {
        $users = $this->getUsers();
        $found = false;
        foreach ($users as $key => $oneUser) {
            if ($user->getUserName() == $oneUser->getUsername()) {
                $found = true;
                break;
            }
            if ($found) {
                $users [$key] = $user;
                $f = fopen(self::DATA_PATH . "users.txt", "w");
                foreach ($users as $oneUser) {
                    $drArr = array($oneUser->getUsername(), $oneUser->getPassword(), $oneUser->getRights() . "\r\n",);
                    $drStr = implode(";", $drArr);
                    fwrite($f, $drStr);
                }
                fclose($f);
            }
        }
    }

    protected function delPatient(Patient $patient)
    {
        unlink(self::DATA_PATH . $patient->getDoctorId() . "/" . $patient->getId());
    }

    protected function insPatient(Patient $patient)
    {
        $path = self::DATA_PATH . $patient->getDoctorId();
        $conts = scandir($path);
        $i = 0;
        foreach ($conts as $node){
            if(preg_match(self::PATIENT_FILE_TEMPLATE, $node)){
                $last_file = $node;
            }
        }
        $file_index = (String)(((int)substr($last_file, -6, 2)) +1);
        if(strlen($file_index)==1){
            $file_index = "0" . $file_index;
        }
        $newFileName = "patient-" . $file_index . ".txt";

        $patient->setId($newFileName);
        $this->setPatient($patient);
    }

    protected function delDoctor($doctorId)
    {
        $dirName = self::DATA_PATH . $doctorId;
        $conts = scandir($dirName);
        $i = 0;
        foreach ($conts as $node) {
            @unlink($dirName . "/" . $node);
        }
        @rmdir($dirName);
    }

    protected function insDoctor()
    {
        $path = self::DATA_PATH;
        $conts = scandir($path);
        foreach ($conts as $node){
            if(preg_match(self::DOCTOR_FILE_TEMPLATE, $node)){
                $last_doctor = $node;
            }
        }
        $doctor_index = (String)(((int)substr($last_doctor, -1, 2)) +1);
        if (strlen($doctor_index) == 1){
            $doctor_index = "0" . $doctor_index;
        }
        $newDoctorName = "doctor-" . $doctor_index;

        mkdir($path . $newDoctorName);
        $f = fopen($path . $newDoctorName . "/doctor.txt","w");
        fwrite($f, "New; ; ");
        fclose($f);
    }
}