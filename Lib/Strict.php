<?php

function strict_error_handler($eNo, $eStr, $eFile, $eLine){
    echo("STRICT: {$eNo} {$eStr} {$eFile} {$eLine}".PHP_EOL);
    //本当は、logfileに出力するほうが望ましい。
}

set_error_handler('strict_error_handler');


