<?php
require_once 'app/controllers/asset_controller.php';

class MediaElementController extends AssetController {
  function __construct() {
    $this->name = 'media_element';
    $this->versioning = true;
    $this->base_view_dir = ROOT_DIR;
    parent::__construct();
  }
}
