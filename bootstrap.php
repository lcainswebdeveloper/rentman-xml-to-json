<?php

require __DIR__.'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

function env($key)
{
    try {
        return getenv($key);
    } catch (\Exception $e) {
        die($e->getMessage());
    }
}

function prepr($arr)
{
    echo "<pre>".print_r($arr, 1)."</pre>";
}

function convertBooleanString($boolString)
{
    if (strtolower($boolString) == 'true') {
        return true;
    }
    return false;
}
