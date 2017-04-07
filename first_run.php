<?php
// Retrieve and process values from post & sanitize all values.
if ($_POST = filter_input_array(INPUT_POST, FILTER_SANITIZED_STRING)) {
    $path = $_POST['path'];
    $path = substr($path, -1) == '/' ? $path : $path . '/';
    $sec_path = !empty($_POST['sec_path']) ? $_POST['sec_path'] : $path . 'sec/';
    $sec_path = substr($sec_path, -1) == '/' ? $sec_path : $sec_path . '/';
    $site_name = !empty($_POST['site_name']) ? $_POST['site_name'] : 'Ticketeer';
    $host = $_POST['host'];
    $db_name = $_POST['db_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to database
    try {
        $con = new PDO('mysql:host=' . $host . ';dbname=' . $db_name .
        ';charset=utf8mb4', $username, $password, array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    } catch (Exception $e) {
        echo "Could not connect to database";
        echo "<br  />Error Message: " . getMessage($e);
        die();
    }

    // Create Tables
    try {
        $con->exec("DROP TABLE IF EXISTS reports");
        $sql = "CREATE TABLE reports (
            id INT AUTO_INCREMENT PRIMARY KEY,
            netid varchar(10) NOT NULL,
            message text NOT NULL,
            topic varchar(40) NOT NULL,
            urgency varchar(20) NOT NULL,
            status varchar(20) NOT NULL,
            time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

        )";
        $con->exec($sql);

        $con->exec("DROP TABLE IF EXISTS notes");
        $sql = "CREATE TABLE notes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ticket INT,
            note text,
            staff varchar(10),
            time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            $con->exec($sql);

        } catch (Exception $e) {
            echo "Could not create tables";
            echo "Error Message: " . getMessage($e);
            die();
        }
    }


        // Create ConfigFile
        try {
            $f = $sec_path . 'config.php';
            $data = "
            <?php
            /**
            * This file defines globals & other configurations
            */
            //Define paths
            define('WEB_ROOT', '" . $path . "');
            define('TEMPLATES', WEB_ROOT . 'templates/');
            define('SEC_PATH', '" . $sec_path . "');

            // MySQL settings
            define('MYSQL_HOST','" . $host . "');
            define('MYSQL_USERNAME','" . $username . "');
            define('MYSQL_PASSWORD','" . $password . "');
            define('MYSQL_DATABASE','" . $db_name . "');

            // Site settings
            define('SITE_NAME', '" . $site_name . "');
            ";
            $h = fopen($f, 'w+');
            fwrite($h, $data);
            fclose($h);
        } catch (Exception $e) {
            echo "Could not write config file";
            echo "Error Message: " . getMessage($e);
        }


 ?>
 <!DOCTYPE html>
     <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
     <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
     <!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
     <!--[if gt IE 8]><!-->
 <html lang="' . $language . '"> <!--<![endif]-->
 <head>
 <meta charset="utf-8" />
 <title>Ticketeer</title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
 <script>
 function progress() {
     var elem = document.getElementById("pbar");
     var width = 1;
     var i = setInterval(frame, 100);
     function frame() {
         if (width >= 100) {
             clearInterval(i);
             window.location.assign("nuke.php");
         } else {
             width++;
             elem.style.width = width + '%';
         }
     }
 }
 </script>
 </head>
 <body onload="progress()">
      <div class="container">
      <div class="jumbotron">
        <h1 class="display-3">Ticketeer Installation</h1>
        <p class="lead">We're busy installing your ticketing system. We appreciate your patience.</p>
        <hr class="my-4">
        <div class="progress">
            <div id="pbar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
            aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
              </div>
      </div>

  </div>
  </body>
  </html>
