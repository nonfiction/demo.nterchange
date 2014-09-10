<?php
require_once 'app/controllers/asset_controller.php';

class NavigationController extends AssetController {
  function __construct() {
    $this->name = 'navigation';
    $this->versioning = true;
    $this->base_view_dir = ROOT_DIR;
    parent::__construct();
  }

  // Build navigation from page view. Examples:
  //
  // Build full navigation
  // {call controller=navigation action=nav view=full id=$id}
  //
  // Build side navigation, only listing 2nd level pages
  // {call controller=navigation action=nav view=side level=2 id=$id}
  //
  // Build footer navigation from specific head id (check nterchange for page id)
  // {call controller=navigation action=nav view=foot head=10 id=$id}

  function nav($params){

    $view = $this->params('view', 'default', $params);
    $id = $this->params('id', 1, $params);
    $level = $this->params('level', 1, $params);
    $head = $this->params('head', $this->head_id($id, $level), $params);
    $filler = $this->params('filler', false, $params);

    $index = $this->site_index($id, "id = {$head}");
    if ($filler) $this->filler_pages($index);

    $this->set('index', $index);
    $this->set('id', $id);
    $nav = $this->render(array('action'=>$view, 'return'=>true));

    print $nav;
  }


  function params($name, $default, $params){
    $value = $default;
    if (isset($params[$name])) {
      if (is_numeric($default)){
        if ((int) $params[$name] > 0) $value = (int) $params[$name];
      } else {
        if ($params[$name] != '') $value = $params[$name];
      }
    }
    return $value;
  }


  // Produces hierarchical array of pages
  function site_index($current_id=0, $head_conditions = "parent_id IS NULL"){

    // Each leaf is the result of a query to page model with the extra properties: 'open' and 'children'
    // $page_array = array('id', 'title', ..., 'open'=>'true/false', 'children'=>array('id', ...))
    $page_array = array();
    $page_model = NModel::factory('page');

    // Get the head item
    $page_model->find(array("conditions"=>$head_conditions));
    $page_model->fetch();
    $page = $page_model->toArray();

    $page['children'] = $this->first_and_last($this->page_children($page['id'], $current_id));

    $page['open'] = true;
    $page_array[$page['id']] = $page;

    return $page_array;
  }


  // Recursive function to get all page descendants
  function page_children($id, $current_id=0){
    $page_model = NModel::singleton('page');
    $child_pages = $page_model->getChildren($id);

    foreach ($child_pages as &$child) {
      $child['children'] = $this->first_and_last($this->page_children($child['id'], $current_id));
      $child['open'] = false;
      foreach ($child['children'] as $desc){
        if ($desc['open']) { $child['open'] = true; }
      }
      if ($child['id'] == $current_id) { $child['open'] = true; }
    }
    return $child_pages;
  }


  function first_and_last($child_pages){
    $pages = array();

    $flag = true;
    $last_key = end(array_keys($child_pages));
    foreach($child_pages as $key => $page) {

      // Is this the first page?
      $page['first'] = false;
      if ($flag) {
        $page['first'] = true;
      }
      $flag = false;

      // Is this the last page?
      $page['last'] = false;
      if($key == $last_key) {
        $page['last'] = true;
      }

      $pages[$key] = $page;
    }

    return $pages;
  }


  // Find the head id of given level
  // ie: $level=2 returns the the parent page one level beneath home
  function head_id($current_id, $level=1){
    $page_model = NModel::factory('page');

    $home_id = 1;
    $next_id = $current_id;
    $head_ids = array();

    while (($next_id != $home_id) && ($next_id)) {

      // If the next_id isn't home_id, add it to the list
      array_unshift($head_ids, (int) $next_id);

      // Get the next_id from the parent
      $next_id = $page_model->getParent($next_id);
    }

    array_unshift($head_ids, $home_id);
    array_unshift($head_ids, null);

    return $head_ids[$level];
  }


  function renderContent($params) {
    $page_id = ($params['page_id']) ? $params['page_id'] : 0;
    $container_id = ($params['container_id']) ? $params['container_id'] : 0;

    if (($page_id) and ($container_id)) {
      $page = &NController::factory('page');
      echo $page->getContainerContent($page_id, $container_id);
    }
  }


  function fake_page($name) {
    $page = array();
    $page["path"]     = "#";
    $page["title"]    = $name;
    $page["filename"] = strtolower($name);
    $page["visible"]  = "1";
    $page["active"]   = "1";
    return $page;
  }

  function filler_pages(&$index){
    $filler_pages = array(
      'About' => array(
        'Board of Directors' => array(),
        'Management' => array()
      ),
      'Info' => array(),
      'Contact Us' => array(
        'Location' => array(),
        'Contact Form' => array()
      )
    );

    $home = &$index[1];
    foreach($filler_pages as $name => $children) {
      $level1 = $this->fake_page($name);
      foreach($children as $name => $children) {
        $level2 = $this->fake_page($name);
        foreach($children as $name) {
          $level3 = $this->fake_page($name);
          $level2['children'][] = $level3;
        }
        $level1['children'][] = $level2;
      }
      $home['children'][] = $level1;
    }
  }

  function social($params){
    extract($params);
    $page_model = NModel::factory('page');

    // Get the head item
    $conditions = "parent_id = $head";
    $page_model->find(array("conditions"=>$conditions));
    $this->set('pages', $page_model->fetchAll(true));
    return $this->render(array('action'=>'social', 'return'=>true));
  }
}
