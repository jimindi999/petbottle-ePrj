<?php
    include ("../libs/config.php");
    //Check is cookies existed => set session id and admin level as existed cookies
    if(isset($_COOKIE['user_id'])){
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['admin'] = $_COOKIE['admin'];
        $_SESSION['username'] = $_COOKIE['username'];
    }
    $a = (isset($_GET['a']))?$_GET['a']:'home';
    if(isset($_SESSION['user_id'])){
        $xtpl = new XTemplate("views/index.html");        
        $a = (isset($_GET['a']))?$_GET['a']:'home';
        if($a != ''){
            if(file_exists("controllers/{$a}.php")){
                include("controllers/{$a}.php");
            }else{
                $content = "404 Not found!";
            }
            include("controllers/nav.php");
            $xtpl->assign('navbar',$navbar);
            if(isset($content)) $xtpl->assign('content',$content);
        }
        include("controllers/footer.php");
        $xtpl->assign('footer', $footer);
        $xtpl->assign("baseUrl", $baseUrl);
        $xtpl->parse("ADMIN");
        $xtpl->out("ADMIN");
        echo 'test';
    }else if($a == 'forgot_password'){
        include ("controllers/forgot_password.php");
    }else{
        include ("controllers/login.php");
    }