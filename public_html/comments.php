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

    function display_comment($cid, $db_conn)
    {
        $stmt = $db_conn->prepare('SELECT * FROM Comment where comment_id ='.$cid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $comment_owner = $row['owner'];
        $comment_vote  = $row['upvotes'] - $row['downvotes'];
        $comment_time  = human_timediff_from_mysql($row['submission_time']);
        $comment_text  = $row['text'];
        include("../templates/comment_template.php");

        $stmt = $db_conn->prepare('SELECT comment_id FROM Comment where parent_id ='.$cid);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc())
        {
            display_comment($row['comment_id'], $db_conn);
        }
        echo '</div>';

    }


    $stmt = $db_conn->prepare('SELECT comment_id FROM Comment where parent_id is NULL and post_id = ? ');
    $stmt->bind_param("i", $current_post);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc())
    {
        display_comment($row['comment_id'], $db_conn);
    }
?>

</body>
</html>

