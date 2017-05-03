<?php
try {
    require('sec/config.php');
} catch (Exception $e) {
    header('Location: 404.php');
}

require(TEMPLATES . 'header.php');
require(TEMPLATES . 'menu.php');

if($_POST['submit']) {
    $con = new Connect();
    $con = $con->connect();
    $rep = new Report($con);
    $report->record_publication($_POST);
    $con = null;
}

$form = new Form();
$a = array(
    'action' => '',
    'method' => 'post',
    'id' => 'pub_form',
);

$pub = $form->start_form($a);

// Start radio button list
$fields = [];
$vals = [
    'book' => 'Book',
    'edited_collection' => 'Edited Collection',
    'edition' => 'Edition',
    'articles' => 'Article/Essay/Chapter',
    'poem' => 'Poem',
    'story' => 'Story',
    'other' => 'Other'];
foreach($vals as $k => $v) {
    $field = [
        'div_atts' => ['class' => 'form-check'],
        'type' => 'radio',
        'value' => $k,
        'text' => $v,
        'label' => $v,
        'attributes' => [
            'class' => 'form-check-input',
            'name' => 'type',
            'onclick' => 'publicationForm(this)'
        ]
    ];
    array_push($fields, $field);
}
$a = [
    'id' => 'type',
    'class' => 'form-group',
];
$pub .= $form->add_field_set($fields, $a, 'Publication Type');

// Start text fields
$fields = [];
$vals = [
    'title' => 'Title',
    'publication' => 'Publication',
    'pub_date' => 'Date'
    ];
foreach($vals as $k => $v) {
    $field = [
        'div_atts' => [
            'id' => $k
        ],
        'type' => 'text',
        'label' => $v,
        'label_val' => $v,
        'attributes' => [
            'class' => 'form-control',
            'name' => $k,
        ]

    ];
    array_push($fields, $field);

}

$pub .= '<br />';
$a = [
    'id' => 'bibliography',
    'class' => 'form-group',
];
$pub .= $form->add_field_set($fields, $a, 'Bibliographic Information');
$a = array(
    'type' => 'submit',
    'name' => 'submit',
    'id' => 'submit_button',
    'class' => 'btn btn-info btn-lg',
    'value' => 'Submit'
);

$pub .= $form->add_button('Submit', $a);

$pub .= $form->end_form();

$a = array(
    'class' => 'panel',
);

$inner = Utilities::add_tags('div', $pub, ['class' => 'panel-body']);

$panel = Utilities::add_tags('div', $inner, ['class' => 'panel panel-primary']);

$intro = '
<header>
<h1>Did you Publish? Be recognized</h1>
<p>
Do you have new publications that you\'d like us to recognize this year?
If so, fill out the form below to share with us.
</p>
</header>';
$html = $page->create_part($intro . $panel);
$page->render($html);
