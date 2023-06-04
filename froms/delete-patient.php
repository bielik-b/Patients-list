<?php

use Model\Patient;

include (__DIR__ . '\..\auth\check-auth.php');

    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    $patient = (new Patient())->setId($_GET['file'])->setDoctorId($_GET['doctor']);
    if(!$myModel->removePatient($patient)){
        die($myModel->getError());
    }else{
        header('Location: ../index.php?doctor=' . $_GET['doctor']);
    }
