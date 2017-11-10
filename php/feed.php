<?php

define("FEED_ALL",       0);
define("FEED_CATEGORY",  1);
define("FEED_USER",      2);
define("FEED_TYPE_MASK", 3);

define("FEED_TRENDING",  0);
define("FEED_TOP",       4);

define("FEED_SORT_MASK", 4);

function human_timediff_from_mysql($mysqltime)
{
    $time = new DateTime($mysqltime);
    $interval = $time->diff(new DateTime());
    if ($interval->y > 0)
        return "$interval->y years ago";
    if ($interval->m > 0)
        return "$interval->m months ago";
    if ($interval->d > 0)
        return "$interval->d days ago";
    if ($interval->h > 0)
        return "$interval->h hours ago";
    if ($interval->i > 0)
        return "$interval->i minutes ago";
    return "just now";
}

function generate_feed($db_conn, $feed_flags, $opt_arg = null)
{
    $query = "SELECT title, url, upvotes, downvotes, owner, category, submission_time
              FROM Post ";

    switch($feed_flags & FEED_TYPE_MASK)
    {
    case FEED_ALL:
        $bound_arg = null;
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
    }

    if ($stmt = $db_conn->prepare($query))
    {
        if ($bound_arg)
        {
            $stmt->bind_param("s", $bound_arg);
        }
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($post_title, $post_url, $post_upvotes, $post_downvotes, $post_owner, $post_category, $post_timestamp);
        if ($stmt->num_rows > 0)
        {
            while ($stmt->fetch())
            {
                $post_votes = $post_upvotes - $post_downvotes;
                $post_time  = human_timediff_from_mysql($post_timestamp);
                $post_url_domain = parse_url($post_url)["host"];
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
        die("Cannnot prepare statement");
}

?>
