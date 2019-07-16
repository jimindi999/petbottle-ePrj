<?php
    if (!isset($_SESSION['admin_id'])){
        $f->redir("index.php");
    }else{
        session_unset();
        $_SESSION = array();
        //Destroy cookie, set limit time to 86400s before current time
        setcookie("admin_id", "", time() - 86400, "/admin/");
        setcookie("admin_username", "", time() - 86400, "/admin/");
        setcookie("admin_level", "", time() - 86400, "/admin/");
        session_destroy();
        // echo $_COOKIE['admin_id'];
        $f->redir('index.php');
    }