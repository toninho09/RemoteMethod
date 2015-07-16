<?php
function __autoload($class_name) {
    require_once "./src/$class_name" . '.php';
}
$rm = new RemoteMethod\RemoteMethodClient();

$url = 'http://localhost/teste.php';

$rm->setUrl($url);
echo $rm->callRemoteMethod('calcula',10,10);
