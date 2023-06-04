<?php

use Model\Patient;
use view\DoctorListView;

include (__DIR__ . '\..\auth\check-auth.php');

    if($_POST){
        require_once '../model/autorun.php';
        $myModel = Model\Data::makeModel(Model\Data::FILE);
        $myModel->setCurrentUser($_SESSION['user']);

        $patient = (new Patient())
                ->setId($_GET['file'])
                ->setDoctorId($_GET['doctor'])
                ->setName($_POST['name'])
                ->setDate(new DateTime($_POST['date']))
                ->setPrivilege($_POST['privilege'])
            -setFemaleGender();
        if($_POST['gender']=='чол'){
            $patient->setMaleGender();
        }
        if(!$myModel->writePatient($patient)){
            die($myModel->getError());
        }else {
            header('Location: ../index.php?doctor=' . $_GET['doctor']);
        }
    }

    $patient = $myModel -> readPatient($_GET['doctor'], $_GET['file']);

    require_once '../view/autorun.php';
    $myView = DoctorListView::makeView(DoctorListView::SIMPLEVIEW);
    $myView->setCurrentUser($myModel->getCurrentUser());
    $myView ->showPatientEditForm();


