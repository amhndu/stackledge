<?php

require_once('../php/config.php');

$db_conn = new mysqli($dbhost, $dbuser, $dbpass, $database);

if ($db_conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}


?>
