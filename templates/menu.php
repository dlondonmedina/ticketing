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
$list = array(
    'item_zero' => array(
        'link_value' => 'New Ticket',
        'atts' => array(
            'href' => '/'
        )
    ),
    // 'item_one' => array(
    //     'link_value' => 'All Tickets',
    //     'atts' => array(
    //         'href' => '#allTable',
    //         'data-toggle' => 'collapse',
    //         'data-target' => '.tableRows'
    //     )
    // ),
    'item_two' => array(
        'link_value' => 'Open Tickets',
        'atts' => array(
            'id' => 'toggle_table',
            'href' => '',
            'onclick' => 'accordionTable()',
            'data-toggle' => 'collapse',
            'data-target' => '.resolved'
        )
    )
);

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

$wrappers = array(
    'first' => array(
        'tag' => 'div',
        'attributes' => array(
            'class' => 'container',
        )
    )
);
$start_body = $page->start_body($navigation, $wrappers);
$page->render($start_body);
