<?php
try {
    require('sec/config.php');
} catch (Exception $e) {
    header('Location: index.php');
}

require(TEMPLATES . 'header.php');
require(TEMPLATES . 'announcements_menu.php');

print "Coming Soon!";
