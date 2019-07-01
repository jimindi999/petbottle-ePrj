<?php
    if (isset($_SESSION['user_id'])){
        $f->redir("?a=home");
    }else{
        $xtpa = new XTemplate("views/login.html");
        if ($_POST){
            $id = $_POST['txtID'];
            $pass = $_POST['txtPass'];
            if ($db->checkExist("users", "username = '{$id}' OR email = '{$id}'")){
                $user = $db->fetchOne("SELECT * FROM users WHERE username = '{$id}' OR email = '{$id}'");
                if (password_verify($pass, $user['password'])){
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['admin'] = $user['admin_level'];
                    $_SESSION['username'] = $user['username'];
                    //Create cookie if user check 'Remember me'
                    if(isset($_POST['ckRemember'])){
                        setcookie("user_id", $user['id'], time() + 30 * 24 * 60 * 60, "/");
                        setcookie("admin", $user['admin_level'], time() + 30 * 24 * 60 *60, "/");
                        setcookie("username", $user['username'], time() + 30 * 24 * 60 *60, "/");
                    }
                    $f->redir("index.php");
                }else $xtpa->assign('errorMess','*Wrong password');
            }else $xtpa->assign('errorMess','*Wrong username or email');
        }
        $xtpa->assign("baseUrl", $baseUrl);
        $xtpa->parse("LOGIN");
        $xtpa->out("LOGIN");
    }