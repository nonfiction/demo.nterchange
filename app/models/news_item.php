<?php
require_once 'n_model.php';

class NewsItem extends NModel {
  function __construct() {
    $this->__table = 'news_item';
    $this->form_field_attributes['description'] = array('class'=>'ckeditor');
    $this->_order_by = 'release_date DESC';
    $this->viewlist_fields = array('release_date', 'cms_headline', 'link');
    parent::__construct();
  }

  function recent($count) {
    $this->find(array('limit'=>$count, 'order_by'=>'release_date DESC', 'conditions'=>'release_date < NOW()'));
    return $this->fetchAll();
  }
}
