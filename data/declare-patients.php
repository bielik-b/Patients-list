<?php
$nameTpl = '/^patient-\d\d.txt\z/';
$path  = __DIR__  . "/" . $doctorsFolder;
$conts = scandir($path); 

$i = 0;
foreach($conts as $node){
    if(preg_match($nameTpl,$node)){
        $data['patients'][$i] = require __DIR__ . '/declare-patient.php';
        $i++;
    }
}
?>