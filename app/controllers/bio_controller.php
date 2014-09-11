<?php
require_once 'app/controllers/asset_controller.php';

class BioController extends AssetController {
  function __construct() {
    $this->name = 'bio';
    $this->versioning = true;
    $this->base_view_dir = ROOT_DIR;
    parent::__construct();
  }
}
