<?php

spl_autoload_register(function ($class) {
    $path = __DIR__.DIRECTORY_SEPARATOR;
    $dirs = ['classes', 'controllers', 'models'];

    foreach($dirs as $i => $dir){
        $file_path = $path.'/'.$dir.'/'.$class.'.php';

        if(file_exists($file_path)) {
            include_once $file_path;
        }
    }
});