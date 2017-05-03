    <?php
    /**
    * This class is a Form Builder. It builds forms.
    */

    class Form {
    /**
    * Start the form. Default values provided.
    * @param attributes is an array of attributes for the form.
    * @return html string.
    */

    public function start_form( $attr_ar = array() ) {

        $str = '<form ';
        if (!empty($attr_ar)) {
            $str .= Utilities::add_attributes( $attr_ar );
        } else {
            $str .= 'action="" method="post" id="new_form"';
        }
        $str .= '>' . "\n";

        return $str;

    }


    /**
    * Add label to a form field.
    * @param name is the name of the label
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
        $str = '<input ';
        $str .= isset($type) ? 'type="' . $type . '" ' : '';
        $str .= isset($value) ? 'value="' . $value . '" ' : '';
        $str .= isset($attr_ar) ? Utilities::add_attributes($attr_ar) . '>' : '>';

        return $str;
    }

    function add_generic( $attr_ar = array()) {
        $str = '<input ';
        $str .= isset($attr_ar) ? Utilities::add_attributes($attr_ar) . '>' : '>';
        return $str;
    }

    /**
    * Add text area to form.
    * @param rows default is 4
    * @param cols default is 30
    * @param value default is empty
    */
    function add_text_area($attr_ar = array(), $rows = 4, $cols = 30) {
        $str = '<textarea ';
        $str .= $attr_ar ? Utilities::add_attributes($attr_ar) : '';
        $str .= 'rows="'. $rows .'" cols="' . $cols . '"></textarea>';

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
    function add_field_set($fields = array(), $attr_ar = array(),
                        $legend = null ) {
        $str = '<fieldset ';
        $str .= !empty($attr_ar) ? Utilities::add_attributes($attr_ar) . '>' : '>';
        $str .= isset($legend) ? '<legend>' . $legend . '</legend><br />' : '';

        foreach ($fields as $field) {
            $in = $this->add_input($field['type'], $field['value'], $field['attributes']);
            $in .= isset($field['text']) ? $field['text'] : '';
            $in = isset($field['label']) ? $this->add_label($field['label'], $field['label_val']) . $in : $in;

            $str .= isset($field['div_atts']) ? Utilities::add_tags('div', $in, $field['div_atts']) : $in;
        }

        $str .= '</fieldset>';

        return $str;

    }

    /**
    * Add a select list to a form.
    * @param option_list is array of options (associative or simple)
    * @param attr_ar is attributes for select list.
    * @param sVal is the optional selected value.
    * @return html string for select list.
    */
    function add_select_list($option_list = array(), $attr_ar = array(),
                            $sVal = Null) {
        $str = '<select ';
        $str .= isset($attr_ar) ? Utilities::add_attributes($attr_ar) . '>' : '>';
        $assoc = Utilities::is_assoc($option_list);
        if ($assoc) {
            foreach ($option_list as $k => $v) {
                $str .= '<option value="' . $k . '"';
                if (isset($sVal) && ($sVal == $k || $sVal == $v)) {
                    $str .= ' selected';
                }
                $str .= '>' . $v . '</option>';
            }
        } else {
            foreach ($option_list as $v) {
                $str .= '<option value="' . $v . '"';
                if (isset($sVal) && ($sVal == $v)) {
                    $str .= ' selected';
                }
                $str .= '>' . $v . '</option>';
            }
        }

        $str .= '</select>';
        return $str;
    }

    /**
    * Add a button to the form.
    * @param text appears next to button.
    * @param atts is attributes for button.
    * @return html string
    */
    public function add_button($text, $attr_ar = array()) {
        $str = '<button ';
        $str .= isset($attr_ar) ? Utilities::add_attributes($attr_ar) . '>': '>';
        $str .= $text . '</button>';

        return $str;
    }

    /**
    * End the form.
    */
    public function end_form() {
        return '</form>';
    }
}
