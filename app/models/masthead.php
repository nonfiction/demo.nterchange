<?php
require_once 'n_model.php';

class Masthead extends NModel {
  function __construct() {
    $this->__table = 'masthead';
    $this->form_elements['image'] = array('cms_file', 'image', 'Image');
    $this->form_required_fields[] = 'cms_headline';
    $this->_order_by = 'cms_headline';
    $this->search_field = 'cms_headline';
    parent::__construct();
  }
}
