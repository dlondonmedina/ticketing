<?php
/**
*
* Creates the main page structure for the site assembling the parts.
* start_body starts the body section
* end_body ends the body section
* make_footer
* render prints html to screen
*/
class Page {
  private $template;
  private $wrapperCount = 0;


  /**
  * Prints the generated html to screen.
  * @param html is the string to be printed.
  */

  public function render($html) {
    if (isset($html)) {
      print $html;
    } else {
      print 'Something went wrong. Please report this error to the
              <a href="mailto:">administrator</a>';
    }
  }

  /**
  * Make head of the page.
  * @param title string for site title
  * @param styles is an associative array of links to stylesheets
  * @param scripts is an associative array of links to scripts
  * @param metadata is an associative array of attributes and vals
  * @param language default=en
  * @param charset default=UTF-8
  * @param custom is any custom html string that needs to be in the head
  * @return html the html string ready to be rendered.
  */
  function make_head($title, $language = 'en', $charset = 'utf-8', $styles,
                    $scripts, $metadata, $custom = Null ) {
    $html = '<!DOCTYPE html>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
    <!--[if gt IE 8]><!--> <html lang="' . $language . '"> <!--<![endif]--><head>';

    $html .= '<meta charset="' . $charset . '">';
    $html .= '<title>' . $title . '</title>' . "\n";

    // Add metadata
    if (isset($metadata)) {
      foreach($metadata as $m) {
        $html .= '<meta ';
        $html .= Utilities::add_attributes($m) . '>' . "\n";
      }
    }

    if (isset($styles)) {
      foreach($styles as $style) {
        $html .= '<link rel="stylesheet" type="text/css" ';
        $html .= Utilities::add_attributes($style) . '>' . "\n";
      }
    }

    if (isset($scripts)) {
      foreach($scripts as $script) {
        $html .= '<script ';
        $html .= Utilities::add_attributes($script) . '></script>'  . "\n";
      }
    }

    if (isset($custom)) {
      $html .= $custom;
    }

    $html .= '</head>';

    return $html;
  }

  /**
  * Starts the body section and adds any styling wrappers needed.
  * @param pre_content is any content that needs to be included before wrappers
  * @param wrappers is a multi-dimensional associative array of wrappers and
  * attributes
  * @return html string to be rendered.
  */
  function start_body($pre_content, $wrappers) {
    $html = '<body>';
    $html .= isset($pre_content) ? $pre_content : '';

    if (isset($wrappers)) {
      foreach($wrappers as $wrap) {
        $html .= '<' . $wrap['tag'] . ' ';
        $html .= Utilities::add_attributes($wrap['attributes']);
        $html .= '>';
        // count how many divs need to be closed.
        $this->wrapperCount++;
      }
    }

    return $html;
  }


  /**
  * Create block div
  * @param content is the content in div.
  * @param attr_ar is the attributes of div.
  * @return html string.
  */
  public function create_part($content, $attr_ar = array()) {
      $str = '<div ';
      $str .= isset($attr_ar) ? Utilities::add_attributes($attr_ar) . '>' : '>';
      $str .= $content;
      $str .= '</div>';
      return $str;
  }


  /**
  * Ends the body section with footer and ends html
  * @param foot_content is any content to be included before final scripts
  * @param scripts is an array of scripts to be included
  * @return html string to be rendered
  */
  function end_page($foot_content, $scripts = array()) {
    $html = '';
    $w = $this->wrapperCount;
    if ($w > 0 ) {
      for ($i = 0; $i < $w; $i++) {
        $html .= '</div>';
      }
    }

    $html.= isset($foot_content) ? $foot_content: '';

    if (isset($scripts)) {
      foreach($scripts as $script) {
        $html .= '<script ';
        $html .= Utilities::add_attributes($script);
        $html .= '></script>';
      }
    }
    $html .= '</body></html>';

    return $html;
  }

}
