<?php
    require('../php/header.php')
?>

<div class="posts">
<?php
    require_once('../php/connect.php');
    require_once('../php/feed.php');
    generate_feed($db_conn, FEED_ALL | (try_get("s") == "top" ? FEED_TOP : FEED_TRENDING));
    $db_conn->close();
?>
</div>

</body>
</html>
