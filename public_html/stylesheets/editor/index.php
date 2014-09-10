<?php

header('Content-type: text/css');

require $_SERVER['DOCUMENT_ROOT'].'/../vendor/leafo/lessphp/lessc.inc.php';

$less = new lessc;

try {
  echo $less->compileFile("../editor.less");
} catch (exception $e) {
  echo "fatal error";
}
