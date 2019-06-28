<?php
    if (!isset($_SESSION['user_id'])){
        $f->redir("index.php");
    }else{
        $xtpa = new XTemplate("views/home.html");
        //Hide user panel from normal users
        if ($_SESSION['admin'] === 'Admin' || $_SESSION['admin'] === 'Moderator'){
            $user = $db->fetch("SELECT * FROM users WHERE 1 = 1");
            $count = count($user);
            $hidden = "<a href='?a=users'>
                            <div class='item red'>
                                Users:<br>
                                {$count}
                            </div>
                        </a>";
            $xtpa->assign('hidden', $hidden);
        }
        $xtpl->assign("title", "Home");
        $cat = $db->fetch("SELECT * FROM categories WHERE 1 = 1");
        $xtpa -> assign("categories", count($cat));
        $pro = $db->fetch("SELECT * FROM products WHERE 1 = 1");
        $xtpa -> assign("products", count($pro));
        $xtpa -> parse("HOME");
        $content = $xtpa -> text("HOME");
    }