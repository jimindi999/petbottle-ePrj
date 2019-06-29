<?php
    $xtpa = new XTemplate("views/new_product.html");
    $cat = $db->fetch("SELECT * FROM categories WHERE 1 = 1");
    //Dynamically create select tag with Categories from DB as options
    foreach($cat as $r){
        $xtpa->insert_loop("NEW_PRODUCT.CAT_LIST", array("LS"=>$r));
    }
    if($_POST && $_FILES){
        $do_save = 1;
        $name = $_POST['txtName'];
        $price = $_POST['txtPrice'];
        $cat = $_POST['slCat'];
        $quantity = $_POST['txtQuantity'];
        $desc = $_POST['description'];
        //Upload img and doc to sv and get the result
        $img_ext_arr = array('jpeg', 'jpg', 'png', 'bmp');
        $img_upload = $f->file_upload('imgUl', $img_ext_arr, 3000000, 'products', $baseUrl);
        $img = explode("|", $img_upload);
        $doc_ext_arr = array('doc', 'docx', 'pdf');
        $doc_upload = $f->file_upload('docUl', $doc_ext_arr, 10000000, 'doc', $baseUrl);
        $doc = explode("|", $doc_upload);
        if($img[0] === 'failed'){
            $do_save = 0;
            if($img[1] === 'Upload failed') $xtpa->assign('erImg', 'Something happened on the server, please try again later');
            else if($img[1] === 'Wrong file type') $xtpa->assign('erImg', 'File type not supported, check again, only PNG, BMP, JPG and JPEG are accepted');
            else if($img[1] === 'File exceeds size limit') $xtpa->assign('erImg', 'File too big, exceeds 3MB limit');
        }
        if($doc[0] === 'failed'){
            $do_save = 0;
            if($doc[1] === 'Upload failed') $xtpa->assign('erDoc', 'Something happened on the server, please try again later');
            else if($doc[1] === 'Wrong file type') $xtpa->assign('erDoc', 'File type not supported, check again, only DOC, DOCX and PDF are accepted');
            else if($doc[1] === 'File exceeds size limit') $xtpa->assign('erDoc', 'File too big, exceeds 10MB limit');
        }
        if($db->checkExist('products', "pro_name like '{$name}'")){
            $do_save = 0;
            $xtpa->assign("erProduct", "*Product existed");
        }
        //If all processes are fine then insert to DB
        if($do_save === 1){
            $cat_id = $db->fetch("SELECT id FROM categories WHERE cat_name = '{$cat}'");
            $cat_id = $cat_id[0]['id'];
            $arr['pro_name'] = $name;
            $arr['cat_id'] = $cat_id;
            $arr['pro_price'] = $price;
            $arr['pro_quantity'] = $quantity;
            $arr['pro_desc'] = $desc;
            $arr['pro_img'] = $img[1];
            $arr['pro_doc'] = $doc[1];
            $arr = preg_filter('/^/', '"', $arr);
            $arr = preg_filter('/$/', '"', $arr);
            $db->insert("products", $arr);
            //Redirect back to current category page
            $f->redir("?a=categories&cat={$cat_id}");
        }else{
            $xtpa->assign('pro_name', $name);
            $xtpa->assign('pro_price', $price);
            $xtpa->assign('pro_quantity', $quantity);
            $xtpa->assign('pro_desc', $desc);
        }        
    }
    $xtpl->assign("title", "Add new product");
    $xtpa->parse("NEW_PRODUCT");
    $content = $xtpa->text("NEW_PRODUCT");