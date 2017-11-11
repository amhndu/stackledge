<?php

session_start();

$loggedin = isset($_SESSION['username']);

if ($loggedin) // already logged in
{
    require('../php/header.php');
}
else if(!$loggedin && isset($_POST['username']) && isset($_POST['password'])) // ie. login attempt
{
    require('../php/connect.php');		
    $stmt = $db_conn->prepare('SELECT passhash FROM User Where username = ?');
    $stmt->bind_param("s", $_POST['username']);

    $stmt->execute(); 
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_NUM);

    $_POST['password'] = str_replace(PHP_EOL, '', $_POST['password']);

    file_put_contents('php://stderr', "trying to loging");
    if($row[0] == hash('sha256', $_POST['password']))
    {
        $_SESSION['username'] = $_POST['username'];
        file_put_contents('php://stderr', print_r($_SESSION, TRUE));
    }
    else
    {
        $_SESSION['loginfailed'] = true;
    }
    $stmt->close();
    header('Location: index.php');
}

?>
