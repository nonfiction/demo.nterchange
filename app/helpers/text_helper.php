<?php
class TextHelper{
  function function_class_id($params, &$view) {
    $class_id = (int)$params['cls'];
    $style_classes = Text::style_classes();
    return $style_classes[$class_id];
  }
}
