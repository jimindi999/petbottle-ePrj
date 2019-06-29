<?php
    $xtpa = new XTemplate('views/profile.html');
    if ($_POST){
        $user = $db->fetch("SELECT * FROM users WHERE id = {$_SESSION['user_id']}");
        $user = $user[0];
        $do_save = 1;
        $username = $_POST['txtUsername'];
        $email = $_POST['txtEmail'];
        $pass = $_POST['txtPass'];
        $pass_new = (isset($_POST['txtNew']))?$_POST['txtNew']:'';
        $pass_new_conf = (isset($_POST['txtNewConf']))?$_POST['txtNewConf']:'';
        //check if username existed (not counting current username)
        if ($db->checkExist("users", "id != {$_SESSION['user_id']} AND username = '{$username}'")){
            $do_save = 0;
            $erUsername = "<td></td>
                            <td>
                                <span class='errorMess'>*Username existed</span>
                            </td>";
            $xtpa->assign('erUsername', $erUsername);
        }
        //check if email existed (not counting current email)
        if ($db->checkExist("users", "id != {$_SESSION['user_id']} AND email = '{$email}'")){
            $do_save = 0;
            $erEmail = "<td></td>
                            <td>
                                <span class='errorMess'>*Email existed</span>
                            </td>";
            $xtpa->assign('erEmail', $erEmail);
        }
        //check email format
        $regex = "/^[a-zA-Z0-9]+[a-zA-Z0-9\.\_]*[a-zA-z0-9]+(@)[a-z]+(\.)[a-z]+(\.[a-z]+)*?$/";
        if (!preg_match($regex, $email, $match) || $match[0] != $email){
            $do_save = 0;
            $erEmail = "<td></td>
                            <td>
                                <span class='errorMess'>*Wrong email format</span>
                            </td>";
            $xtpa->assign('erEmail', $erEmail);
            $match = array();
        }
        //check if password is correct
        if (!password_verify($pass, $user['password'])){
            $do_save = 0;
            $erPass = "<td></td>
                            <td>
                                <span class='errorMess'>*Wrong password</span>
                            </td>";
            $xtpa->assign('erPass', $erPass);
        }
        //check if new passwords match
        if ($pass_new != $pass_new_conf){
            $do_save = 0;
            $erPassNewConf = "<td></td>
                            <td>
                                <span class='errorMess'>*Passwords must match</span>
                            </td>";
            $xtpa->assign('erPassNewConf', $erPassNewConf);
        }
        //check new password format
        if ($pass_new != '' && strlen($pass_new) < 8){
            $do_save = 0;
            $erPassNew = "<td></td>
                            <td>
                                <span class='errorMess'>*Passwords must contains at least 8 characters</span>
                            </td>";
            $xtpa->assign('erPassNew', $erPassNew);
        }
        //update DB
        if ($do_save === 1){
            if ($pass_new === '') $db->execSQL("UPDATE users SET username = '{$username}', email = '{$email}' WHERE id = {$user['id']}");
            else{
                $pass_hash = password_hash($pass_new, PASSWORD_BCRYPT);
                $db->execSQL("UPDATE users SET username = '{$username}', email = '{$email}', password = '{$pass_hash}' WHERE id = {$user['id']}");
                $erPass = "<td></td>
                            <td>
                                <span class='errorMess'>*Password changed</span>
                            </td>";
                $xtpa->assign('erPass', $erPass);
            }
        }
    }
    $user = $db->fetch("SELECT * FROM users WHERE id = {$_SESSION['user_id']}");
    $user = $user[0];
    $xtpa->assign('username', $user['username']);
    $xtpa->assign('firstName', $user['firstName']);
    $xtpa->assign('lastName', $user['lastName']);
    $xtpa->assign('gender', $user['gender']);
    $xtpa->assign('dob', $user['dob']);
    $xtpa->assign('position', $user['position']);
    $xtpa->assign('email', $user['email']);
    $xtpa->assign('level', $user['admin_level']);
    $xtpl->assign('title', 'Profile');
    $xtpa->parse('PROFILE');
    $content = $xtpa->text('PROFILE');