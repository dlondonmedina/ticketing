<?php
require('sec/config.php');

$_SERVER = array("REMOTE_USER" => "bobby");

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
    )
);
$scripts = array(
    'one' => array(
        'src' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
        'integrity' => 'sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa',
        'crossorigin' => 'anonymous',
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
$header = $page->make_head('Helpdesk', 'en', 'utf-8', $styles, $scripts, $meta);
$page->render($header);

$nav = new Navigation();
$list_a = array(
    'class' => 'nav navbar-nav navbar-right',
    'id' => 'my new list',
);
$list_common = array(
    'list_item_class' => 'nav-item',
    'link_class' => 'nav-link',
);
$list = array(
    'item_zero' => array(
        'link_value' => 'New Ticket',
        'link_a' => array(
            'href' => '/',
            'data-toggle' => 'collapse'
        )
    ),
    'item_one' => array(
        'link_value' => 'All Tickets',
        'link_a' => array(
            'href' => '#allTable',
            'data-toggle' => 'collapse'
        )
    ),
    'item_two' => array(
        'link_value' => 'Open Tickets',
        'link_a' => array(
            'href' => '#openTable',
            'data-toggle' => 'collapse'
        )
    )
);

$menu = $nav->make_menu($list, $list_common, $list_a);

$preCustom = '
    <div class="navbar-header">
        <a class="navbar-brand" href="/">Helpdesk @ UW English</a>
    </div>';
$div = array(
    'class' => 'container'
);
$navigation = $nav->make_navbar($menu, 'navbar navbar-light', $div, null, $preCustom);

$wrappers = array(
    'first' => array(
        'tag' => 'div',
        'attributes' => array(
            'class' => 'container',
        )
    ),
    'second' => array(
        'tag' => 'div',
        'attributes' => array(
            'class' => 'row'
        )
    )
);
$start_body = $page->start_body($navigation, $wrappers);
$page->render($start_body);

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

$foot = '<p class="text-center"> UW English Department &copy; ' . date( Y ) . '</p>';
$foot = $page->create_part($foot, ['class' => 'container']);

$scripts = array(
    ['src' => 'https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js
https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js
https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js',
'integrity' => 'sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY
sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB
VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU',
'crossorigin' => 'anonymous'],
    ['src' => 'https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js
https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js
https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js',
'integrity' => 'sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY
sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB
VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU',
'crossorigin' => 'anonymous'],
    ['src' => 'https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js
https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js
https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js',
'integrity' => 'sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY
sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB
VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU',
'crossorigin' => 'anonymous']
);
$html = $page->end_page($foot, $scripts);
$page->render($html);
