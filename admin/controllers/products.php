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
    $offset = ($page - 1) * $l;
    $condition .= " ORDER BY id ASC LIMIT {$offset}, {$l} ";
    $url = "a=categories";
    //Fetch only 10 entries from DB with condition and limit as above
    $products = $db->fetch("SELECT * FROM products WHERE {$condition}");
    $pager = $f->paging($url,$t,$l,'pager', (isset($_GET['s']))?$_GET['s']:'');    
    if (count($products) > 0){
        $i = $offset + 1;
        foreach($products as $r){
            $r['no'] = $i;
            $cat_name = ($db->fetch("SELECT * FROM categories WHERE id = {$r['cat_id']}"))[0]['cat_name'];
            $r['cat_name'] = $cat_name;
            $xtpa->insert_loop("PRODUCTS.LS", array("LS"=>$r));
            $i++;
        }
    }
    $xtpl->assign('title', 'Products');
    $xtpa->parse('PRODUCTS');
    $content = $xtpa->text('PRODUCTS');