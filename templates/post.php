<div class='card'>
  <div class='card_left'>
    <img src='https://mini.s-shot.ru/74x74/PNG/74/Z100/?<?php echo $post_url?>' width="74px" height="74px" />
  </div>
  <div class='card_right'>
      <h1><a href="<?php echo $post_url?>"><?php echo $post_title?></a></h1>
      <div class="domain">(<a href="<?php echo $post_url_domain?>"><?php echo $post_url_domain?></a>)</div>
      <br />
    <small>
        By <a href="user.php?u=<?php echo $post_owner?>"><?php echo $post_owner ?></a> in
        <a href="category.php?c=<?php echo $post_category?>"><?php echo $post_category ?></a>
        <br />
        <a href="">
          <div class="vote">
            <i class="fa fa-caret-up fa-lg" aria-hidden="true"></i>
        </div></a>
        <?php echo $post_votes ?>
        <a href="">
          <div class="vote">
            <i class="fa fa-caret-down fa-lg" aria-hidden="true"></i>
          </div>
        </a>
        &nbsp;&nbsp; <a href=""><?php echo $post_num_comments ?> comments &nbsp;&nbsp; Add Comment</a>
        &nbsp;&nbsp; <?php echo $post_time?>
    </small>
  </div>
</div>
