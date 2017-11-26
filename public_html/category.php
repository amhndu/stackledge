<?php
    require_once('../php/feed.php');
    $categ = try_get("c");
    if (!empty($categ))
        $content_heading = "$categ";
    else
        $content_heading = "Error: no categ argument";
    require_once('../php/header.php')
?>

<div class="posts">
<?php
    require_once('../php/connect.php');
    if (!empty($categ))
    {
        generate_feed($db_conn,
            FEED_CATEGORY | str_to_sort(try_get("s")),
            $categ);
    }
    $db_conn->close();
?>
</div>

<?php include_once('footer.php') ?>

</body>
</html>
