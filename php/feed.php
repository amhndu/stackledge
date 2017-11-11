<?php

define("FEED_ALL",        0);
define("FEED_CATEGORY",   1);
define("FEED_USER",       2);
define("FEED_TYPE_MASK",  3);

define("FEED_TRENDING",   0);
define("FEED_TOP",        4);
define("FEED_NEW",        8);

define("FEED_SORT_MASK", 12);

function time_helper($n, $str)
{
    $str = "$n $str";
    if ($n != 1) $str .= 's';
    return $str . " ago";
}

function str_to_sort($str)
{
    switch($str)
    {
        case "top": return FEED_TOP;
        case "new": return FEED_NEW;
        case "trend": return FEED_TRENDING;
    }
    return FEED_TRENDING;
}

function human_timediff_from_mysql($mysqltime)
{
    $time = new DateTime($mysqltime);
    $interval = $time->diff(new DateTime());
    if ($interval->y > 0)
        return time_helper($interval->y, "year");
    if ($interval->m > 0)
        return time_helper($interval->m, "month");
    if ($interval->d > 0)
        return time_helper($interval->d, "day");
    if ($interval->h > 0)
        return time_helper($interval->h, "hour");
    if ($interval->i > 0)
        return time_helper($interval->i, "minute");
    return "just now";
}

function try_get($param, $default = "")
{
    if (isset($_GET[$param]))
        return $_GET[$param];
    return $default;
}

// TODO Pagination
function generate_feed($db_conn, $feed_flags, $opt_arg = null)
{

    $loggeduser = null;
    if (isset($_SESSION['username']))
        $loggeduser = $_SESSION['username'];

    $query = "SELECT Post.post_id, Post.title, Post.url, Post.upvotes, Post.downvotes,
                     Post.owner, Post.category, Post.submission_time, Post.num_comments";
    if (!empty($loggeduser))
        $query .= ", IFNULL(PostVotes.weight, 0)
        FROM Post LEFT JOIN PostVotes
        ON (Post.post_id = PostVotes.post_id AND PostVotes.username = ?)";
    else
        $query .= " FROM Post ";


    $bound_arg = null;
    switch($feed_flags & FEED_TYPE_MASK)
    {
    case FEED_ALL:
        break;
    case FEED_CATEGORY:
        $query .= "WHERE category = ? ";
        $bound_arg = $opt_arg;
        break;
    case FEED_USER:
        $query .= "WHERE owner = ? ";
        $bound_arg = $opt_arg;
        break;
    }

    switch($feed_flags & FEED_SORT_MASK)
    {
    case FEED_TRENDING:
        $query .= " ORDER BY ((upvotes - downvotes - 1) / POW(now() - submission_time, 1.8)) DESC";
        break;
    case FEED_TOP:
        $query .= " ORDER BY (upvotes - downvotes) DESC";
        break;
    case FEED_NEW:
        $query .= " ORDER BY submission_time DESC";
        break;
    }

    if ($stmt = $db_conn->prepare($query))
    {
        if ($loggeduser && $bound_arg)
            $stmt->bind_param("ss", $loggeduser, $bound_arg);
        else if ($loggeduser)
            $stmt->bind_param("s", $loggeduser);
        else if ($bound_arg)
            $stmt->bind_param("s", $bound_arg);

        $stmt->execute();
        $stmt->store_result();

        if ($loggeduser)
            $stmt->bind_result($post_id, $post_title, $post_url, $post_upvotes, $post_downvotes,
                               $post_owner, $post_category, $post_timestamp, $post_num_comments,
                               $post_cur_voted);
        else
            $stmt->bind_result($post_id, $post_title, $post_url, $post_upvotes, $post_downvotes,
                               $post_owner, $post_category, $post_timestamp, $post_num_comments);

        if ($stmt->num_rows > 0)
        {
            while ($stmt->fetch())
            {
                $post_votes = $post_upvotes - $post_downvotes;
                $post_time  = human_timediff_from_mysql($post_timestamp);
                if(array_key_exists("host", parse_url($post_url)))
                    $post_url_domain = parse_url($post_url)["host"];
                else
                    $post_url_domain = '';

                $post_upvoted_class   = '';
                $post_downvoted_class = '';

                if (isset($post_cur_voted) && $post_cur_voted > 0)
                    $post_upvoted_class = 'red';
                if (isset($post_cur_voted) && $post_cur_voted < 0)
                    $post_downvoted_class = 'red';

                if ($loggeduser)
                {
                    $post_upvote_href = "return sendPostVote($post_id, 1, this)";
                    $post_downvote_href = "return sendPostVote($post_id, -1, this)";
                }
                else
                {
                    $post_upvote_href = $post_downvote_href = "openLoginModal();
                                                               shakeModal('You need to be logged in to do this!');
                                                               return false;";
                }

                require("../templates/post.php");
            }
        }
        else
        {
            echo "Nothing interesting to see here.<br>";
            if ($db_conn->errno) echo $db_conn->error;
        }
        $stmt->free_result();
    }
    else
        die("Cannnot prepare statement: " . $db_conn->error);
}

?>
