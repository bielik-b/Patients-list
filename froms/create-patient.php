<?php
    include (__DIR__ . '\..\auth\check-auth.php');

    if($_POST){
        require_once '../model/autorun.php';
        $myModel = Model\Data::makeModel(Model\Data::FILE);
        $myModel->setCurrentUser($_SESSION['user']);

        $patient = (new \Model\Patient())
            ->setDoctorId($_GET['doctor'])
            ->setName($_POST['name'])
            ->setDate(new DateTime($_POST['date']))
            ->setPrivilege($_POST['privilege'])
            ->setFemaleGender();
        if($_POST['gender']=='чол'){
            $patient->setMaleGender();
        }
        if(!$myModel->addPatient($patient)){
            die($myModel->getError());
        }else {
            header('Location: ../index.php?doctor=' . $_GET['doctor']);
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Додавання пацієнта</title>
        <link rel="stylesheet" href="..\css\edit-style-patient.css">
    </head>
    <body>
        <a href="../index.php">На Головну</a>
        <form name='edit-patient' method='post'>
        <div>
            <label for='patinent_name'> ПІБ: </label>
            <input type="text" name="patient_name">
        </div>
        <div>
            <label for='patient_gender'>Стать: </label>
             <select name="patient_gender">
                <option disabled>Стать</option>
                <option value="чол">Чоловіча</option>
                <option value="жін">Жіноча</option>
            </select>
        </div>
        <div>
            <label for="patient_date">Дата Народження</label>
            <input type="date" name="patient_date">
        </div>
        <div>
            <input type="checkbox" name="patient_privilege" value=1> пільга
        </div>   
        <div>
            <input type="submit" name="okay" value="Додати" >
        </div>          
    </form>
    </body>
</html>