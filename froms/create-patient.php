<?php

use Model\Patient;
use view\DoctorListView;

include (__DIR__ . '\..\auth\check-auth.php');

    if($_POST){
        require_once '../model/autorun.php';
        $myModel = Model\Data::makeModel(Model\Data::FILE);
        $myModel->setCurrentUser($_SESSION['user']);

        try {
            $patient = (new Patient())
                ->setDoctorId($_GET['doctor'])
                ->setName($_POST['name'])
                ->setDate(new DateTime($_POST['date']))
                ->setPrivilege($_POST['privilege'])
                ->setFemaleGender();
        } catch (Exception $e) {
        }
        if($_POST['gender']=='чол'){
            $patient->setMaleGender();
        }
        if(!$myModel->addPatient($patient)){
            die($myModel->getError());
        }else {
            header('Location: ../index.php?doctor=' . $_GET['doctor']);
        }
    }

    require_once '../view/autorun.php';
    $myView = DoctorListView::makeView(DoctorListView::SIMPLEVIEW);
    $myView ->showPatientCreateForm();
