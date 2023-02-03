<?php
    $f  = fopen($path . "/" .  $node, "r");
    $rowStr = fgets($f);
    $rowArr = explode(";",$rowStr);
    $patient["file"] = $node;
    $patient["name"] = $rowArr[0];
    $patient["gender"] = $rowArr[1];
    $patient["date"] = $rowArr[2];
    $patient["previlege"] = $rowArr[3];
    fclose($f);

    return $patient;