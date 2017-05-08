<?php
try {
    require('sec/config.php');
} catch (Exception $e) {
    header('Location: index.php');
}

require(TEMPLATES . 'header.php');
require(TEMPLATES . 'announcements_menu.php');

if($_POST['submit']) {
    $con = new Connect();
    $con = $con->connect();
    $rep = new Report($con);
    $rep->record_publication($_POST);
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
    'title' => 'Title: ',
    'publication' => 'Publication: ',
    'edition' => 'Edition: ',
    'volume' => 'Volume: ',
    'number' => 'Number: ',
    'publisher' => 'Publisher: ',
    'authors' => 'Co-Authors (ex. Jane Doe; Jimmy Example): ',
    'pub_date' => 'Date: ',
    'pages' => 'Page Range: '
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
$pub .= $form->add_form_group($fields, $a, 'Bibliographic Information');
$a = array(
    'type' => 'submit',
    'name' => 'submit',
    'id' => 'submit_button',
    'class' => 'btn btn-info btn-lg',
    'value' => 'submit'
);

$pub .= $form->add_button('Submit', $a);

$pub .= $form->end_form();

$inner = Utilities::add_tags('div', $pub, ['class' => 'panel-body']);

$panel = Utilities::add_tags('div', $inner, ['class' => 'panel panel-primary']);

$intro = '
<h1>English Department Publication List 2016-2017</h1>
<p>
The English Department is seeking to compile a list of publications by our
faculty and graduate students that have come out during the academic year
2016-2017. We want to be able to share with each other and with the world the
exciting research and writing that so many of you have been doing on top of
your many other duties and responsibilities. Below we\'re asking you to enter
the bibliographic information for each of your publications (if any) from
September 2016 onwards. Because we\'re trying to compile a single unified list,
we\'re asking you to use MLA 8 citation style
(see <a href="https://owl.english.purdue.edu/owl/resource/747/22/">
https://owl.english.purdue.edu/owl/resource/747/22</a>). We\'re also asking
you to indicate whether a given publication is a book, edited collection,
article/essay/book chapter, review, short story, poem, or other.
</p>
<p>
Yes, we could try to gather this information from databases, CVs, our web site,
etc, but we would almost certainly compile something wildly inaccurate & out of
date & full of omissions. This way you have an opportunity to take charge of
what you report and how, and we can produce a document worth consulting and
celebrating.
</p>
<p>
Many thanks for taking the time to fill out this form. The recent faculty
climate and workload survey suggests that we as a department need and want to
learn more about each other\'s scholarship and academic commitments; this
exercise is one preliminary step toward that end.
</p><br />';
$con = new Connect();
$con = $con->connect();
$retrieve = new Retrieve($con);
$results = $retrieve->retrieve_pubs();
$pub = new Publications();
$list_of_pubs = $pub->web_display($results);
$html = $page->create_part($intro . $panel . $list_of_pubs, ['class' => 'container']);
$page->render($html);

require(TEMPLATES . 'footer.php');
