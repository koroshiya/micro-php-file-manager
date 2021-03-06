<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.min.css">
        <link rel="stylesheet" href="css/user.css">
        <script src="js/vendor/modernizr-2.6.2.min.js" async defer></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <script src="js/vendor/jquery-form.min.js" async defer></script>
    <?php
        if (isset($_SESSION['MPFM_authorized']) || !loginRequired){
    ?>
    </head>
    <body style="margin-top:37px;">
        <nav>
            <?php
                if (loginRequired){
            ?>
            <form action="index.php" method="post" style="float:left;">
                <button name="action" type="submit" class="abutton barform stylebutton blackglossyCSSButtonbutton" value="logout">Logout</button>
            </form>
            <?php
                }
            ?>
            <form action="index.php" method="post" style="float:left;">
                <button name="action" type="submit" class="abutton barform stylebutton blackglossyCSSButtonbutton" value="upload">Upload</button>
            </form>
            <form action="index.php" method="post">
                <button name="action" type="submit" class="abutton barform stylebutton blackglossyCSSButtonbutton">Move</button>
            </form>
        </nav>
    <?php
        }else{
    ?>
        <link rel="stylesheet" href="css/login.min.css">
    </head>
    <body>
    <?php
        }
    ?>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->