<?php
/**
* This class creates navigation menus
*/
class Navigation {

  /**
  * Makes a menu with anchor tabs
  * @param links is a complex array of list items and links
  * $links = [
  *   [
  *     'line_atts' => [],
  *     'value' => 'value',
  *     'url' => 'url',
  *     'anc_atts' =>[],
  *   ],
  * ]
  * @param wrapper is the div wrapper to put the menu in
  * @param list_attr is an array of attributes the list will have
  * @param custom is any custom list items that we want ot include in the list
  */
  public function make_menu($links = array(), $wrapper = array(), $list_attr = array(), $custom) {
    $html = isset($custom) ? $custom : '';
    foreach($links as $link) {
      $html .= '<li ';
      $html .= !empty($list['line_atts']) ? Utilities::add_attributes($list['line_atts']) : '';
      $html .= '><a href="' . $link['value'] . '" ';
      $html .= !empty($list['anc_atts']) ? Utilities::add_attributes($list['anc_atts']) : '';
      $html .= '>' . $list['url'] . '</a></li>';

    }
    if (!empty($list_attr)) {
      $html = '<ul ' . Utilities::add_attributes($list_attr) . '>' . $html . '</ul>';
    } else {
      $html = '<ul>' . $html . '</ul>';
    }

    return  !empty($wrapper) ? Utilities::make_div($html, $wrapper) : $html;

  }

  public function make_navbar($menu, $class, $preCustom = null, $postCustom = null, $div, $attr_ar = array()) {
    $atts .= !empty($attr_ar) ? Utilities::add_attributes($attr_ar) . '>' : '>';
    $html = $preCustom ? $prCustom . $menu : $menu;
    $html .= $postCustom ? $html . $postCustom : '';
    $html = !empty($div) ? Utilities::make_div($html, $div) : '';
    $html = '<nav class="' . $class . '"' . $atts . $html . '</nav>';

    return $html;
  }

}
