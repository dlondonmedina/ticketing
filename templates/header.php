<?php

function class_autoloader($class_name) {
  require(WEB_ROOT . 'src/' . $class_name . '.php');
}

spl_autoload_register("class_autoloader");

// check login. They should be logged in. If not, then we're in trouble.
$_SERVER['REMOTE_USER'] = (isset($_SERVER['REMOTE_USER'])) ? $_SERVER['REMOTE_USER'] : 'jscon';
$raw_uwnetid = $_SERVER['REMOTE_USER'];
$uwnetid = preg_replace('/[^A-Za-z0-9\-]/', '', $raw_uwnetid);
// $clean['uwnetid'] = set_netid($uwnetid);  // see /engl/scripts/header2017.php
// $userOK = ($clean['uwnetid']=="eungrad" || $clean['uwnetid']=="graduate");  // assume false, unless user is eungrad
$is_editor = false;  // needed, since 'eungrad' & 'graduate' get a pass, but aren't editors (which might change)
if ($_SERVER['SERVER_ADDR'] === "127.0.0.1") {
    $logged_in = true;
} else {
    $con = new Connect();
    $con = $con->connect();
    $logged_in = Utilities::check_login($uwnetid, $con);
}


if (!$logged_in) {
    header('Location: https://depts.washington.edu/engl/');
} else {
    if (in_array($uwnetid, ADMIN_USERS)) {
        $is_editor = true;
    } else {
        $is_editor = false;
    }
}


// start new page
$page = new Page();
$styles = [
    [
        'href' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        'integrity' => 'sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u',
        'crossorigin' => 'anonymous',
    ],
    [
        'href' => 'style/custom.css',
    ],
    [
        'href' => 'style/base.css',
    ]

];

$scripts = [
    [
        'src' => 'js/main.js',
    ]
];
if ($is_editor) {
    array_push($scripts, ['src' => 'https://cloud.tinymce.com/stable/tinymce.min.js']);
}


$meta = [
    [
        'http-equiv' => 'X-UA-Compatible',
        'content' => 'IE=edge,chrome=1',
    ],
    [
        'name' => 'description',
        'content' => '',
    ],
    [
        'name' => 'viewport',
        'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no',
    ],
];
$custom = '';
if ($is_editor) {
    $custom = '<script>tinymce.init({ selector: "textarea",
  height: 500,
  theme: "modern",
  plugins: [
    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen",
    "insertdatetime media nonbreaking save table contextmenu directionality",
    "emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help"
  ],
  toolbar1: "undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
  toolbar2: "print preview media | forecolor backcolor emoticons | codesample help",
  image_advtab: true,
  templates: [
    { title: "Test template 1", content: "Test 1" },
    { title: "Test template 2", content: "Test 2" }
  ],
  content_css: [
    "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
    "//www.tinymce.com/css/codepen.min.css"
  ]});</script>';
}
$header = $page->make_head(SITE_NAME, 'en', 'utf-8', $styles, $scripts, $meta, $custom);
$page->render($header);

// Start body
$wrappers = [
    [
        'tag' => 'div',
        'attributes' => [
            'class' => 'container'
        ]
    ]
];
$html = $page->start_body(null, null, ['id' => 'home']);
$content = '<a href="#content">skip to content</a>';
$a = ['id' => 'skiptocontent'];
$html .= $page->create_part($content, $a);

try {
    $html .= file_get_contents('templates/masthead.html');
} catch (Exception $e) {
    $html .= "";
}
$page->render($html);
