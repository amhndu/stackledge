<!doctype html>
<html>
    <head>
        <title>Stackledge - The stack of knowledge</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
<body>

<div>
<?php
    // require_once(index_header.php)
    require_once('../php/connect.php');
    require_once('../php/feed.php');
    generate_feed($db_conn, FEED_ALL | FEED_TRENDING);
    $db_conn->close();
?>
</div>

</body>
</html>
