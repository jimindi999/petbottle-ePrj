<?php
    $xtpa = new XTemplate("views/user_test.html");
    
    $xtpa->parse("ADMIN");
    $content = $xtpa->text("ADMIN");