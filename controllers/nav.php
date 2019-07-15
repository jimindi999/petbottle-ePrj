<?php
    $xtpa = new XTemplate('views/nav.html');
    $cat = $db->fetch("SELECT * FROM categories WHERE 1 = 1");
    foreach($cat as $r){
        $xtpa->insert_loop('NAV.LS_CAT', array('LS'=>$r));
    }
    $xtpa->parse('NAV');
    $nav = $xtpa->text('NAV');