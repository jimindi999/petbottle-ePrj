<?php
    include("../../libs/config.php");
    if(!isset($_REQUEST['s'])){
        $user = $db->fetch("SELECT id, username, email, firstName, lastName, dob, gender, position, admin_level FROM users WHERE 1 = 1 ORDER BY id");
        $userJSON = json_encode($user);
        echo $userJSON;
    }