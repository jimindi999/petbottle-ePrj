<?php
    if ($_SESSION['admin'] != 'Admin' && $_SESSION['admin'] != 'Moderator'){
        $f->redir('index.php');
    }else{
        //Get 'm', 's', 'cat' keyword from url to redirect back to the previous page (m = module, s = search keyword, cat = categories id)
        $m = $_GET['m'];
        $s = (isset($_GET['s']))?$_GET['s']:'';
        $id = $_GET['id'];
        $cat = (isset($_GET['cat']))?$_GET['cat']:'';
        $db->execSQL("SET @row_num:=0");
        //Below code to calculate current page of entry before delete it
        $condition = '1 = 1';
        if ($s != ''){
            if ($m = 'users') $condition .= " AND username LIKE '{$s}' OR email LIKE '{$s}' OR firstName LIKE '{$s}' OR lastName LIKE '{$s}'  OR gender LIKE '{$s}'  OR position LIKE '{$s}' OR admin_level LIKE '{$s}'";
            else if($m = 'products' || $m = 'categories') $condition .= " AND pro_name like '{$s}' OR pro_price LIKE '{$s}'";
        }
        if ($m == 'users') $table = 'users';
        else $table = 'products';
        $rs = $db->fetch("SELECT @row_num:=@row_num+1 as nbr, id FROM {$table} WHERE {$condition} ORDER BY id");
        foreach ($rs as $r){
            if($id == $r['id']){
                $no = $r['nbr'];
                break;
            }
        }
        $p = ceil($no/10);
        $sql = "DELETE FROM {$table} WHERE id = '{$id}' ";
        $db->execSQL($sql);
        if($cat == '') $f->redir("?a={$m}&s={$s}&page={$p}");
        else $f->redir("?a={$m}&cat={$cat}&s={$s}&page={$p}");
    }