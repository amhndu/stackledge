<?php

session_start();

$loggedin = isset($_SESSION['username']);

if ($loggedin) // already logged in
{
    $content_heading = 'Already logged in';
    require('../php/header.php');
}
else if(!$loggedin && isset($_POST['username']) && isset($_POST['password'])) // ie. login attempt
{
    require('../php/connect.php');
    $stmt = $db_conn->prepare('SELECT passhash FROM User Where username = ?');
    $stmt->bind_param("s", $_POST['username']);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1)
    {
        $row = $result->fetch_array(MYSQLI_NUM);

        $_POST['password'] = str_replace(PHP_EOL, '', $_POST['password']);

        if($row[0] == hash('sha256', $_POST['password']))
        {
            $_SESSION['username'] = $_POST['username'];
        }
        else
        {
            $_SESSION['loginfailed'] = true;
        }
    }
    else
    {
        $_SESSION['loginfailed'] = true;
    }

    $stmt->close();

    if (isset($_POST['location']))
        header('Location: ' . $_POST['location']);
    else
        header('Location: index.php');
}

?>
