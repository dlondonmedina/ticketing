<?php
$foot = '<p class="text-center"> UW English Department &copy; ' . date( Y ) . '</p>';
$foot = $page->create_part($foot, ['class' => 'container']);

$scripts = array(
    ['src' => 'https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js',
'integrity' => 'sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY',
'crossorigin' => 'anonymous'],
    ['src' => 'https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js',
'integrity' => 'sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB',
'crossorigin' => 'anonymous'],
    ['src' => 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js',
'integrity' => 'VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU',
'crossorigin' => 'anonymous']
);
$html = $page->end_page($foot, $scripts);
$page->render($html);
