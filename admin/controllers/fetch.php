<?php
    //Test code for AJAX, not using
    include("../../libs/config.php");
    if(!isset($_REQUEST['s'])){
        $user = $db->fetch("SELECT id, username, email, firstName, lastName, dob, gender, position, admin_level FROM users WHERE 1 = 1 ORDER BY id");
        $userJSON = json_encode($user);
        echo $userJSON;
    }else{
        $s = $_REQUEST['s'];
        if ($s == 'Male' || $s == 'Female') $user = $db->fetch("SELECT id, username, email, firstName, lastName, dob, gender, position, admin_level FROM users WHERE gender = '{$s}' ORDER BY id");
        else{
            $s = str_replace('+', '%', $s);
            $s = '%'.$s.'%';
            $user = $db->fetch("SELECT id, username, email, firstName, lastName, dob, gender, position, admin_level FROM users WHERE username LIKE '{$s}' OR email LIKE '{$s}' OR firstName LIKE '{$s}' OR CONCAT(firstName, ' ', lastName) LIKE '{$s}' OR lastName LIKE '{$s}' OR position LIKE '{$s}' OR admin_level LIKE '{$s}' ORDER BY id");
        }
        $userJSON = json_encode($user);
        echo $userJSON;
    }