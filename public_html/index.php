<?php
    $content_heading = 'Front';
    require('../php/header.php')
?>

<div class="posts">
<?php
    require_once('../php/connect.php');
    require_once('../php/feed.php');
    generate_feed($db_conn, FEED_ALL | str_to_sort(try_get("s")));
    $db_conn->close();
?>
</div>

</body>
</html>
