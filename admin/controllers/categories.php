<?php
    $xtpa = new XTemplate("views/categories.html");
    if (!isset($_GET['cat'])){
        $cat = $db->fetch("SELECT * FROM categories WHERE 1 = 1");
        foreach($cat as $r){
            $products = $db->fetch("SELECT * FROM products WHERE cat_id = {$r['id']}");
            $r['count'] = count($products);
            $xtpa->insert_loop("CATEGORIES.LIST",array('CAT'=>$r));
        }
        $xtpl->assign("title", "Categories");
        $xtpa->parse("CATEGORIES");
        $content = $xtpa->text("CATEGORIES");
    }else{
        $cat_id = $_GET['cat'];
        $cat_name = ($db->fetch("SELECT * FROM categories WHERE id = {$cat_id}"))[0]['cat_name'];
        $condition = "1 = 1";
        $products = $db->fetch("SELECT * FROM products WHERE cat_id = {$cat_id}");
        $no = 1;
        foreach($products as $r){
            $r['no'] = $no;
            $r['cat_name'] = $cat_name;
            $xtpa->insert_loop("CAT_PRODUCTS.LS", array("LS"=>$r));
            $no++;
        }
        $xtpl->assign("title", $cat_name);
        $xtpa->parse("CAT_PRODUCTS");
        $content = $xtpa->text("CAT_PRODUCTS");
    }