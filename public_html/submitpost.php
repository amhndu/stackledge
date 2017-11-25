<?php

	session_start();

    if (!isset($_SESSION['username']))
    {
        $_SESSION['login-prompt'] = true;
        header('Location: index.php');
    }
    else if (isset($_POST['url']) && isset($_POST['category']) && isset($_POST['title']))
    {
        if(isset($_SESSION['Posterror'])) echo 'error posting';
        require('../php/connect.php');

        $stmt = $db_conn->prepare('INSERT INTO Post(url, submission_time, upvotes, downvotes, owner, category, title) values(?, ?, ?, ?, ?, ?, ?)');

        $url = $_POST['url'];
        $datetime = date('Y-m-d H:i:s');
        $uv = 0;
        $dv = 0;
        $owner = $_SESSION['username'];
        $category = $_POST['category'];
        $title = $_POST['title'];

        $stmt->bind_param("ssiisss", $url, $datetime, $uv, $dv, $owner, $category, $title);
        $stmt->execute();

        if($stmt->affected_rows == 1)
        {
            header('Location: user.php?u='.$_SESSION['username']);
        }
    }


?>
