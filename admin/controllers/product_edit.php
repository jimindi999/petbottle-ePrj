<?php
    $xtpa = new XTemplate('views/product_edit.html');
    $id = $_GET['id'];
    $item = $db->fetch("SELECT * FROM products WHERE id = {$id}");
    $item = $item[0];
    $url_cat = (isset($_GET['cat']))?$_GET['cat']:'';
    $s = (isset($_GET['s']))?$_GET['s']:'';
    $s = str_replace(' ', '+', $s);
    $page = (isset($_GET['page']))?$_GET['page']:'';
    if ($url_cat === '') $url = "?a=products&s={$s}&page={$page}";
    else $url = "?a=categories&cat={$url_cat}&s={$s}&page={$page}";
    $xtpa->assign('url', $url);
    if ($_POST){
        $do_save = 1;
        $name = $_POST['txtName'];
        $price = $_POST['txtPrice'];
        $quantity = isset($_POST['txtQuantity'])?$_POST['txtQuantity']:'';
        $category = $_POST['slCat'];
        $cat = $db->fetch("SELECT * FROM categories WHERE 1 = 1");
        $img_url = $item['pro_img'];
        $doc_url = $item['pro_doc'];
        $erMess = "<td></td>
                    <td><span class='errorMess'>";
        foreach($cat as $r){
            if ($r['cat_name'] === $category){
                $cat_id = $r['id'];
                break;
            }
        }
        //check if user upload new picture
        if ($_FILES['imgUl']['name'] != ''){
            $img_ext_arr = array('jpeg', 'jpg', 'png', 'bmp');
            $img_upload = $f->file_upload('imgUl', $img_ext_arr, 3000000, 'products', $baseUrl);
            $img = explode("|", $img_upload);
            if($img[0] === 'failed'){
                $do_save = 0;
                if($img[1] === 'Upload failed'){
                    $erImg = $erMess."Something happened on the server, please try again later</span></td>";
                    $xtpa->assign('erImg', $erImg);
                }
                else if($img[1] === 'Wrong file type'){
                    $erImg = $erMess."File type not supported, check again, only PNG, BMP, JPG and JPEG are accepted</span></td>";
                    $xtpa->assign('erImg', $erImg);
                }
                else if($img[1] === 'File exceeds size limit'){
                    $erImg = $erMess."File too big, exceeds 3MB limit</span></td>";
                    $xtpa->assign('erImg', $erImg);
                }
            }else{
                $img_url = explode($baseUrl, $img_url);
                $img_url = "../".$img_url[1];
                unlink($img_url);
                $img_url = $img[1];         
            }
        }
        //check if user upload new doc
        if ($_FILES['docUl']['name'] != ''){
            $doc_ext_arr = array('doc', 'docx', 'pdf', 'odt');
            $doc_upload = $f->file_upload('docUl', $doc_ext_arr, 10000000, 'doc', $baseUrl);
            $doc = explode("|", $doc_upload);
            if($doc[0] === 'failed'){
                $do_save = 0;
                if($doc[1] === 'Upload failed'){
                    $erDoc = $erMess."Something happened on the server, please try again later</span></td>";
                    $xtpa->assign('erDoc', $erDoc);
                }
                else if($doc[1] === 'Wrong file type'){
                    $erDoc = $erMess."File type not supported, check again, only DOC, DOCX and PDF are accepted</span></td>";
                    $xtpa->assign('erDoc', $erDoc);
                }
                else if($doc[1] === 'File exceeds size limit'){
                    $erDoc = $erMess."File too big, exceeds 10MB limit</span></td>";
                    $xtpa->assign('erDoc', $erDoc);
                }
            }else{
                $doc_url = explode($baseUrl, $doc_url);
                $doc_url = "../".$doc_url[1];
                unlink($doc_url);
                $doc_url = $doc[1];
            }
        }
        //check if another with the same name existed (not counting current product)
        if ($db->checkExist('products', "id != {$item['id']} AND pro_name like '{$name}'")){
            $do_save = 0;
            $erName = $erMess."*Product with the same name existed</span></td>";
            $xtpa->assign('erName', $erName);
        }
        if ($do_save === 1){
            $db->execSQL("UPDATE products SET pro_name = '{$name}', pro_price = {$price}, pro_quantity = {$quantity}, cat_id = {$cat_id}, pro_img = '{$img_url}', pro_doc = '{$doc_url}' WHERE id = {$id}");
            $f->redir("?a=product_edit&id={$id}");
        }

    }
    $xtpa->assign('pro_name',$item['pro_name']);
    $xtpa->assign('pro_price',$item['pro_price']);
    $xtpa->assign('pro_quantity',$item['pro_quantity']);
    $xtpa->assign('img',$item['pro_img']);
    $cat = $db->fetch("SELECT * FROM categories WHERE 1 = 1");
    foreach($cat as $r){
        if ($r['id'] === $item['cat_id']) $r['selected'] = 'selected';
        $xtpa->insert_loop("ITEM.CAT_LIST", array("LS"=>$r));
    }
    $xtpl->assign('title', "{$item['pro_name']}");
    $xtpa->parse('ITEM');
    $content = $xtpa->text('ITEM');