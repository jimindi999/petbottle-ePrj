<?php
    //Test code for AJAX, not using
    $xtpa = new XTemplate("views/user_test.html");
    
    $xtpa->parse("ADMIN");
    $content = $xtpa->text("ADMIN");