<?php
    if (isset($_SESSION['admin_id'])){
        $f->redir("?a=home");
    }else{
        $xtpa = new XTemplate("views/login.html");
        if ($_POST){
            $id = $_POST['txtID'];
            $pass = $_POST['txtPass'];
            if ($db->checkExist("users", "username = '{$id}' OR email = '{$id}'")){
                $user = $db->fetchOne("SELECT * FROM users WHERE username = '{$id}' OR email = '{$id}'");
                if (password_verify($pass, $user['password'])){
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_level'] = $user['admin_level'];
                    $_SESSION['admin_username'] = $user['username'];
                    //Create cookie if user check 'Remember me'
                    if(isset($_POST['ckRemember'])){
                        setcookie("admin_id", $user['id'], time() + 30 * 24 * 60 * 60, "/admin/");
                        setcookie("admin_level", $user['admin_level'], time() + 30 * 24 * 60 *60, "/admin/");
                        setcookie("admin_username", $user['username'], time() + 30 * 24 * 60 *60, "/admin/");
                    }
                    $f->redir("index.php");
                }else $xtpa->assign('errorMess','*Wrong password');
            }else $xtpa->assign('errorMess','*Wrong username or email');
        }
        $xtpa->assign("baseURL", $baseURL);
        $xtpa->parse("LOGIN");
        $xtpa->out("LOGIN");
    }