<?php
    include (__DIR__ . '\..\auth\check-auth.php');

    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    $myModel->setCurrentUser($_SESSION['user']);

    if($_POST){
        if(!$myModel->writeDoctor((new \ Model\Doctor())
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

//if(!CheckRight('doctor','edit')){
//    die('Ви не маєте права на виконання цієї операції !');
//}
//
//if($_POST){
//    $f = fopen("../data/" . $_GET['doctor'] . "/doctor.txt", "w");
//$grArr = array ($_POST['name'], $_POST['specialization'], $_POST['expirience'],);
//$grStr = implode(";",$grArr);
//fwrite($f, $grStr);
//fclose($f);
//header('Locaiton:../index.php?doctor=' . $_GET['doctor']);
//}
//$doctorsFolder = $_GET['doctor'];
//require('..\data\declare-doctor.php');
//?>
<!DOCTYPE html>
<html>
    <head>
        <title>Редагування даних</title>
        <link rel=stylesheet href="..\css\edit-style.css">
    </head>
    <body>
        <a href="\patients-list\index.php">На Головну</a>
        <form name='edit-list' method='post'>
            <div><label for='name'>Лікар :</label><input type="text" name="name" value="<?php 
            echo $data ['doctor']->getName();?>"></div>
            <div><label for='specialization'>Спеціалізація :</label><input type="text" name="specialization" value="<?php 
            echo $data ['doctor']->getSpecialization();?>"></div>
            <div><label for='expirience'>Досвід :</label><input type="text" name="expirience" value="<?php 
            echo $data ['doctor']->getExpirience();?>"></div>
            <div><input type="submit" name="okay" value="Змінити"></div>
        </form>  
    </body>
</html>