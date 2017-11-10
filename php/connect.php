<?php

require_once('config.php');

$db_conn = new mysqli($dbhost, $dbuser, $dbpass, $database);

if ($db_conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}


?>
