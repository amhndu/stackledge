<?php
session_start();

if ((isset($_POST['post']) || isset($_POST['comment']))
    && isset($_SESSION['username']) && isset($_POST['weight']))
{
    require_once('../php/connect.php');
    $vote_success = false;
    $query = 'INSERT INTO ';

    if (isset($_POST['post']))
    {
        $query .= 'PostVotes';
        $id = (int) $_POST['post'];
    }
    else
    {
        $query .= 'CommentVotes';
        $id = (int) $_POST['comment'];
    }
    $query .= ' VALUES (?, ?, ?)';

    error_log($query);

    $stmt = $db_conn->prepare($query);
    $stmt->bind_param('sii', $_SESSION['username'], $id, (int) $_POST['weight']);
    if ($stmt->execute())
    {
        echo 'success';
    }
    else
        echo 'failure';
}
else
    echo 'invalid-request';

?>
