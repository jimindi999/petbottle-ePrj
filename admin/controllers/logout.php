<?php
    if (!isset($_SESSION['user_id'])){
        $f->redir("index.php");
    }else{
        session_unset();
        $_SESSION = array();
        setcookie("user_id", "", time() - 3600);
        setcookie("admin", "", time() - 3600);
        session_destroy();
        $f->redir('index.php');
    }