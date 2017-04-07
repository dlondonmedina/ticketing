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
    if (!empty($attr_ar)) {
        foreach($attr_ar as $key => $value) {
            $str .= is_numeric($key) ? $value . ' ': $key . '="' . $value .'" ';
        }
    } else {
        $str = '';
    }

    return $str;
  }

  public static function add_label($label, $value) {
      $str = '<label for="' . $label . '">' . $value . '</label>';
      return $str;
  }

  public static function add_tags($tag, $html, $attr_ar = array()) {
    $str = '<' . $tag . ' ';
    $str .= !empty($attr_ar) ? self::add_attributes($attr_ar) . '>': '>';
    $str .= $html . '</' . $tag . '>';

    return $str;

  }

  function generate_random_string($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString='';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength -1)];
      }
      return $randomString;
  }
}
