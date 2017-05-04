<?php
try {
    require('sec/config.php');
} catch (Exception $e) {
    header('Location: index.php');
}

require(TEMPLATES . 'header.php');
require(TEMPLATES . 'announcements_menu.php');

if ($_POST['submit']) {
    $con = new Connect();
    $con = $con->connect();

}


$form = new Form();
$a = array(
    'action' => '',
    'method' => 'post',
    'id' => 'event_form',
);

$event = $form->start_form($a);
