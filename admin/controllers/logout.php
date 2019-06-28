<?php
    if (!isset($_SESSION['user_id'])){
        $f->redir("index.php");
    }else{
        session_unset();
        $_SESSION = array();
        session_destroy();
        $f->redir('index.php');
    }