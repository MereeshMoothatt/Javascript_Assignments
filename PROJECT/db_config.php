<?php
    define('DB_USER', 'enterprise_user');
    define('DB_PASSWORD', 'enterprise!M8055');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'enterprise');

    $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        OR die('Could not connect to MySQL: ' . mysqli_connect_error());
    mysqli_set_charset($dbc, 'utf8');

    /* function prepare_string($dbc, $string) {
        $string = mysqli_real_escape_string($dbc, trim($string));
        return $string;
    } */
?>