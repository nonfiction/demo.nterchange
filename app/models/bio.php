<?php
require_once 'n_model.php';

class Bio extends NModel {
  function __construct() {
    $this->__table = 'bio';
    $this->_order_by = 'cms_headline';
    parent::__construct();
  }
}
