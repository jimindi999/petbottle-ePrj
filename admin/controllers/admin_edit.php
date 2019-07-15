<?php
    if ($_SESSION['admin_level'] != 'Admin' && $_SESSION['admin_level'] != 'Moderator'){
        $f->redir('index.php');
    }else{
        $xtpa = new XTemplate("views/admin_edit.html");
        $id = $_GET['id'];
        $user = $db->fetch("SELECT * FROM users WHERE id = {$id}");
        $xtpl->assign('title', $user[0]['username']);
        $xtpa->parse('ADMIN_EDIT');
        $content = $xtpa->text('ADMIN_EDIT');
    }