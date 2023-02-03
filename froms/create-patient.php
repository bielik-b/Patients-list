<?php
include (__DIR__ . '\..\auth\check-auth.php');
if(!CheckRight('patient','create')){
    die('Ви не маєте права на виконання цієї операції !');
}

if($_POST){
$nameTpl = '/^patient-\d\d.txt\z/';
$path  = __DIR__  . "/../data/" . $_GET['doctor'];
$conts = scandir($path); 

$i = 0;
foreach($conts as $node){
    if(preg_match($nameTpl,$node)){
            $last_file = $node;
        }   
    }

    $file_index = (String)(((int)substr($last_file, -6, 2)) + 1);
    if(strlen($file_index) == 1){
        $file_index = "0" . $file_index;
    }

    $newFileName = "patient-" . $file_index . ".txt";

    $f = fopen("../data/" . $_GET['doctor'] . "/" . $newFileName, "w");
    $privilege = 0;
    if($_POST['patient_privilege'] == 1){
        $privilege = 1;
    }
    $grArr = array($_POST['patient_name'], $_POST['patient_gender'], $_POST['patient_date'], $privilege);
    $grStr = implode(";", $grArr);
    fwrite($f, $grStr);
    fclose($f);
    header('Location: ../index.php?doctor=' . $_GET['doctor']);
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