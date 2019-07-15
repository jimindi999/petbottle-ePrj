<?php
    include ("../libs/config.php");
    //Check is cookies existed => set session id and admin level as existed cookies
    if(isset($_COOKIE['admin_id'])){
        $_SESSION['admin_id'] = $_COOKIE['admin_id'];
        $_SESSION['admin_level'] = $_COOKIE['admin_level'];
        $_SESSION['admin_username'] = $_COOKIE['admin_username'];
    }
    $a = (isset($_GET['a']))?$_GET['a']:'home';
    if(isset($_SESSION['admin_id'])){
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
        $xtpl->assign("baseURL", $baseURL);
        $xtpl->parse("ADMIN");
        $xtpl->out("ADMIN");
    }else if($a == 'forgot_password'){
        include ("controllers/forgot_password.php");
    }else{
        include ("controllers/login.php");
    }