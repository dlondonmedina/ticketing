<?php

function class_autoloader($class_name) {
  require(WEB_ROOT . 'src/' . $class_name . '.php');
}

spl_autoload_register("class_autoloader");

$page = new Page();
$styles = array(
    'one' => array(
        'href' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        'integrity' => 'sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u',
        'crossorigin' => 'anonymous',
    ),
    'two' => array(
        'href' => 'style/custom.css',
    ),
    'three' => array(
        'href' => 'style/base.css',
    )
);
$scripts = array(
    'one' => array(
        'src' => 'js/main.js'
    )
);

$meta = array(
  'one' => array(
    'http-equiv' => 'X-UA-Compatible',
    'content' => 'IE=edge,chrome=1',
  ),
  'two' => array(
    'name' => 'description',
    'content' => '',
  ),
  'three' => array(
      'name' => 'viewport',
      'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no'
  )
);
$header = $page->make_head(SITE_NAME, 'en', 'utf-8', $styles, $scripts, $meta);
$page->render($header);

// Add Masthead
include('masthead.php');
