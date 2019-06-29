<?php
    $xtpa = new XTemplate ("views/new_user.html");
    $slAdmin = '';
    $slModerator = '';
    $slNormal = '';
    if($_POST){
        $username = $_POST['txtUsername'];
        $email = $_POST['txtEmail'];
        $pass = $_POST['txtPassword'];
        $passConf = $_POST['txtPasswordConf'];
        $firstName = $_POST['txtFirstName'];
        $lastName = $_POST['txtLastName'];
        $dob = $_POST['txtBirthday'];
        $gender = $_POST['slGender'];
        $position = $_POST['slPosition'];
        $level = $_POST['slAdminLevel'];
        $pass_hash = password_hash($pass, PASSWORD_BCRYPT);
        $do_save = 1;
        $arr['username']    = $username;
        $arr['email']       = $email;
        $arr['password']    = $pass_hash;
        $arr['firstName']   = $firstName;
        $arr['lastName']    = $lastName;
        $arr['dob']         = $dob;
        $arr['gender']      = $gender;
        $arr['position']    = $position;
        $arr['admin_level'] = $level;
        $arr = preg_filter('/^/', '"', $arr);
        $arr = preg_filter('/$/', '"', $arr);
        //Check username format
        $regex = "/^[0-9a-zA-Z\.\-\_]+[0-9a-zA-Z]*$/";
        if (!preg_match($regex, $username, $match) || $match[0] != $username){
            $do_save = 0;
            $xtpa->assign('erUser', 'Invalid, username must not contain special characters (except for .-_ )');
            $match = array();
        }
        //Check email format
        $regex = "/^[a-zA-Z0-9]+[a-zA-Z0-9\.\_]*[a-zA-z0-9]+(@)[a-z]+(\.)[a-z]+(\.[a-z]+)*?$/";
        if (!preg_match($regex, $email, $match) || $match[0] != $email){
            $do_save = 0;
            $xtpa->assign('erEmail', 'Invalid, please check your Email format');
            $match = array();
        }
        //Check password format
        $regex = "/^.{8}.*$/";
        if (!preg_match($regex, $pass, $match) || $match[0] != $pass){
            $do_save = 0;
            $xtpa->assign('erPass', 'Password must contain at least 8 characters');
            $match = array();
        }
        if ($pass != $passConf){
            $do_save = 0;
            $xtpa->assign('erPassConf', 'Passwords must match');
        }
        //Check name format
        $regex = "/^[A-Z](([a-z]*?(\'|\-|\.)[a-zA-Z][a-z]*?)|([a-z]*?))([ ][A-Z](([a-z]*?(\'|\-|\.)[a-zA-Z][a-z]*?)|([a-z]*?)))*?$/";
        if (!preg_match($regex, $firstName, $match) || $match[0] != $firstName){
            $do_save = 0;
            $xtpa->assign('erFName', "Invalid, name must not contain special characters (except for .-' ), first character must be capitalized");
            $match = array();
        }
        if (!preg_match($regex, $lastName, $match) || $match[0] != $lastName){
            $do_save = 0;
            $xtpa->assign('erLName', "Invalid, name must not contain special characters (except for .-' ), first character must be capitalized");
            $match = array();
        }
        //Check age
        $dob_year = explode("-", $dob);
        $dob_year = $dob_year[0];
        $today = getdate();
        $today = $today['year'];
        if (($today - $dob_year) < 18){
            $do_save = 0;
            $xtpa->assign('erDOB', 'Must be at least 18 years old');
        }
        //Check if username or email exists
        if ($db->checkExist("users", "username = '{$username}'")){
            $do_save = 0;
            $xtpa->assign("erUser", 'Username existed');
        }else if ($db->checkExist("users", "email = '{$email}'")){
            $do_save = 0;
            $xtpa->assign("erEmail", 'Email existed');
        }
        if ($do_save === 0){
            $xtpa->assign("username", $username);
            $xtpa->assign("email", $email);
            $xtpa->assign("firstName", $firstName);
            $xtpa->assign("lastName", $lastName);
            $xtpa->assign("birthday", $dob);
            if ($gender === 'Male') $xtpa->assign('slM', 'selected');
            else $xtpa->assign('slF', 'selected');
            if ($position === 'Manager') $xtpa->assign('slManager', 'selected');
            else if ($position === 'Marketing') $xtpa->assign('slMarketing', 'selected');
            else $xtpa->assign('slInventory', 'selected');
            if ($level === 'Admin') $slAdmin = 'selected';
            else if ($level === 'Moderator') $slModerator = 'selected';
            else $slNormal = 'selected';
        }
        if ($do_save === 1){
            $db->insert('users', $arr);
            //redirect to the last page of user listing
            $db->execSQL("SET @row_num:=0");
            $rs = $db->fetch("SELECT *, @row_num:=@row_num+1 as nbr FROM users WHERE 1 = 1 ORDER BY id");
            foreach ($rs as $r){
                if($username == $r['username']){
                    $no = $r['nbr'];
                    break;
                }
            }
            $p = ceil($no/10);
            $f->redir("?a=users&page={$p}");
        }
    }
    //Admin can create new user as admin as max level but moderator can only create moderator at max
    if ($_SESSION['admin'] === 'Admin'){
        $select = "<select id='admin_level' class='form-control' name='slAdminLevel' required>
                        <option value='' hidden>Level</option>
                        <option value='Admin' {$slAdmin}>Admin</option>
                        <option value='Moderator' {$slModerator}>Moderator</option>
                        <option value='Normal' {$slNormal}>Normal</option>
                    </select>";
    }else{
        $select = "<select id='admin_level' class='form-control' name='slAdminLevel' required>
                        <option value='' hidden>Level</option>
                        <option value='Moderator' {$slModerator}>Moderator</option>
                        <option value='Normal' {$slNormal}>Normal</option>
                    </select>";
    }
    $xtpa->assign('select', $select);
    $xtpa->parse("NEW_USER");
    $content = $xtpa->text("NEW_USER");