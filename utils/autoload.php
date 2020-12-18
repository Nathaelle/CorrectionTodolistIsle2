<?php

spl_autoload_register(function ($class) {

    if(file_exists("models/$class.php")) {
        require_once "models/$class.php";
    } //elseif(file_exists("nomdossier/$class.php")) {
        //...
    //}

});