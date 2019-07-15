<?php
    $xtpa = new XTemplate('views/footer.html');

    $xtpa->parse('FOOTER');
    $footer = $xtpa->text('FOOTER');