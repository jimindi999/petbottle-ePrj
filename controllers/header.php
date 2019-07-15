<?php
    $xtpa = new XTemplate('views/header.html');
    
    $xtpa->parse('HEADER');
    $header = $xtpa->text('HEADER');