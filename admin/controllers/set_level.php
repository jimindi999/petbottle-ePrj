<?php
    if ($_SESSION['admin'] != 'Admin' && $_SESSION['admin'] != 'Moderator'){
        $f->redir('index.php');
    }else{
        $level = $_GET['level'];
        $id = $_GET['id'];
        $s = isset($_GET['s'])?$_GET['s']:'';
        $page = isset($_GET['page'])?$_GET['page']:'';
        $db->execSQL("UPDATE users SET admin_level = '{$level}' WHERE id = {$id}");
        //If one were to change their level, the change take effect immediately through the change of $_SESSION['admin']
        if ($id === $_SESSION['user_id']) $_SESSION['admin'] = $level;
        if($s != '' && $page != '') $f->redir("?a=users&s={$s}&page={$page}");
        else if($s == '' && $page != '') $f->redir("?a=users&page={$page}");
        else $f->redir('?a=users');
    }