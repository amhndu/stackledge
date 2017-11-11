<?php
session_start();

if ((isset($_POST['post']) || isset($_POST['comment']))
    && isset($_SESSION['username']) && isset($_POST['weight']))
{

    require_once('../php/connect.php');

    $table_name = isset($_POST['post']) ? 'PostVotes' : 'CommentVotes';
    $attrib_name = isset($_POST['post']) ? 'post_id' : 'comment_id';
    $id = (int) (isset($_POST['post']) ? $_POST['post'] : $_POST['comment']);

    $query = "SELECT weight FROM $table_name
              WHERE $attrib_name = ? AND username = ?";
    $stmt = $db_conn->prepare($query);
    $stmt->bind_param("is", $id, $_SESSION['username']);
    $stmt->execute();
    $stmt->bind_result($original_weight);
    $stmt->fetch();
    $stmt->close();

    $new_weight = (int) $_POST['weight'];
    if (empty($original_weight))
    {
        $query = "INSERT INTO $table_name VALUES (?, ?, ?)";
        $stmt = $db_conn->prepare($query);
        $stmt->bind_param('sii', $_SESSION['username'], $id, $new_weight);
        $result = $stmt->execute();
        $stmt->close();
    }
    else if ($new_weight == $original_weight)
    {
        $query = "DELETE FROM $table_name
                  WHERE $attrib_name = ? AND username = ?";
        $stmt = $db_conn->prepare($query);
        $stmt->bind_param('is', $id, $_SESSION['username']);
        $result = $stmt->execute();
        $stmt->close();
    }
    else
    {
        $query = "UPDATE $table_name
                  SET weight = ?
                  WHERE $attrib_name = ? AND username = ?";
        $stmt = $db_conn->prepare($query);
        $stmt->bind_param('iis', $new_weight, $id, $_SESSION['username']);
        $result = $stmt->execute();
        $stmt->close();
    }

    if ($result)
    {
        echo 'success ' . $id;
    }
    else
        echo 'failure ' . $id;
    $db_conn->close();
}
else
    echo 'invalid-request';
?>
