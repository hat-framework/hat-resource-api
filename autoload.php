<?php

spl_autoload_register(function ($class) {
    $file = str_replace(array('/', '\\', '//'), DIRECTORY_SEPARATOR, __DIR__ . "/$class.php");
    echo "-$file-\n";
    if (file_exists($file)) {
        require_once($file);
        return;
    }
});
