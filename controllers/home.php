<?php
    $xtpa = new XTemplate('views/home.html');
    $carousel = array();
    $products = $db->fetch("SELECT * FROM vw_products WHERE 1 = 1 ORDER BY id");
    $min_id = $products[0]['id'];
    $max_id = $products[count($products) - 1]['id'];
    for($i = 0; $i < 5; $i++){
        $no = rand($min_id, $max_id);
        if(!in_array($no, $carousel)) array_push($carousel, $no);
        $xtpa->insert_loop('HOME.LS_CAROUSEL', array('LS'=>$products));
    }
    $xtpa->parse('HOME');
    $content = $xtpa->text('HOME');