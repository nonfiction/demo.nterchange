<?php
require_once 'n_model.php';

class HtmlHeader extends NModel {
  function __construct() {
    $this->__table = 'html_header';
    $this->_order_by = 'cms_headline';
    parent::__construct();
  }
}
