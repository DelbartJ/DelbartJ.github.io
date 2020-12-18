<?php
    // CONNEXION BDD
    $pdo = new PDO('mysql:host=localhost;dbname=immobilier','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

    $content = "";

    // constants

    define("URL", "http://" . $_SERVER["HTTP_HOST"]. "/Eval_PHP-SQL_DELBART_Jeremy");
    define("RACINE_SITE", $_SERVER["DOCUMENT_ROOT"]. "/Eval_PHP-SQL_DELBART_Jeremy");


?>  
