<?php

header('Content-type: text/css; charset=UTF-8');
header('Cache-Control: no-transform,public,max-age=3600');
header('Vary: Accept-Encoding');

require $_SERVER['DOCUMENT_ROOT'].'/../vendor/leafo/lessphp/lessc.inc.php';

$less = new lessc;

try {
  echo $less->compileFile("../default.less");
} catch (exception $e) {
  echo "fatal error";
}
