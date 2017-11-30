<div class='card'>
  <div class='card_left'>
    <img src='https://mini.s-shot.ru/74x74/PNG/74/Z100/?<?php echo $post_url?>' width="74px" height="74px" />
  </div>
  <div class='card_right'>
      <h1><a href="<?php echo $post_url?>"><?php echo $post_title?></a></h1>
      <div class="domain">(<a href="<?php echo '//'.$post_url_domain?>"><?php echo $post_url_domain?></a>)</div>
      <br />
    <small>
        By <a href="user.php?u=<?php echo $post_owner?>"><?php echo $post_owner ?></a> in
        <a href="category.php?c=<?php echo $post_category?>"><?php echo $post_category ?></a>
        <br />
        <a class="upvote" href="javascript:void(0)" onclick="<?php echo $post_upvote_href?>">
          <div class="vote <?php echo $post_upvoted_class?>">
            <i class="fa fa-caret-up fa-lg" aria-hidden="true"></i>
        </div></a>
        <span><?php echo $post_votes ?></span>
        <a class="downvote" href="javascript:void(0)" onclick="<?php echo $post_downvote_href?>">
          <div class="vote <?php echo $post_downvoted_class?>">
            <i class="fa fa-caret-down fa-lg" aria-hidden="true"></i>
          </div>
        </a>
        &nbsp;&nbsp;
        <a href="comments.php?p=<?php echo $post_id; ?>">
          <i class="fa fa-comments fa-lg" aria-hidden="true"></i>
          <?php echo $post_num_comments ?>
        </a> &nbsp;&nbsp;
        <a href="comments.php?p=<?php echo $post_id; ?>">Add Comment</a>&nbsp;&nbsp; <?php echo $post_time?>
    </small>
  </div>
</div>
