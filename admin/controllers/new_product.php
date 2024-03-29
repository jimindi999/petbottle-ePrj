<?php
    $xtpa = new XTemplate("views/new_product.html");
    $pos = (isset($_GET['cat']))?$_GET['cat']:'';
    $cat = $db->fetch("SELECT * FROM categories WHERE 1 = 1 ORDER BY cat_name");
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
        $img_ext_arr = array('jpeg', 'jpg', 'png', 'bmp', 'webp');
        $img_upload = $f->file_upload('imgUl', $img_ext_arr, 3000000, 'products', $baseURL);
        $img = explode("|", $img_upload);
        $doc[1] = '';      
        if($img[0] === 'failed'){
            $do_save = 0;
            if($img[1] === 'Upload failed') $xtpa->assign('erImg', 'Something happened on the server, please try again later');
            else if($img[1] === 'Wrong file type') $xtpa->assign('erImg', 'File type not supported, check again, only PNG, BMP, JPG, JPEG and WEBP are accepted');
            else if($img[1] === 'File exceeds size limit') $xtpa->assign('erImg', 'File too big, exceeds 3MB limit');
        }
        if($_FILES['docUl']['error'] == 0){
            $doc_ext_arr = array('doc', 'docx', 'pdf', 'odt');
            $doc_upload = $f->file_upload('docUl', $doc_ext_arr, 10000000, 'doc', $baseURL);
            $doc = explode("|", $doc_upload);
            if($doc[0] === 'failed'){
                $do_save = 0;
                $img_loc = $img[1];
                $img_loc = explode($baseURL, $img_loc);
                $img_loc = '../'.$img_loc[1];
                unlink($img_loc);
                if($doc[1] === 'Upload failed') $xtpa->assign('erDoc', 'Something happened on the server, please try again later');
                else if($doc[1] === 'Wrong file type') $xtpa->assign('erDoc', 'File type not supported, check again, only DOC, DOCX and PDF are accepted');
                else if($doc[1] === 'File exceeds size limit') $xtpa->assign('erDoc', 'File too big, exceeds 10MB limit');
            }else{
                if($img[0] === 'failed'){
                    $doc_loc = $doc[1];
                    $doc_loc = explode($baseURL, $doc_loc);
                    $doc_loc = '../'.$doc_loc[1];
                    unlink($doc_loc);
                }
            }
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
            if ($pos != 'none' && $pos != '') $f->redir("?a=categories&cat={$cat_id}");
            else $f->redir('?a=products');
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