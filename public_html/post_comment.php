<?php

session_start();

if (isset($_SESSION['username']) && isset($_POST['post']) && isset($_POST['text']))
{
    require_once('../php/connect.php');
    require_once('../php/functions.php');
    
    $query = "insert into Comment (text, submission_time, owner, post_id, parent_id) values (?, ?, ?, ?, ?)";
    $stmt = $db_conn->prepare($query);

    $parent_comment = null;
    $datetime = date('Y-m-d H:i:s');

    if (isset($_POST['parent_id']))
        $parent_comment = $_POST['parent_id'];

    $stmt->bind_param("sssii",
        $_POST['text'],
        $datetime,
        $_SESSION['username'],
        $_POST['post'],
        $parent_comment);

    $result = $stmt->execute();
    if ($result)
    {
        echo 'success;' . $_POST['post'] . ';';
        $comment_owner = $_SESSION['username'];
        $comment_vote  = 0;
        $comment_time  = human_timediff_from_mysql($datetime);
        $comment_text  = $_POST['text'];

        $comment_upvoted_class = $comment_downvoted_class = '';
        $comment_upvote_href = "return sendCommentVote(" . $_POST['post'] . ", 1, this)";
        $comment_downvote_href = "return sendCommentVote(" . $_POST['post'] . ", -1, this)";
        $comment_reply_href = "expand_reply(this, " . $_POST['post'] . ", ". $stmt->insert_id . ")";
        include("../templates/comment_template.php");
    }
    else
        echo 'failure;' . $_POST['post'];
}
else
    echo 'invalid-request';


?>
