<?php
require_once 'app/controllers/asset_controller.php';

class NewsItemController extends AssetController {
  function __construct() {
    $this->name = 'news_item';
    $this->versioning = true;
    $this->base_view_dir = ROOT_DIR;
    parent::__construct();
  }

  function latest($params){
    $html = '';
    $count    = array_key_exists('count', $params)    ? $params['count']    : 3;
    $truncate = array_key_exists('truncate', $params) ? $params['truncate'] : 110;

    $this->set('truncate', $truncate);

    $model = $this->getDefaultModel();
    $items = $model->recent($count);

    foreach ($items as $item) {
      $this->set($item->toArray());
      echo $this->render(array('action'=>'default', 'return'=>true));
    }
  }
}
