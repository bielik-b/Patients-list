<?php
    include (__DIR__ . '/../auth/check-auth.php');

    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    if (!$myModel->removeDoctor($_GET['doctor'])){
        die($myModel->getError());
    } else{
        header('Location: ../index.php');
    }




//if(!CheckRight('doctor','delete')){
//    die('Ви не маєте права на виконання цієї операції !');
//}
//    $dirName = "../data/" . $_GET['doctor'];
//    $conts = scandir($dirName);
//    $i = 0;
//    foreach ($conts as $node) {
//        @unlink($dirName . "/" . $node);
//    }
//    @rmdir($dirName);
//    header('Location: ../index.php');
?>
