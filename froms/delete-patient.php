<?php 
include (__DIR__ . '\..\auth\check-auth.php');
if(!CheckRight('patient','delete')){
    die('Ви не маєте права на виконання цієї операції !');
}
unlink(__DIR__ . "/../data/" . $_GET['doctor'] . "/" . $_GET['file']);
header('Location: ../index.php?doctor='. $_GET['doctor']); 