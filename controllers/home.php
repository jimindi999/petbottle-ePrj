<?php
    $xtpa = new XTemplate('views/home.html');
    $carousel = array();
    for($i = 0; $i <8; $i++){
        do{
            $item = $db->fetch('SELECT * FROM vw_products ORDER BY RAND() LIMIT 1');
            $no = $item[0]['id'];
        }
        while(in_array($no, $carousel));
        array_push($carousel, $no);
        $xtpa->insert_loop('HOME.ITEMS', array('LS' => $item[0]));
    }
    // foreach($products as $r){
    //     if (in_array($r['id'], $carousel)){
    //         if ($f == 1) $xtpa->assign('active', 'active');
    //         $f++;
    //         $xtpa->insert_loop('HOME.LS_CAROUSEL', array('LS' => $r));
    //     }
    // }
    $xtpa->parse('HOME');
    $content = $xtpa->text('HOME');