<?php
/**
 * @file polls.php
 * @author Matthew Ruffell
 * @date 10 October 2014
 * @brief This file simply serves up the original angular frontpage
 */
echo doctype('html5');
?>

<html lang="en" ng-app="pollApp">
    <head>
        <meta charset="utf-8">
        <title>Polls</title>
        <?php
            $links = array (
                "angularjs/scripts/angular.js",
                "angularjs/scripts/angular-route.js",
                "angularjs/js/app.js",
                "angularjs/js/controllers.js"
            );
            $scripts = "";
                foreach ($links as $value) {
                    $scripts.= '<script src="';
                    $scripts.= base_url($value);
                    $scripts.= '"></script>';
                    $scripts.= "\n";
                }
            echo $scripts;
        ?>

        <!-- Materialize CSS -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
       <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

       <!-- JavaScript for: jQuery, angular, materialize, and angular-materialize. All of which are needed. -->
       <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.min.js"></script>
       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-materialize/0.1.8/angular-materialize.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Materialize CSS -->

    </head>

    <body>
        <div ng-view></div>
    </body>

</html>
