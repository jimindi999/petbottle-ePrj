<?php
    //use to test various code
    $item = $db->fetch("SELECT * FROM products WHERE id = 21");
    $url = $item[0]['pro_img'];
    $url = explode($baseUrl, $url);
    $url = "../".$url[1];
    if (unlink($url)) echo 'done';
    else echo 'failed';

    if ($doc_loc != ''){
        $doc_loc = explode($baseUrl, $doc_loc);
        $doc_loc = '../'.$doc_loc[1];
        // unlink($doc_loc);
    }