<?php

define("FEED_ALL",        0);
define("FEED_CATEGORY",   1);
define("FEED_USER",       2);
define("FEED_SELECT",     3);
define("FEED_TYPE_MASK",  3);

define("FEED_TRENDING",   0);
define("FEED_TOP",        4);
define("FEED_NEW",        8);

define("FEED_SORT_MASK", 12);

define("POSTS_PER_PAGE",  10);

require_once ('functions.php');

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
    case FEED_SELECT:
        $query .= "WHERE Post.post_id = ? ";
        $bound_arg = $opt_arg;
        break;
    }

    if (($feed_flags & FEED_TYPE_MASK) != FEED_SELECT)
    {
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
    }

    $query .= " LIMIT " . POSTS_PER_PAGE . " OFFSET ?";

    $page = (int) try_get("pg", "1");
    $offset = ($page - 1) * POSTS_PER_PAGE;

    if ($stmt = $db_conn->prepare($query))
    {
        if ($loggeduser && $bound_arg)
            $stmt->bind_param("ssi", $loggeduser, $bound_arg, $offset);
        else if ($loggeduser)
            $stmt->bind_param("si", $loggeduser, $offset);
        else if ($bound_arg)
            $stmt->bind_param("si", $bound_arg, $offset);
        else
            $stmt->bind_param("i", $offset);

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

        echo '<div class="page-nav-wrap">
				<div class="page-nav">';
        if ($page > 1)
            echo "<a href='" . set_GET_parameter("pg", (string) ($page - 1)) . "'><div class=\"direction prev\" style=\"display: block;\">
																				<i class=\"icon fa fa-angle-left fa-2x\" aria-hidden=\"true\"></i>
																				<div class=\"label\">PREVIOUS</div>
																				</div></a>";
        if ($stmt->num_rows == POSTS_PER_PAGE)
            echo "<a href='" . set_GET_parameter("pg", (string) ($page + 1)) . "'><div class=\"direction next\" style=\"display: block;\">
																				<i class=\"icon fa fa-angle-right fa-2x\" aria-hidden=\"true\"></i>
																				<div class=\"label\">NEXT</div>
																				</div></a>";
        echo '</div></div>';

        $stmt->free_result();
    }
    else
        die("Cannnot prepare statement: " . $db_conn->error);
}

?>
