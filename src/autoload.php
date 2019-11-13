<?php

function MyAutoload($className) {
    $extension =  spl_autoload_extensions();

    $newClass = str_replace('GrupoAnexxa\Shopify', '', $className);
    require_once (__DIR__ . '/' . $newClass . $extension);
}
spl_autoload_extensions('.php');
spl_autoload_register('MyAutoload');
