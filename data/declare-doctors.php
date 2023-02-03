<?php
$nameTpl = '/^doctor-\d\d\z/';
$path  = __DIR__ ;
$conts = scandir($path); 

$i = 0;
foreach($conts as $node){
    if(preg_match($nameTpl,$node)){
        $doctorsFolder = $node;
        require (__DIR__ . '\declare-doctor.php');

        $data['doctors'][$i]['name'] = $data['doctor']['name'];
        $data['doctors'][$i]['file'] = $doctorsFolder;
        $i++;
    }
}