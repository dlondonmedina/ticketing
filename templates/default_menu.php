<?php
$nav = new Navigation();
$list_a = array(
    'class' => 'nav navbar-nav',
    'id' => 'mynewlist',
);
$list_common = array(
    'list_item_class' => 'dropdown',
    'link_class' => 'nav-link',
);
$list = [
    [
        'link_value' => 'Announcements',
        'atts' => [
            'href' => '/announcements.php',
        ]
    ],
    [
        'link_value' => 'Helpdesk',
        'atts' => [
            'href' => '/helpdesk.php',
        ],
    ],
];



$menu = $nav->make_menu($list, $list_common, $list_a);
// $preCustom = '
//     <div class="navbar-header">
//         <a class="navbar-brand" href="/">Helpdesk @ UW English</a>
//     </div>';
// $div = array(
//     'class' => 'container'
// );
$a = array(
    'class' => 'navbar-header'
);
$menu = Utilities::add_tags('div', $menu, ['class' => 'navbar-header']);
$menu = Utilities::add_tags('div', $menu, ['class' => 'container']);
$navigation = $nav->make_navbar($menu, 'navbar', 'navbar navbar-default');

$menu = $page->create_part($navigation);
$page->render($menu);
