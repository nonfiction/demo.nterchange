<?php
require_once 'app/controllers/asset_controller.php';

class NewsItemController extends AssetController {
  function __construct() {
    $this->name = 'news_item';
    $this->versioning = true;
    $this->base_view_dir = ROOT_DIR;
    parent::__construct();
  }

  function latest($count=3){
    $rendered = 0;
    $html = '';
    $model = $this->getDefaultModel();
    $model->find();

    while ($model->fetch()) {
      $this->set($model->toArray());
      $html .= $this->render(array('action'=>'default', 'return'=>true));
      $rendered += 1;
      if ($rendered > $count) break;
    }
    echo $html;
  }
}
