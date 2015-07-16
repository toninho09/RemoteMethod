<?php
function __autoload($class_name) {
    require_once "./src/$class_name" . '.php';
}
function calcula($a,$b){
    return $a+$b;
}

$rms = new RemoteMethod\RemoteMethodServer();
$rms->run();

