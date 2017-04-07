<?php
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString='';
    for ($i = 0; $i < 26; $i++) {
        $randomString .= $characters[rand(0, $charactersLength -1)];
    }
    rename("first_run.php", $randomString . ".php");

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
function redirect_me() {
    setTimeout(function() {
        window.location.assign('index.php');
    }, 3000);
}
</script>
</head>
<body onload="redirect_me()">
<div class="container">
<div class="jumbotron">
  <h1 class="display-3 text-center">Ticketeer Installation</h1>
  <p class="lead text-center">THANKS!</p>
</div>

</div>
</body>
</html>
