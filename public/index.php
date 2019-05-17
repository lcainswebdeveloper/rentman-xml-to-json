<?php
require __DIR__.'/../bootstrap.php';
use Rentman\Rentman;
use Nathanmac\Utilities\Parser\Parser as Parser;

// prepr(simplexml_load_file(__DIR__.'/../tests/Unit/rentman.xml'));
// exit();
try {
    $rentman = new Rentman(__DIR__.'/../gms.xml');
        
    $transformed = $rentman->buildTransformedDataArray();
    header('Content-Type: application/json');
    echo json_encode($transformed['properties']);
    // $parser = new Parser();
    // $xmlPath = __DIR__.'/../tests/Unit/rentman.xml';
    // if (file_exists($xmlPath)) {
    //     $results = $parser->xml(file_get_contents($xmlPath));
    //     prepr($results);
    // }
} catch (\Exception $e) {
    die($e->getMessage);
}

//phpinfo();
