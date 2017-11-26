<?php
    require_once('../php/feed.php');
    require_once('../php/connect.php');
    $username = try_get("u");
    if (!empty($username))
    {
    	$stmt = $db_conn->prepare("SELECT username FROM User WHERE username = ?");
    	$stmt->bind_param("s", $username);
    	$stmt->execute();
		$stmt->store_result();
		if(!$stmt->num_rows)
			{ $username = ''; $content_heading = 'Error: the username does not exist'; }
		else
			$content_heading = "$username";
    	$stmt->close();
    	require_once('../php/header.php');
    }    
    else
        $content_heading = "Error: no username argument";
    require_once('../php/header.php');
?>

<div class="posts">
<?php
    require_once('../php/connect.php');

    if (!empty($username))
    {

        $stmt = $db_conn->prepare("SELECT IFNULL(SUM(upvotes - downvotes), 0) as votes FROM Comment WHERE owner = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($user_comment);
        $stmt->fetch();
        $stmt->close();

        $stmt = $db_conn->prepare("SELECT IFNULL(SUM(upvotes - downvotes), 0) as votes FROM Post WHERE owner = ?");
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

        $user_age = explode(' ', human_timediff_from_mysql($user_joindate, true));
        require('../templates/userinfo.php');

        generate_feed($db_conn,
            FEED_USER | str_to_sort(try_get("s", "new")),
            $username);
    }

    $db_conn->close();
?>
</div>
<?php include_once('footer.php') ?>
</body>
</html>
