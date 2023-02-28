<?php
    include (__DIR__ . '\..\auth\check-auth.php');

    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    if(!$myModel->addDoctor()){
        die($myModel->getError());
    }else{
        header('Location: ../index.php?doctor=' . $newDoctorName);
    }

//if(!CheckRight('doctor','create')){
//    die('Ви не маєте права на виконання цієї операції !');
//}
//    $nameTemplate = '/^doctor-\d\d\z/';
//    $path = __DIR__ . "/../data";
//    $const = scandir($path);
//    $i = 0;
//    foreach($const as $node) {
//        if(preg_match($nameTemplate, $node)) {
//            $last_doctor = $node;
//        }
//    }
//    $doctor_index = (String)(((int)substr($last_doctor, -1, 2)) + 1);
//    if(strlen($doctor_index) == 1) {
//        $doctor_index = "0" . $doctor_index;
//    }
//    $newDoctorName = "doctor-" . $doctor_index;
//
//    mkdir(__DIR__ . "/../data/" . $newDoctorName);
//    $f = fopen(__DIR__ . "/../data/" . $newDoctorName . "/doctor.txt", "w");
//    fwrite($f, "New; ; ");
//    fclose($f);
//    header('Location: ../index.php?doctor=' . $newDoctorName);
?>
