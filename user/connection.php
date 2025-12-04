<!-- Connection file for db_hero_intern -->
<?php
    $dbhostname = "localhost";
    $dbuser = "root";
    $dbname = "db_hero_intern";
    $dbpassword ="";

    $db = mysqli_connect($dbhostname, $dbuser, $dbpassword, $dbname) or die(mysqli_connect_error());
?>