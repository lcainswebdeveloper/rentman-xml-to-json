<?php
require __DIR__.'/../bootstrap.php';
use Nathanmac\Utilities\Parser\Parser as Parser;

try {
    $parser = new Parser();
    $xmlPath = __DIR__.'/../rentman.xml';
    if (file_exists($xmlPath)) {
        $results = $parser->xml(file_get_contents($xmlPath));
        prepr($results);
    }
} catch (\Exception $e) {
    die($e->getMessage);
}

//phpinfo();
