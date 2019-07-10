<?php
    $xtpa = new XTemplate('views/test_datatable.html');
    $user = $db->fetch('SELECT * FROM users WHERE 1=1');
    $i = 1;
    foreach($user as $r){
        $r['no'] = $i;
        $i++;
        $xtpa->insert_loop('DATA_TABLE.LS', array('LS'=>$r));
    }
    $xtpa->parse('DATA_TABLE');
    $content = $xtpa->text('DATA_TABLE');