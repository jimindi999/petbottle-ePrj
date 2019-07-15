<?php
    if (!isset($_SESSION['admin_id'])){
        $f->redir("index.php");
    }else{
        session_unset();
        $_SESSION = array();
        //Destroy cookie, set limit time to 86400s before current time
        setcookie("user_id", "", time() - 86400, "/");
        setcookie("username", "", time() - 86400, "/");
        setcookie("admin", "", time() - 86400, "/");
        session_destroy();
        $f->redir('index.php');
    }