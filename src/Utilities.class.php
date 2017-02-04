<?php
/**
* Class for utility functions
*/

class Utilities {

  // check if an array is associative or not
  public static function is_assoc($array) {
        $keys = array_keys($array);
        return array_keys($keys) !== $keys;
  }

  // Add attributes to html tag
  public static function add_attributes($attr_ar = array()) {
    $str = ' ';

    foreach($attr_ar as $key => $value) {
      $str .= is_numeric($key) ? $value . ' ': $key . '="' . $value .'" ';
    }

    return $str;
  }

  public static function make_div($html, $attr_ar = array()) {
    $str = '<div';
    $str .= !empty($attr_ar) ? self::add_attributes($attr_ar) . '>': '>';
    $str .= $html . '</div>';

    return $str;

  }
}
