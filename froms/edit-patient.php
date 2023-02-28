<?php 
    include (__DIR__ . '\..\auth\check-auth.php');

    if($_POST){
        require_once '../model/autorun.php';
        $myModel = Model\Data::makeModel(Model\Data::FILE);
        $myModel->setCurrentUser($_SESSION['user']);

        $patient = (new \Model\Patient())
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

    $patient = $myModel->readPatient($_GET['doctor'], $_GET['file']);
//    if(!CheckRight('patient','edit')){
//        die('Ви не маєте права на виконання цієї операції !');
//    }
//
//    if($_POST){
//        $f = fopen("../data/" . $_GET['doctor']. "/" . $_GET['file'], "w");
//        $privilege = 0;
//        if($_POST['patient_privilege'] == 1){
//            $privilege = 1;
//        }
//        $grArr = array($_POST['patient_name'], $_POST['patient_gender'], $_POST['patient_date'], $privilege);
//        $grStr = implode(";", $grArr);
//        fwrite($f, $grStr);
//        fclose($f);
//        header('Location: ../index.php?doctor=' . $_GET['doctor']);
//    }
//
//    $path = __DIR__ . "/../data/" . $_GET['doctor'];
//    $node = $_GET['file'];
//    $patient = require __DIR__ . '/../data/declare-patient.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Редагування пацієнта</title>
        <link rel="stylesheet" href="..\css\edit-style-patient.css">
    </head>
    <body>
        <a href="../index.php">На Головну</a>
        <form name='edit-patient' method='post'>
        <div>
            <label for='patinent_name'> ПІБ: </label>
            <input type="text" name="patient_name" value=' <?php echo $patient->getName();?>'>
        </div>
        <div>
            <label for='patient_gender'>Стать: </label>
             <select name="patient_gender">
                <option disabled>Стать</option>
                <option <?php echo ("чол" == $patient->isGenderMale())?"selected":"";?>value="чол">Чоловіча</option>
                <option <?php echo ("жін" == $patient->isGenderFemale())?"selected":"";?>value="жін">Жіноча</option>
            </select>
        </div>
        <div>
            <label for="patient_date">Дата Народження</label>
            <input type="date" name="patient_date" value='<?php echo $patient->getDate()->format('Y-m-d');?>'>
        </div>
        <div>
            <input type="checkbox" <?php echo ($patient->isPrivilege())?"checked":"" ?>
                     name="patient_privilege"> пільга
        </div>   
        <div>
            <input type="submit" name="okay" value="Змінити" >
        </div>          
    </form>
    </body>
</html>
