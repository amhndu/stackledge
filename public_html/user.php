<?php
    require_once('../php/feed.php');
    $username = try_get("u");
    if (!empty($username))
        $content_heading = "User: $username";
    else
        $content_heading = "Error: no username argument";
    require_once('../php/header.php')
?>

<div class="posts">
<?php
    require_once('../php/connect.php');

    $stmt = $db_conn->prepare("SELECT SUM(upvotes - downvotes) as votes FROM Comment WHERE owner = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_comment);
    $stmt->fetch();
    $stmt->close();

    $stmt = $db_conn->prepare("SELECT SUM(upvotes - downvotes) as votes FROM Post WHERE owner = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_link);
    $stmt->fetch();
    $stmt->close();

    $stmt = $db_conn->prepare("SELECT join_date FROM User WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_joindate);
    $stmt->fetch();
    $stmt->close();

    $user_age = explode(' ', human_timediff_from_mysql($user_joindate));
    require('../templates/userinfo.php');

    if (!empty($username))
    {
        generate_feed($db_conn,
            FEED_USER | str_to_sort(try_get("s", "new")),
            $username);
    }

    $db_conn->close();
?>
</div>

</body>
</html>
