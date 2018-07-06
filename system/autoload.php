<?php

spl_autoload_register(function($className){
    $appRoot = dirname(__DIR__);
    $file = str_replace('\\', '/', $className) . '.php';

    if(file_exists($appRoot . '/' .$file)){
        require_once $appRoot . '/' . $file;
    }else{
        die('Not found ' . $appRoot . '/' . $file);
    }
});