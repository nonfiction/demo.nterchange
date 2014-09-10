<?php
class PageHelper{
  function __construct(){
    $this->model = &NModel::singleton('page');
  }

  /**
   * Build the site index and apply it to a navigation template
   *
   * All parameters are optional
   * @param $template    template name to render (navigation/{$template}.html)  , default 'top'
   * @param $current_id  page to set as 'current' and it's ancestors as 'open'  , default 0
   * @param $top_id      top of the nav tree, defaults to home page             , default null
   *
   * @author Andy VanEe <andy@nonfiction.ca>
   */
  function function_nav($params, &$view){
    $nav_controller = NController::factory('navigation');
    extract($params);
    $template = $template ? $template : 'top';
    $this->current_id = $current_id ? $current_id : 0;
    $top_id = $top_id ? $top_id : null;
    $page = array_shift($this->model->getChildren($top_id));
    $this->children($page);
    $nav_controller->set('top', $page);
    $nav_controller->render($template);
  }

  private function children(&$page){
    $page['children'] = $this->model->getChildren($page['id']);
    foreach ($page['children'] as &$child) {
      $this->children($child);
      if ($child['open']) $page['open'] = true;
    }
    if ($page['id'] == $this->current_id) {
      $page['open'] = true;
      $page['current'] = true;
    }
  }

  function block_no_xhr($params, $content, &$smarty, &$repeat) {
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      return '';
    }
    return $content;
  }

  function function_filler($params, &$view){
    $p = array();
    $p[0] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi at scelerisque sem. Nam non ultrices nisi, quis lacinia leo. Mauris quis consectetur erat. Suspendisse rhoncus leo in semper semper. Nulla purus ipsum, placerat et cursus id, tempor eget justo. Donec purus tortor, volutpat vel velit non, porta ultricies sapien. Vestibulum quis massa eros. Nullam id lectus nec lectus lacinia hendrerit a laoreet ligula. Sed aliquet ac ligula eget vestibulum. Nullam rutrum egestas varius. Phasellus nec arcu eget sem volutpat pretium ac in mi. Donec at massa eu lectus auctor vehicula. Pellentesque cursus tortor vel diam congue, in sollicitudin est pretium. Phasellus dictum tempus ligula, id facilisis turpis posuere ut.';
    $p[1] = 'Nam posuere lacus ligula, quis euismod massa vehicula eget. In a fringilla purus, a aliquam dui. Donec sit amet mauris nisl. Sed at lectus neque. Duis tristique nisl sit amet hendrerit lobortis. Mauris convallis dui et mauris volutpat vehicula. Maecenas in euismod odio. Aliquam laoreet est nisi, quis lacinia quam egestas faucibus. Praesent iaculis urna ac arcu laoreet pretium. Aliquam risus velit, euismod quis dapibus vehicula, condimentum ac mi. Sed pretium non nunc sit amet dignissim. Sed pulvinar sed metus non gravida.';
    $p[2] = 'Ut at vestibulum justo. Proin vel pellentesque quam, sit amet tincidunt nisl. Duis bibendum hendrerit arcu quis adipiscing. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris facilisis, odio vitae elementum rutrum, nisl sem vehicula justo, et hendrerit libero felis nec quam. Nulla facilisi. In molestie odio id justo iaculis lobortis. Nam a lectus sed justo hendrerit commodo a aliquam sapien. Ut nisi nisl, consequat in pharetra at, tempus a lacus. Etiam urna augue, pharetra vitae scelerisque vel, tempor quis magna. Ut porttitor ornare metus at euismod.';
    $p[3] = 'Nulla sed ornare ligula, ac aliquam libero. Phasellus elit massa, laoreet ut dolor vel, porta lacinia augue. Nunc vestibulum tellus leo, quis lacinia magna convallis ut. Nulla ut velit id nisl lobortis eleifend in nec arcu. Sed vitae rutrum lectus, consectetur laoreet neque. Morbi sed lobortis mauris. Vestibulum luctus massa eu rhoncus dapibus. Donec enim sem, pellentesque quis elit sodales, tempus blandit quam. Nam ullamcorper interdum posuere. Ut pulvinar eget leo sit amet rutrum. Phasellus interdum viverra condimentum. Vivamus vitae turpis vitae ligula gravida feugiat vel eget nunc. Nulla ultrices volutpat magna, non sagittis eros aliquet sit amet. Nam hendrerit sagittis neque a egestas. Integer in orci auctor, molestie felis non, tincidunt massa. Aliquam et rutrum lacus.';
    $p[4] = 'Phasellus sapien arcu, rhoncus faucibus dictum ut, sagittis id massa. Nunc augue lorem, auctor id erat eu, tristique consectetur leo. Nunc vehicula, massa a lacinia ultricies, ipsum dui iaculis sem, in pharetra tellus nibh et eros. Aliquam erat volutpat. Proin eu dui eu lacus venenatis pharetra. Donec egestas neque ipsum, non eleifend orci elementum ut. Ut pharetra elit at tristique suscipit. Etiam sit amet enim dolor. Integer vel hendrerit purus. Maecenas quis nulla auctor, pharetra tellus sed, aliquam diam.';
    $p[5] = 'Ut vel volutpat justo. Nulla pharetra tristique libero, et interdum nulla bibendum id. Maecenas facilisis dignissim augue a egestas. Morbi tempor dolor lobortis semper consectetur. Integer ipsum diam, tincidunt vel mi at, posuere hendrerit nisl. Vestibulum et dui erat. Nulla pulvinar id metus eu aliquam. Fusce sit amet rhoncus justo. Donec a nisi mi. Duis commodo lobortis laoreet. Donec ullamcorper odio vel massa feugiat auctor. Proin id tincidunt est. Ut porta quam ac accumsan congue.';
    $p[6] = 'Phasellus a lobortis nisi. Fusce egestas iaculis mi, at porttitor ligula tempor a. Mauris consequat tincidunt magna vel imperdiet. Maecenas mollis erat sed sem tincidunt, at mollis enim vulputate. Nulla facilisi. Etiam volutpat congue quam quis eleifend. Mauris sodales elit nisi, nec consectetur nunc suscipit ac. Aliquam rutrum commodo dolor quis mattis. Duis placerat adipiscing tellus, vitae porta metus sodales eu. Donec sit amet tellus id odio ultrices pulvinar. Fusce a pharetra dui. Praesent semper consectetur diam, sed consectetur turpis tempor et. In sed enim dolor.';
    $p[7] = 'Suspendisse malesuada bibendum ligula et fringilla. Etiam orci massa, adipiscing nec purus quis, mollis luctus erat. Integer bibendum sed leo nec elementum. Quisque porttitor mi vitae augue aliquet accumsan. Morbi dignissim nisi id odio dignissim, tincidunt adipiscing justo aliquam. Integer nunc nisi, condimentum id risus nec, faucibus condimentum metus. Aenean fermentum turpis ac urna viverra fringilla. Mauris est dui, laoreet ac augue vitae, malesuada lobortis metus. Nullam at feugiat lacus. Nunc fringilla dui eu erat lobortis, ut ultrices velit convallis. In hac habitasse platea dictumst.';
    $p[8] = 'Donec eu orci malesuada, scelerisque metus vitae, pulvinar tellus. Nulla hendrerit mauris et nulla luctus venenatis. Quisque tempus purus nec nunc pharetra, in ultricies eros cursus. Mauris ornare congue mauris eu tempor. Integer pellentesque leo velit, sed porttitor leo condimentum suscipit. Aenean viverra posuere libero non tincidunt. In ut tristique nisi. Morbi tempus nibh vel nisl tristique ornare et ut nulla. Proin ut odio porttitor, bibendum dolor eu, scelerisque dui. Maecenas eget condimentum lectus, vel tincidunt erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla faucibus lobortis elit sit amet facilisis. Etiam eu eros ligula.';
    $p[9] = 'Fusce id ullamcorper purus, ac consectetur ligula. Suspendisse potenti. Praesent lacinia commodo pellentesque. Fusce egestas cursus diam, vitae commodo enim porttitor sit amet. Curabitur ullamcorper diam vel felis tristique accumsan. Praesent ut ipsum non urna vehicula rhoncus. Vestibulum ligula sem, congue quis ligula vel, faucibus pharetra turpis. Vestibulum faucibus posuere velit sit amet tempus. Aenean a tincidunt sem, sed fermentum erat. Vestibulum pretium rhoncus molestie. Donec pretium tincidunt erat, non porta massa consequat at. Proin porttitor vehicula tempor. Nulla sed adipiscing quam.';
    return '<p>' . implode('</p><p>', array($p[rand(0,9)], $p[rand(0,9)], $p[rand(0,9)])) . '</p>';
  }

  function function_assign_home_children($params, &$view) {
    $page_model = NModel::factory('page');
    $conditions = "parent_id = 1 AND visible = 1 AND active = 1";
    $page_model->find(array("conditions"=>$conditions));
    $view->assign('home_children', $page_model->fetchAll(true));
  }
}
