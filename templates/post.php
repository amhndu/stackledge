<div class='card'>
  <div class='card_left'>
    <img src='https://mini.s-shot.ru/74x74/PNG/74/Z100/?<?php echo $post_url?>' width="74px" height="74px" />
    <!-- http://www.google.com/s2/favicons?domain= -->
  </div>
  <div class='card_right'>
      <h1><a href="<?php echo $post_url?>"><?php echo $post_title?></a></h1>
      <div class="domain">(<a href="<?php echo $post_url_domain?>"><?php echo $post_url_domain?></a>)</div>
      <br />
    <small>
        By <a href=""><?php echo $post_owner ?> </a> in
        <a href=""><?php echo $post_category ?></a>
        <br />
        <a href=""><div class="upvote">
        </div></a>
        <?php echo $post_votes ?>
        <a href=""><div class="downvote"></div></a>
        &nbsp;&nbsp; <a href="">X comments &nbsp;&nbsp; Add Comment</a>
        &nbsp;&nbsp; <?php echo $post_time?>
    </small>
  </div>
</div>
