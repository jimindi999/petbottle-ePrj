<?php  
    $xtpa = new XTemplate('views/products.html');
    $condition = "1 = 1";
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
        // $search_val = str_replace('+','',$str);   
        $search_val = $str;         
        $str = str_replace(' ','%',$str);
        $str = '%'.$str.'%';
        $condition .= " AND pro_name LIKE '{$str}' OR pro_price like '{$str}' OR pro_quantity like '{$str}' OR cat_name like '{$str}'";
        $xtpa->assign('search',$search_val);
    }
    //Fetch all entries from DB with condition created above
    $products = $db->fetch("SELECT * FROM vw_products WHERE {$condition}");
    $t = count($products);
    $l = 10;
    $page = (isset($_GET['page']))?$_GET['page']:1;
    $offset = ($page - 1) * $l;
    $condition .= " ORDER BY id ASC LIMIT {$offset}, {$l} ";
    $url = "a=products";
    //Fetch only 10 entries from DB with condition and limit as above
    $products = $db->fetch("SELECT * FROM vw_products WHERE {$condition}");
    $pager = $f->paging($url,$t,$l, (isset($_GET['s']))?$_GET['s']:'');    
    if (count($products) > 0){
        $i = $offset + 1;
        foreach($products as $r){
            $r['no'] = $i;
            $s = (isset($_GET['s']))?implode('+', explode(' ',$_GET['s'])):'';
            $r['s'] = $s;
            $r['page'] = (isset($page))?$page:'1';
            $xtpa->insert_loop("PRODUCTS.LS", array("LS"=>$r));
            $i++;
        }
    }
    $xtpa->assign('page',$pager);
    $xtpl->assign('title', 'Products');
    $xtpa->parse('PRODUCTS');
    $content = $xtpa->text('PRODUCTS');