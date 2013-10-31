<?php
include("inc/muneris.php");
list($header,$content)=cera();
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Road Cover</title><meta charset="utf-8" /><meta name="viewport" content="width=device-width, initial-scale=1"/>
      <meta name="mobile-web-app-capable" content="yes"/><meta name="apple-mobile-web-app-capable" content="yes"/>
      <link rel="stylesheet" href="css/bootstrap.min.css" /><link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
      <link rel="stylesheet" href="css/main.css" /><link rel="stylesheet" href="css/icons.css" /><link rel="shortcut icon" href="img/fav.png" />
    <!--[if lt IE 9]>
      <script src="js/html5shiv/dist/html5shiv.js"></script>
    <![endif]-->
    <script src="js/libs/jquery-1.9.0/jquery.min.js" ></script>
   </head>
   <body id="fullBody">
        <!--[if lt IE 9]><p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p><![endif]-->
      <div class="modal hide scena" data-backdrop="static" data-show="true">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?=$header?></h3>
         </div>
         <div class="modal-body">
            <?=$content;?>
         </div>
         <div class="modal-footer">
            <button class="btn" id="submitForm" form="formContent">Submit</button>
            <button class="btn btn-primary" type="button" id="returnForm">Return</button>
         </div>
      </div>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/bibliotheca/lib.muneris.js" ></script>
   <script src="js/bibliotheca/lib.ima.js"></script>
   <script>
      $("#returnForm").click(function(){window.location.href='<?=SITE_URL?>';});
   </script>
   </body>
</html>
