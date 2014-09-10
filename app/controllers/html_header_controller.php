<?php
require_once 'app/controllers/asset_controller.php';

class HtmlHeaderController extends AssetController {
  function __construct() {
    $this->name = 'html_header';
    $this->versioning = true;
    $this->base_view_dir = ROOT_DIR;
    parent::__construct();
  }
}
