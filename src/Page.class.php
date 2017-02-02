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
  *
  */
  function __construct() {

  }

  /**
  * Prints the generated html to screen.
  * @param html is the string to be printed.
  */

  function render($html) {
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
  function make_head($title, $langauge = 'en', $charset = 'utf-8', $styles,
                    $scripts, $metadata, $custom ) {
    $html = '<!DOCTYPE html>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
    <!--[if gt IE 8]><!--> <html lang="' . $language . '"> <!--<![endif]--><head>';

    $html .= '<meta charset="' . $charset . '">';
    $html .= '<title>' . $title . '</title>';

    // Add metadata
    if (isset($metadata)) {
      foreach($metadata as $m) {
        $html .= '<meta ';
        foreach($m as $k=>$v) {
          $html .= $k . '="' . $v . '" ';
        }
        $html .= '>';
      }
    }

    if (isset($styles)) {
      foreach($styles as $style) {
        $html .= '<link rel="stylesheet" ';
        foreach($style as $k=>$v) {
          $html .= $k . '="' . $v . '" ';
        }
        $html .= '>';
      }
    }

    if (isset($scripts)) {
      foreach($scripts as $script) {
        $html .= '<script ';
        foreach($script as $k=>$v) {
          $html .= $k . '="' . $v . '" ';
        }
        $html .= '></script>';
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
        foreach($wrap['attributes'] as $k => $v) {
          $html .= $k . '"' . $v . '" ';
        }
        // count how many divs need to be closed.
        $this->wrapperCount++;
      }
      $html .= '>';
    }

    return $html;
  }

  /**
  * Ends the body section with footer and ends html
  * @param foot_content is any content to be included before final scripts
  * @param scripts is an array of scripts to be included
  * @return html string to be rendered
  */
  function end_page($foot_content, $scripts) {
    $html = '';
    if ($wrapperCount > 0 ) {
      for ($i = 0; $i < $wrapperCount; $i++) {
        $html .= '</div>';
      }
    }

    $html.= isset($foot_content) ? $foot_content: '';

    if (isset($scripts)) {
      foreach($scripts as $script) {
        $html .= '<script ';
        foreach($script as $k=>$v) {
          $html .= $k . '="' . $v . '" ';
        }
        $html .= '></script>';
      }
    }

    return $html;
  }

}
