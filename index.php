<?php
    include('libs/config.php');
    $xtpl = new XTemplate('views/index.html');
    $a = (isset($_GET['a']))?$_GET['a']:'home';
    if($a != ''){
        if(file_exists("controllers/{$a}.php")){
            include("controllers/{$a}.php");
        }else{
            $content = "404 Not found!";
        }
        if(isset($content)) $xtpl->assign('content',$content);
    }
    include('controllers/header.php');
    include('controllers/nav.php');
    include('controllers/footer.php');
    $xtpl->assign('header', $header);
    $xtpl->assign('nav', $nav);
    $xtpl->assign('footer', $footer);
    $xtpl->assign('baseURL', $baseURL);
    $xtpl->parse('INDEX');
    $xtpl->out('INDEX');