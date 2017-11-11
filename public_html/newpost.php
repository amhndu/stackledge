<?php
    session_start();

    if(!isset($_SESSION['username']))
        header('Location: index.php');

    $content_heading = 'New Post';
    $hide_sort = true;
    require('../php/header.php');

    require('../templates/newpost_template.php');
?>

</body>
</html>
