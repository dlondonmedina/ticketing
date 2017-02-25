<?php
require('sec/config.php');
require(TEMPLATES . 'header.php');
require(TEMPLATES . 'menu.php');
?>
<div class="container">
    <div class="well" >
        <div class="well">
            <figure >
                <a href="http://theoatmeal.com/comics/state_web_summer#tumblr"><img class="center-block img-responsive" style="max-height: 400px;" src="../img/lost.png" alt="Are you lost?"/></a>
            </figure>
        </div>
        <div class="well">
            <div id="not-found" class="row">
                <div class="col-md-8 text-center">

                        <p class="not-found not-found-text">
                        Sorry...looks like you took a wrong turn.
                        </p>


                </div>
                <div class="col-md-4 text-center">
                    <a href="/" role="button" class="btn btn-primary btn-lg not-found" aria-pressed="true">Go Back!</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require(TEMPLATES . 'footer.php'); ?>
