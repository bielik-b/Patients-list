<?php 
    include (__DIR__ . '\..\auth\check-auth.php');

    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    $patient = (new \Model\Patient())->setId($_GET['file'])->setDoctorId($_GET['doctor']);
    if(!$myModel->removePatient($patient)){
        die($myModel->getError());
    }else{
        header('Location: ../index.php?doctor=' . $_GET['doctor']);
    }

    //if(!CheckRight('patient','delete')){
    //    die('Ви не маєте права на виконання цієї операції !');
    //}
    //unlink(__DIR__ . "/../data/" . $_GET['doctor'] . "/" . $_GET['file']);
    //header('Location: ../index.php?doctor='. $_GET['doctor']);