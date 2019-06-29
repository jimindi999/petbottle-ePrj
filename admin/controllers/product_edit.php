<?php
    $xtpa = new XTemplate('views/product_edit.html');
    $id = $_GET['id'];
    $item = $db->fetch("SELECT * FROM products WHERE id = {$id}");
    $item = $item[0];
    $xtpl->assign('title', "{$item['pro_name']}");
    $xtpa->parse('ITEM');
    $content = $xtpa->text('ITEM');