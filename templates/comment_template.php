        <div class="comments-container" style="width: 759px;">
            <div class="comments-list comment level1">
                <div class="cbox">
                    <div class="tag"></div>
                    <div class="info">
                        <div class="name"><a href="user.php?u=<?php echo $comment_owner?>"><?php echo $comment_owner ?></a></div>
                        <div class="vote">
                        <a class="upvote" href="javascript:void(0)" onclick="<?php echo $comment_upvote_href?>">
                            <div class="iconfont <?php echo $comment_upvoted_class?>">
                                    <i class="fa fa-caret-up fa-lg" aria-hidden="true"></i></div>
                        </a>
                        <div class="votes"><span><?php echo $comment_vote?></span></div>
                        <a class="downvote" href="javascript:void(0)" onclick="<?php echo $comment_downvote_href?>">
                            <div class="iconfont <?php echo $comment_downvoted_class?>">
                                    <i class="fa fa-caret-down fa-lg" aria-hidden="true"></i></div>
                        </a>
                        </div>
                        <div class="date"><?php echo $comment_time?></div>
                        <div class="reply"><a href="javascript:void(0)" onclick="
                                        <?php echo $comment_reply_href ?>">reply</a></div>
                    </div>
                    <div class="text">
                        <div class="md">
                        <p><?php echo $comment_text?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="showreply"></div>

