<?php
    if ($_SESSION['admin'] != 'Admin' && $_SESSION['admin'] != 'Moderator'){
        $f->redir('index.php');
    }else{
        $m = $_GET['m'];
        $s = (isset($_GET['s']))?$_GET['s']:'';
        $id = $_GET['id'];
        $db->execSQL("SET @row_num:=0");
        $condition = '1 = 1';
        if ($s != ''){
            if ($m = 'users') $condition .= " AND username LIKE '{$s}' OR email LIKE '{$s}' OR firstName LIKE '{$s}' OR lastName LIKE '{$s}'  OR gender LIKE '{$s}'  OR position LIKE '{$s}' OR admin_level LIKE '{$s}'";
            else if($m = 'categories') $condition .= " AND cat_name like '{$s}'";
            else $condition .= " AND pro_name like '{$s}' OR pro_price LIKE '{$s}'";
        }
        $rs = $db->fetch("SELECT @row_num:=@row_num+1 as nbr, id FROM {$m} WHERE {$condition} ORDER BY id");
        foreach ($rs as $r){
            if($id == $r['id']){
                $no = $r['nbr'];
                break;
            }
        }
        $p = ceil($no/5);
        echo $no." ".$p;
        $sql = "DELETE FROM {$m} WHERE id = '{$id}' ";
        $db->execSQL($sql);
        $f->redir("?a=users&s={$s}&view=5&page={$p}");
    }