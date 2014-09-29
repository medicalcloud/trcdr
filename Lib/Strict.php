<?php

function strict_error_handler($eNo, $eStr, $eFile, $eLine){
    die("STRICT STOP: {$eNo} {$eStr} {$eFile} {$eLine}".PHP_EOL);
}

set_error_handler('strict_error_handler');


