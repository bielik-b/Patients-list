<?php
$f = fopen(__DIR__ .  "/" . $doctorsFolder . "/doctor.txt", "r");
        $grStr = fgets($f);
        $grArr = explode(";", $grStr);
        fclose($f);

        $data['doctor'] = array(
            'name' => $grArr[0],
            'specialization' => $grArr[1],
            'expirience' => $grArr[2],

        );
?>