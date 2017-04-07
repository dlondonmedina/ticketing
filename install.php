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
</head>
<body>
<div class="container">
   <div class="jumbotron">
     <h1 class="display-3">Ticketeer Installation</h1>
     <div id="content1">
         <p>
             Welcome to Ticketeer! Please complete the following information to setup
             the system.
         </p>
         <form method="post" action="first_run.php">
             <div class="form-group">
                 <label for="path">Path: </label>
                 <input type="text" id="path" required name="path" class="form-control" placeholder="Path">
             </div>
             <div class="form-group">
                 <label for="sec_path">Secure Path: </label>
                 <input type="text" id="sec_path" name="sec_path" class="form-control" placeholder="Path to secure folder.">
             </div>
             <div class="form-group">
                 <label for="site_name">Site Name: </label>
                 <input type="text" id="site_name" required name="site_name" class="form-control" placeholder="Site Name">
             </div>
             <div class="form-group">
                 <label for="host">Database Host: </label>
                 <input type="text" id="host" required name="host" class="form-control" placeholder="Database Host">
             </div>
             <div class="form-group">
                 <label for="db_name">Database Name: </label>
                 <input type="text" id="db_name" required name="db_name" class="form-control" placeholder="Database Name">
             </div>
             <div class="form-group">
                 <label for="username">Username: </label>
                 <input type="text" id="username" required name="username" class="form-control" placeholder="Username">
             </div>
             <div class="form-group">
                 <label for="password">Password: </label>
                 <input type="password" id="password" required name="password" class="form-control" placeholder="Password">
             </div>
             <button type="submit" class="btn btn-primary" name="submit">Let's Go!</button>

         </form>
     </div>
 </div>

</div>
</body>
</html>
