<?php
/**
* This class creates navigation menus
*/
class Navigation {

  /**
  * Makes a menu with anchor tabs
  * @param list is a complex array of list items and links
  * $list = array(
  *        'item_n' => array(
  *             'list_item_class' => '',
  *             'link_class' => '',
  *             'link_value' => '',
  *             'link_atts' => array()
  *         )
  *         ...
  * );
  * @param wrapper is the wrapper to put the menu in
  * @param custom is any custom list items that we want ot include in the list
  */
  public function make_menu($list = array(), $list_common = array(), $list_atts = array(), $wrapper = array(), $custom = Null) {

    $html = isset($custom) ? $custom : '';
    $html .= '<ul ' . Utilities::add_attributes($list_atts) . '>';

    foreach($list as $v) {
      $html .= '<li class="' . $list_common['list_item_class'] . '">';
      $html .= '<a class="' . $list_common['link_class'] .'" ';
      $html .= Utilities::add_attributes($v['atts']) . '>';
      $html .= $v['link_value'] . '</a></li>'  . "\n";
    }

    $html .= '</ul>';

    foreach ($wrapper as $w) {
        $html = Utilities::add_tags($w['tag'], $html, $w['atts']);
    }

    return $html;
  }

  public function make_navbar($menu, $id, $class, $preCustom = null, $postCustom = null, $attr_ar = array()) {
    $atts = !empty($attr_ar) ? Utilities::add_attributes($attr_ar) : '';

    $html = '<nav id="' . $id . '" class="' . $class . '"' . $atts . '>';
    $html .= $preCustom ? $preCustom . $menu : $menu;
    $html .= $postCustom ? $postCustom : '';
    $html .= '</nav>';

    return $html;
  }

}
