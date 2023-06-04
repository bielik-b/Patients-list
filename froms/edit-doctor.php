<?php

use Model\Doctor;
use view\DoctorListView;

include (__DIR__ . '/../auth/check-auth.php');

    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    if($_POST){
        if(!$myModel->writeDoctor((new Doctor())
            ->setId($_GET['doctor'])
            ->setName($_POST['name'])
            ->setSpecialization($_POST['specialization'])
            ->setExpirience($_POST['expirience'])
            )) {
            die($myModel->getError());
        }else{
            header('Location: ../index.php?doctor=' . $_GET['doctor']);
        }
    }
    if (!$data['doctor'] = $myModel->readDoctor($_GET['doctor'])){
        die($myModel->getError());
    }

    require_once '../view/autorun.php';
    $myView = DoctorListView::makeView(DoctorListView::SIMPLEVIEW);
    $myView->setCurrentUser($myModel->getCurrentUser());
    $myView ->showDoctorEditForm();
