<?php
try {
    require('sec/config.php');
} catch (Exception $e) {
    header('Location: install.php');
}

require(TEMPLATES . 'header.php');
require(TEMPLATES . 'menu.php');


if(isset($_POST)) {
    $conn = new Connect();
    $conn = $conn->connect();
    $resolve = new Report($conn);
    $resolve->resolve_ticket($_POST);
}
$pop = new PopUp();
$modal_body = '<table id="modalTable"><tbody><tr><th></th><th>Ticket</th></tr>
          <tr><th>ID:</th><td id="ticket_id"></td></tr>
          <tr><th>Name:</th><td id="netid"></td></tr>
          <tr><th>Date:</th><td id="date"></td></tr>
          <tr><th>Status:</th><td id="status"></td></tr>
          </tbody></table><br />
          <p id="message"></p>';

$form = new Form();
$a = array(
    'action' => '#',
    'method' => 'post',
    'id' => 'resolve_form',
);
$modal_form = $form->start_form($a);
$atts = array(
    'name' => 'note',
    'id' => 'note',
    'class' => 'form-control',
    'placeholder' => 'Notes Here'
);
$modal_form .= $form->add_text_area($atts);
$input = $form->add_input('checkbox', 'resolved', ['name' => 'resolved']);
$modal_form .= Utilities::add_label('resolved', $input . ' Resolved?');
$modal_form .= $form->add_input('hidden', '', ['name' => 'ticket',
                                'id' => 'ticket']);
$atts = array(
    'type' => 'submit',
    'class' => 'btn btn-info',
    'value' => 'submit',
);
$modal_form .= $form->add_button('Submit', $atts);

$modal_form .= $form->end_form();
$html = $pop->modal_popup('Ticket', $modal_body, $modal_form);
$html .= '<br />';
// $page->render($html);

$con = new Connect();
$con = $con->connect();
$r = new Retrieve($con);
$results = $r->admin_retrieve();
if (!empty($results)) {
    $table = new Table();
    $html .= $table->display_admin($results);
} else {
    $html .= '
    <div>
        <img src="img/cardimg.png" class="img-responsive center-block" max-width="500px" alt="cute cat">
        <p>
        <h1>Woohoo! There\'s nothing here! You\'ll never actually see this page.</h1>
        </p>
    </div>';
}
$html = $page->create_part($html, ['class' => 'container']);
$page->render($html);


require(TEMPLATES . 'footer.php');
