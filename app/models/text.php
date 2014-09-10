<?php
require_once 'n_model.php';

class Text extends NModel {
  function __construct() {
    $this->__table = 'text';
    // $this->form_required_fields[] = 'content';
    $this->form_elements['content'] = array('textarea', 'content', 'Content', array('class'=>'ckeditor'));
    $this->form_elements['style_class'] = array('select', 'style_class', 'Style', self::style_classes());
    $this->_order_by = 'cms_headline';
    // You can set this to search a database field.
    $this->search_field = 'content';
    // If you want paging off at all times.
    //$this->paging = 0;
    parent::__construct();
  }

  static function style_classes() {
    return array(
      'default',
      'large-centered',
      'half-column'
    );
  }
}
