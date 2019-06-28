<?php
    $xtpa = new XTemplate("views/new_product.html");
    $cat = $db->fetch("SELECT * FROM categories WHERE 1 = 1");
    foreach($cat as $r){
        $xtpa->insert_loop("NEW_PRODUCT.CAT_LIST", array("LS"=>$r));
    }
    if($_POST && $_FILES){
        $name = $_POST['txtName'];
        $price = $_POST['txtPrice'];
        $cat = $_POST['slCat'];
        $quantity = $_POST['txtQuantity'];
        $desc = $_POST['description'];
        $img_name = $_FILES['imgUl']['name'];
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_new_name = substr($img_name, 0, - strlen($img_ext) - 1)."_".time().".".$img_ext;
        $img_tmp = $_FILES['imgUl']['tmp_name'];
        $img_size = $_FILES['imgUl']['size'];
        $img_size_limit = 3000000;
        $ext_arr = array('jpeg', 'jpg', 'png', 'bmp');
        if (in_array($img_ext, $ext_arr) && $img_size < $img_size_limit){
            move_uploaded_file($img_tmp, "../resources/products/".$img_new_name);
            $url = $baseUrl."resources/products/".$img_new_name;
        }
        $cat_id = $db->fetch("SELECT id FROM categories WHERE cat_name = '{$cat}'");
        $cat_id = $cat_id[0]['id'];
        $arr['pro_name'] = $name;
        $arr['cat_id'] = $cat_id;
        $arr['pro_price'] = $price;
        $arr['pro_quantity'] = $quantity;
        $arr['pro_desc'] = $desc;
        $arr['pro_img'] = $url;
        $arr = preg_filter('/^/', '"', $arr);
        $arr = preg_filter('/$/', '"', $arr);
        // print_r($arr);
        if(!$db->checkExist('products', "pro_name like '{$name}'")){
            $db->insert('products', $arr);
            $f->redir('?a=categories');
        }
    }
    $xtpl->assign("title", "Add new product");
    $xtpa->parse("NEW_PRODUCT");
    $content = $xtpa->text("NEW_PRODUCT");