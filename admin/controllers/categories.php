<?php
    //Can generate 2 different contents base on the existence of 'cat' keyword on url
    $xtpa = new XTemplate("views/categories.html");
    if (!isset($_GET['cat'])){
        //If 'cat' does not presents => show a list of categories from DB
        $cat = $db->fetch("SELECT * FROM categories WHERE 1 = 1 ORDER BY cat_name ASC");
        foreach($cat as $r){
            $products = $db->fetch("SELECT * FROM products WHERE cat_id = {$r['id']}");
            $r['count'] = count($products);
            $xtpa->insert_loop("CATEGORIES.LIST",array('CAT'=>$r));
        }
        $xtpl->assign("title", "Categories");
        $xtpa->parse("CATEGORIES");
        $content = $xtpa->text("CATEGORIES");
    }else{
        //If 'cat' presents => show a list of products in that categories (based on cat_id)
        $cat_id = $_GET['cat'];
        $xtpa->assign('cat_id', $cat_id);
        $condition = "1 = 1 AND cat_id = {$cat_id}";
        if(isset($_POST['btnDel'])){
            //If 'Delete All' button is clicked
            if(isset($_POST['ck'])){
                $ls = implode(', ',$_POST['ck']);
                $sql = "DELETE FROM products WHERE id IN ({$ls})";
                $db->execSQL($sql);
            }
        }else if(isset($_GET['s'])){
            //If 'Search Button' is used
            $str = $_GET['s'];
            $search_val = str_replace('+','',$str);            
            $str = str_replace('+','%',$str);
            $str = '%'.$str.'%';
            $condition .= " AND pro_name LIKE '{$str}' OR pro_price like '{$str}' OR pro_quantity like '{$str}'";
            $xtpa->assign('search',$search_val);
        }
        //Fetch all entries from DB with condition created above
        $products = $db->fetch("SELECT * FROM products WHERE {$condition}");
        $t = count($products);
        $l = 10;
        $page = (isset($_GET['page']))?$_GET['page']:1;
        if ($page === '') $page = 1;
        $offset = ($page - 1) * $l;
        $condition .= " ORDER BY id ASC LIMIT {$offset}, {$l} ";
        $url = "a=categories&cat={$cat_id}";
        //Fetch only 10 entries from DB with condition and limit as above
        $products = $db->fetch("SELECT * FROM products WHERE {$condition}");
        $pager = $f->paging($url,$t,$l,'pager', (isset($_GET['s']))?$_GET['s']:'');
        $cat_name = ($db->fetch("SELECT * FROM categories WHERE id = {$cat_id}"))[0]['cat_name'];
        if (count($products) > 0){
            $i = $offset + 1;
            foreach($products as $r){
                $r['no'] = $i;
                $r['cat_name'] = $cat_name;
                $xtpa->insert_loop("CAT_PRODUCTS.LS", array("LS"=>$r));
                $i++;
            }
        }
        $xtpa->assign('page',$pager);
        $xtpl->assign("title", $cat_name);
        $xtpa->parse("CAT_PRODUCTS");
        $content = $xtpa->text("CAT_PRODUCTS");
    }