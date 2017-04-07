<?php
require('sec/config.php');
if (TEMPLATES) {
    require(TEMPLATES . 'header.php');
    require(TEMPLATES . 'menu.php');
} else {
    header('install.php');
}

if($_POST['submit']) {
    $con = new Connect();
    $con = $con->connect();
    $report = new Report($con);
    $report->record_report($_POST);
    $con = null;
}

$form = new Form();
$a = array(
    'action' => '',
    'method' => 'post',
    'id' => 'main_form',
);
$ticket .= $form->start_form($a);
$f = Utilities::add_label('reportmessage', 'What is the issue?');

$a = array(
    'name' => 'message',
    'id' => 'reportmessage',
    'class' => 'form-control',
    'placeholder' => 'Enter Your message here.'
);
$f .= $form->add_text_area($a, 8, 50);
$a = array(
    'id' => 'main_text',
    'class' => 'form-group',
);
$ticket .= Utilities::add_tags('div', $f, $a);
$select = Utilities::add_label('category', 'Type of Issue');
$options = array('Login Issues', 'Printing Issues', 'Network/Internet',
            'Too Many Cats', 'Other');
$a = array(
    'id' => 'category',
    'class' => 'form-control',
    'name' => 'topic'
);
$select .= $form->add_select_list($options, $a, 'Other');

$a = array(
    'id' => 'select_list',
    'class' => 'form-group'
);
$ticket .= Utilities::add_tags('div', $select, $a);
$fields = array();
$vals = ['Low', 'Medium', 'High'];
foreach($vals as $v) {
    $field =array(
        'div_atts' => array(
            'class' => 'form-check',
            'id' => 'urgency_value'),
        'type' => 'radio',
        'value' => $v,
        'text' => $v,
        'attributes' => array(
            'class' => 'form-check-input',
            'name' => 'urgency',
        )
    );

    array_push($fields, $field);
}
$a = array(
    'id' => 'check_list',
    'class' => 'form-group'
);
$ticket .= $form->add_field_set($fields, $a, 'Urgency');

$a = array(
    'type' => 'submit',
    'name' => 'submit',
    'id' => 'submit_button',
    'class' => 'btn btn-info btn-lg',
    'value' => 'Submit'
);
$ticket .= $form->add_button('Submit', $a);
$ticket .= $form->end_form();

$a = array(
    'class' => 'panel',
);
$inner = Utilities::add_tags('div', 'Help Request Form',
                            ['class' => 'panel-heading']);
$inner .= Utilities::add_tags('div', $ticket, ['class' => 'panel-body']);

$panel = Utilities::add_tags('div', $inner, ['class' => 'panel panel-primary']);


$a = array(
    'class' => 'col-md-8 main-content',
);
$mContent = '<header>
        <h1>Report an Issue to the English Department Tech Staff</h1>
        <p>
            To report an issue, please fill out the form below including as much detail as possible. Ideally, let us know when the issue started, what happened then, and what the symptoms are. The more detail you can provide, the better.
        </p>
    </header>';
$html = $page->create_part($mContent . $panel, $a);
$page->render($html);

$content = '
        <div class="card card-outline-secondary text-xs-center">
          <img class="card-img-top" src="img/image10.png" alt="Card image cap" />
          <div class="card-block">
            <h3 class="card-title">From the Tech Staff:</h3>
            <p class="card-text">
              Error reports will be set to the English Department Tech Staff. We will respond to them as quickly as possible.
            </p>
          </div>
        </div>
';

$html = $page->create_part($content, ['class' => 'col-md-4 aside']);
$page->render($html . '</div><!-- end row -->');

// Get Results from db.
$con = new Connect();
$con = $con->connect();
$r = new Retrieve($con);
$results = $r->user_retrieve();

if (isset($results)) {
    // Create the table
    $table = new Table();
    $t = $table->display_results($results);
    $a = array(
        'id' => 'resultsTable',
        'class' => ''
    );
    $html = $page->create_part($t, $a);
    $page->render($html);
}

require(TEMPLATES . 'footer.php');
