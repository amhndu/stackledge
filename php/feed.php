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

function generate_feed($db_conn, $feed_flags, $opt_arg = null)
{
    $query = "SELECT title, url, upvotes, downvotes, owner, category, submission_time, num_comments
              FROM Post ";

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
        if ($bound_arg)
        {
            $stmt->bind_param("s", $bound_arg);
        }
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($post_title, $post_url, $post_upvotes, $post_downvotes,
                           $post_owner, $post_category, $post_timestamp, $post_num_comments);
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
        die("Cannnot prepare statement: " . $db_conn->error);
}

?>
