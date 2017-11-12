        <div class="comments-container" style="width: 759px;">
        <div class="comments-list comment level1">
        <div class="cbox">
        <div class="tag"></div>
        <div class="info">
            <div class="name"><a href="user.php?u=<?php echo $comment_owner?>"><?php echo $comment_owner ?></a></div>
            <div class="vote">
            <div class="iconfont"><i class="fa fa-caret-up fa-lg" aria-hidden="true"></i></div>
            <div class="votes "><?php echo $comment_vote?></div>
            <div class="iconfont"><i class="fa fa-caret-down fa-lg" aria-hidden="true"></i></div>
            </div>
            <div class="date"><?php echo $comment_time?></div>
        </div>
        <div class="text">
            <div class="md">
            <p><?php echo $comment_text?></p>
            </div>
        </div>
        </div>
        </div>



