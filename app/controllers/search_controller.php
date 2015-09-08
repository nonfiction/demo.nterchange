<?php
require_once 'app/controllers/asset_controller.php';
class SearchController extends AssetController {
  public $name = 'search';

  public $versioning = true;

  public $base_view_dir = ROOT_DIR;

  public $endpoint = 'http://crawwl.nonserver.com/cores/demo.nterchange.com';

  function search($params) {
    $q = ($this->getParam('q')) ? $this->getParam('q') : '';
    if ($q) {
      $q_escaped = urlencode($q);
      $result_url = "{$this->endpoint}?q={$q_escaped}";
      $result_set = json_decode(@file_get_contents($result_url), true);
      $this->set('q', $q);
      $this->set('result_set', $result_set);
    }
    return $this->render(array('action'=>'search_results', 'return'=>true));
  }
}
