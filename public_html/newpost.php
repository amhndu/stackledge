<?php
    session_start();

    if(!isset($_SESSION['username']) || isset($_POST['logout']))
    {
        $_SESSION['login-prompt'] = true;
        header('Location: index.php');
    }

    $content_heading = 'New Post';
    $hide_sort = true;
    require('../php/header.php');

    require('../templates/newpost_template.php');
?>
<?php include_once('footer.php') ?>
</body>
</html>
