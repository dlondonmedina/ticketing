<?php
/**
* This class is a Form Builder. It builds forms.
*/

class Form {
  /**
  * Start the form. Default values provided.
  * @param action is the form action
  * @param method is the form method
  * @param id is the id.
  * @param class is for styling purposes.
  * @param attributes is an array of attributes for the form.
  * @return html string.
  */

  public function start_form( $action = '#', $method = 'post', $id, $class, $attr_ar = array() ) {
    $str = '<form action="' . $action . '" method="' . $method . '"';
    if ( isset($id)) {
      $str.= 'id="' . $id . '"';
    }
    $str .= !empty($attr_ar) ? Utilities::add_attributes( $attr_ar ) : '>';
    return $str;

  }

  /**
  * Add label to a form field.
  * @param name is the fame of the label
  * @param value is the text value of the label.
  */
  function add_label($name, $value) {
      $str = '<label for="' . $name . '">' . $value .'</label>';
      return $str;
  }

  /**
  * function to add input areas except select and TextAreas
  * @param type is the type of input field.
  * @param value is the value that the input will add to $_POST
  * @param attr_ar is an array of attributes for the input.
  * @return returns an html string.
  */
  function add_input( $type, $value, $attr_ar = array() ) {
    $str = '<input"';
    $str .= isset($type) ? 'type="' . $type . '"' : '';
    $str .= isset($value) ? 'value="' . $value . '"' : '';
    $str .= !empty($attr_ar) ? Utilities::add_attributes( $attr_ar ) : '>';

    return $str;
  }

  /**
  * Function for adding fieldset to form
  * @param attr_ar is the attributes for the fieldset.
  * @param legend is the legend for the fieldset if any.
  * @param fields is an array
  *   $fields = array();
  *   $fields[] = array(
  *  'div_atts' => array(),
  *  'label' => '',
  *  'type' => '',
  *   'name' => '',
  *   'id' => '',
  *   'value' => '',
  *   'text' => '',
  *   'attributes' => array(),
  *   );
  */
  function addFieldSet($attr_ar, $legend, $fields = array()) {
    $str = '<fieldset ';
    $str .= !empty($attr_ar) ? Utilities::add_attributes($attr_ar) : '>';
    $str .= isset($legend) ? '<legend>' . $legend . '</legend>' : '';

    foreach ($fields as $field) {

      $in = $this->add_input($field['type'], $field['value'], $field['attributes']);
      $in .= isset($field['text']) ? $field['text'] : '';
      $in = isset($field['label']) ? $this->add_label($field['label'], $in) : $in;

      $str .= Utilities::add_tags('div', $in, $field['div_atts']);
    }

    $str .= '</fieldset>';

    return $str;

  }

}
