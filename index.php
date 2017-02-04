<?php
require('sec/config.php');

$_SERVER = array("REMOTE_USER" => "medinad");

function class_autoloader($class_name) {
  require(WEB_ROOT . 'src/' . $class_name . 'class.php');
}

spl_autoload_register("class_autoloader");

$page = new Page();
$styles = array(
  'href' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
  'integrity' => 'sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u',
  'crossorigin' => 'anonymous',
);
$scripts = array(
  'src' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
  'integrity' => 'sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa',
  'crossorigin' => 'anonymous',
);

$meta = array(
  array(
    'http-equiv' => 'X-UA-Compatible',
    'content' => 'IE=edge,chrome=1',
  ),
  array(
    'name' => 'description',
    'content' => '',
  ),
);
$html = $page->make_head('Helpdesk', 'en', 'utf-8', $styles, $scripts, $meta);
print $html;
$page->render($html);
