<?php
// if (file_exists($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'])) return false;
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"])) return false;

require_once dirname(__FILE__).'/../vendor/autoload.php';

$dispatcher = new NDispatcher(NServer::setUri());
$dispatcher->dispatch();
unset($dispatcher);
