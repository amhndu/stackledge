<div class="comments-container" style="width: 759px;">
  <div class="comments-list comment level1">
    <div class="cbox">
      <div class="tag"></div>
      <div class="info">
        <div class="name"><a href="user.php?u=<?php echo $post_owner?>"><?php echo $post_owner ?></a></div>
        <div class="vote">
          <div class="iconfont"><i class="fa fa-caret-up fa-lg" aria-hidden="true"></i></div>
          <div class="votes "><?php echo $post_vote?></div>
          <div class="iconfont"><i class="fa fa-caret-down fa-lg" aria-hidden="true"></i></div>
        </div>
        <div class="date"><?php echo $post_time?></div>
      </div>
      <div class="text">
        <div class="md">
          <p><?php echo post_comment?></p>
        </div>
      </div>
    </div>
  </div>
  <?php echo tail?>
</div>
