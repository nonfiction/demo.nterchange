<?php
class NavigationHelper {
  function function_pageLink($params, &$view) {
    $page = $params['page'];

    // Set the link's href
    $href = $page['external_url'] ? $page['external_url'] : $page['path'];

    // Catch null root path
    $href = $href ? $href : '/';

    // If we're in surf-to-edit, give the /_page[id] type url
    $href = (defined('IN_SURFTOEDIT') && IN_SURFTOEDIT == true) ? "/_page$id" : $href;

    $title = $page['title'];

    return "<a href='{$href}'>{$title}</a>";
  }

  function function_navItem($params, &$view){
    extract($this->parseParams($params));
    $li = "<li $classes><a data-filename='$filename' $class $popout $toggle $href><span>$title</span></a>";
    return preg_replace('!\s+!', ' ', $li);
  }

  function function_navDivider($params, &$view){
    $page = $params['page'];
    if ($page['divider']) {
      return '<li class="divider"></li>';
    }
  }

  private function parseParams($params){
    $page = $params['page'];
    $id = $page['id'];
    $attr = array();

    // Menu title takes priority if it exists
    $attr['title'] = ($page['menu_title']!="") ? $page['menu_title'] : $page['title'];

    // Add target=_blank attribute for external url popup
    $attr['popout'] = ($page['external_url_popout']) ? "target=_blank" : "";

    // Make a friendly classname from the page filename
    $attr['class'] = 'class="nav-' . $page['filename'] . '"';

    // Bootstrap needs this attribute for dropdowns
    $attr['toggle'] = ((isset($params['dropdown'])) && ($page['children'])) ? 'data-toggle="dropdown"' : '';

    // Set the link's href
    $href = $page['external_url'] ? $page['external_url'] : $page['path'];

    // Catch null root path
    $href = $href ? $href : '/';

    // If we're in surf-to-edit, give the /_page[id] type url
    $href = (defined('IN_SURFTOEDIT') && IN_SURFTOEDIT == true) ? "/_page$id" : $href;

    // Set href as attribute
    $attr['href'] = 'href="' . $href . '"';

    // Grid classes
    $grid = (isset($params['grid'])) ? $params['grid'] : '';
    $attr['grid'] = $grid;

    $attr['filename'] = $page['filename'];

    $open = (isset($page['open']) && $page['open']) ? 'open': '';

    // LI classes
    $classes = array("page-{$id} {$grid} {$open}");
    if ($page['first']) $classes[] = "first";
    if ($page['last']) $classes[] = "last";
    if (($page['children']) && ($params['dropdown'])) $classes[] = "dropdown-submenu";
    if ((isset($params['active'])) && ($params['active'] == $id)) $classes[] = "active";
    $attr['classes'] = 'class="' . implode(" ", $classes) . '"';

    return $attr;
  }
}
