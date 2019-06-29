<?php
    if(isset($_SESSION['user_id'])){
        $f->redir("?a=home");
    }else{
        $xtpa = new XTemplate("views/forgot_password.html");
        if($_POST){
            $do_save = 1;
            $id = $_POST['txtID'];
            $firstName = $_POST['txtFirstName'];
            $lastName = $_POST['txtLastName'];
            $pass = $_POST['txtPass'];
            $passConf = $_POST['txtPassConf'];
            $user = $db->fetch("SELECT * FROM users WHERE username LIKE '{$id}' OR email LIKE '{$id}'");
            if (count($user) === 0){
                $do_save = 0;
                $xtpa->assign('erID', 'Username or email not existed');
            }
            $user = $user[0];
            if ($user['firstName'] != $firstName || $user['lastName'] != $lastName){
                $do_save = 0;
                $xtpa->assign('erName', 'Wrong name');
            }
            if (strlen($pass) < 8){
                $do_save = 0;
                $xtpa->assign('erPass', 'Password must contains at least 8 characters');
            }
            if ($pass != $passConf){
                $do_save = 0;
                $xtpa->assign('erPass', 'Passwords must match');
            }
            if ($do_save === 1){
                $pass_hash = password_hash($pass, PASSWORD_BCRYPT);
                $user_id = $user['id'];
                $db->execSQL("UPDATE users SET password = '{$pass_hash}' WHERE id = {$user_id}");
                $f->redir("?a=login");
            }else{
                $xtpa->assign('id', $id);
                $xtpa->assign('fName', $firstName);
                $xtpa->assign('lName', $lastName);
            }
        }
        $xtpa->assign("baseUrl", $baseUrl);
        $xtpa->parse("FORGOT_PASSWORD");
        $xtpa->out("FORGOT_PASSWORD");
    }