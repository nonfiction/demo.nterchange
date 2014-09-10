<?php
require_once 'app/controllers/asset_controller.php';

class BodyImageController extends AssetController {
  function __construct() {
    $this->name = 'body_image';
    $this->versioning = true;
    $this->base_view_dir = ROOT_DIR;
    parent::__construct();
  }

  function index($parameter) {
    $this->redirectTo('viewlist', $parameter);
  }
}
