<?php session_start();

//     if(!isset($_SESSION['username']))
//         header('Location: index.php');

    require_once('../php/connect.php');
    require_once('../php/functions.php');

    $current_post = try_get('p');
    if (!empty($current_post))
        $content_heading = 'Comments';
    else
        $content_heading = 'Error: comment argument required';
    $hide_sort = true;
    require('../php/header.php');

    $loggeduser = null;
    if (isset($_SESSION['username']))
        $loggeduser = $_SESSION['username'];


    function display_comment($cid, $db_conn)
    {
        $cid = (int) $cid;
        global $current_post;
        global $loggeduser;
        if (!$loggeduser)
            $query = "SELECT Comment.* FROM Comment where comment_id= ?";
        else
            $query = "SELECT Comment.*, IFNULL(CommentVotes.weight, 0) as voted
                      FROM Comment LEFT JOIN CommentVotes
                      ON (Comment.comment_id = CommentVotes.comment_id AND CommentVotes.username = ?)
                      WHERE Comment.comment_id = ?";
        $stmt = $db_conn->prepare($query);
        if ($loggeduser)
            $stmt->bind_param("si", $loggeduser, $cid);
        else
            $stmt->bind_param("i", $cid);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $comment_owner = $row['owner'];
        $comment_vote  = $row['upvotes'] - $row['downvotes'];
        $comment_time  = human_timediff_from_mysql($row['submission_time']);
        $comment_text  = $row['text'];

        $comment_upvoted_class = $comment_downvoted_class = '';
        if (isset($row['voted']))
        {
            $vote = $row['voted'];
            if ($vote > 0)
                $comment_upvoted_class = 'red';
            else if ($vote < 0)
                $comment_downvoted_class = 'red';
        }

        if ($loggeduser)
        {
            $comment_upvote_href = "return sendCommentVote($cid, 1, this)";
            $comment_downvote_href = "return sendCommentVote($cid, -1, this)";
            $comment_reply_href = "expand_reply(this, $current_post, $cid)";
        }
        else
        {
            $comment_reply_href = $comment_upvote_href = $comment_downvote_href = "openLoginModal();
                                                       shakeModal('You need to be logged in to do this!');
                                                       return false;";
        }

        include("../templates/comment_template.php");
        $stmt->close();

        $stmt = $db_conn->prepare('SELECT comment_id FROM Comment where parent_id = ?');
        $stmt->bind_param("i", $cid);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc())
        {
            display_comment($row['comment_id'], $db_conn);
        }
        echo '</div>';

    }


    require_once('../php/feed.php');
    generate_feed($db_conn, FEED_SELECT, $current_post);
    echo '<br><br>';

    $comment_submit_href = "openLoginModal();
                               shakeModal('You need to be logged in to do this!');
                               return false;";
    if ($loggeduser)
        $comment_submit_href = "send_comment_root($current_post)";
    require('../templates/comment_box.php');
    echo '<br>';


    $stmt = $db_conn->prepare('SELECT comment_id FROM Comment where parent_id is NULL and post_id = ? ');
    $stmt->bind_param("i", $current_post);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<script src="js/comment.js" type="text/javascript"></script>';
    echo '<div id="all-comments">';
    if ($result->num_rows == 0)
        echo 'No comments yet';
    while($row = $result->fetch_assoc())
    {
        display_comment($row['comment_id'], $db_conn);
    }
    echo '</div>';
?>

<?php include_once('footer.php') ?>

</body>
</html>

