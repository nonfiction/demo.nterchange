<?php
require_once 'n_model.php';

class Bio extends NModel {
  function __construct() {
    $this->__table = 'bio';
    $this->_order_by = 'cms_headline';
    $this->form_elements['image'] = array('cms_file', 'image', 'Image <small>80x80</small>');
    parent::__construct();
  }
}
