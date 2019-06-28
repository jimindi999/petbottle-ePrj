<?php
    if($_SESSION['admin'] === 'Admin' || $_SESSION['admin'] === 'Moderator'){
        $xtpa = new XTemplate('views/nav_admin.html');
    }else $xtpa = new XTemplate('views/nav_normal.html');
    $nav = isset($_GET['a'])?$_GET['a']:'';
    if($nav == 'home' || $nav == '') $xtpa->assign('home','active');
    else if($nav == 'profile') $xtpa->assign('profile','active');
    else if($nav == 'users') $xtpa->assign('admin','active');
    else if($nav == 'categories') $xtpa->assign('categories','active');
    else if($nav == 'products') $xtpa->assign('products','active');
    $xtpa->parse('NAVBAR');
    $navbar = $xtpa->text('NAVBAR');