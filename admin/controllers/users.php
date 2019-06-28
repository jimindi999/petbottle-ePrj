<?php
    if ($_SESSION['admin'] != 'Admin' && $_SESSION['admin'] != 'Moderator'){
        $f->redir('index.php');
    }else{
        $xtpa = new XTemplate("views/users.html");
        $condition = "1 = 1";
        if(isset($_POST['btnDel'])){
            $ls = implode(', ',$_POST['ck']);
            $sql = "DELETE FROM users WHERE id IN ({$ls})";
            $db->execSQL($sql);
        }else if(isset($_GET['s'])){
            $str = $_GET['s'];
            $search_val = str_replace('+','',$str);
            if ($str == 'Male' || $str == 'Female') $condition .= " AND gender = '{$search_val}' ";
            else{
                $str = str_replace('+','%',$str);
                $str = '%'.$str.'%';
                $condition .= " AND username LIKE '{$str}' OR email LIKE '{$str}' OR firstName LIKE '{$str}' OR CONCAT(firstName, ' ', lastName) LIKE '{$str}' OR lastName LIKE '{$str}' OR position LIKE '{$str}' OR admin_level LIKE '{$str}'";
            }
            $xtpa->assign('search',$search_val);
        }
        $user = $db->fetch("SELECT * FROM users WHERE {$condition}");
        $t = count($user);
        $l = 10;
        $page = (isset($_GET['page']))?$_GET['page']:1;
        $offset = ($page - 1) * $l;
        $condition .= " ORDER BY id ASC LIMIT {$offset}, {$l} ";
        $url = 'a=users';
        $user = $db->fetch("SELECT * FROM users WHERE {$condition}");
        $pager = $f->paging($url,$t,$l,'pager', (isset($_GET['s']))?$_GET['s']:'');
        if (count($user) > 0){
            $i = $offset + 1;
            foreach($user as $r){
                $r['no'] = $i;
                $xtpa->insert_loop("ADMIN.LS", array('LS' => $r));
                $i++;
            }
        }
        $xtpl->assign("title", "Users");
        $xtpa->assign('page',$pager);
        $xtpa->parse("ADMIN");
        $content = $xtpa-> text("ADMIN");
    }