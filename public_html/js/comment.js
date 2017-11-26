function send_comment_root(post_id)
{   
    var container = document.getElementById('all-comments');
    if (container.getElementsByClassName('comments-container').length == 0)
    {
        container.innerHTML = "";
    }

    var comment = document.getElementById('root-comment-box').value;
    document.getElementById('root-comment-box').value = '';

    container.insertAdjacentHTML("afterbegin", "<div>posting the comment...</div>");
    var element = container.firstElementChild;
    send_comment(element, post_id, comment, null);
}

function expand_reply(button, post, cid)
{
    $(".send-comment").not("#root-send-comment").hide();

    var container = $(button).closest(".comments-container");
    var showreply = container.children(".showreply");
    showreply.show();

    showreply.html("<div class=\"send-comment\" style=\"\"> <div class=\"input-container\"><textarea style=\"height:46px; width:100%; overflow-y: hidden;\"></textarea></div> <div class=\"tools\"> <div class=\"format\"></div> <button class=\"button orange submit submit-comment\">post</button><button class=\"button orange submit cancel-comment\">cancel</button> <div class=\"commentsubmit-loader\"> </div> </div> <div class=\"clear\"></div> </div>");

    showreply.find(".cancel-comment").click(function(){
        showreply.hide();
    });

    showreply.find(".submit-comment").click(function(){
        showreply.hide();
        container[0].firstElementChild.insertAdjacentHTML("afterend", "<div>posting the comment...</div>");
        var comment = showreply.find("textarea")[0].value;
        showreply.find("textarea")[0].value = '';
        send_comment(container[0].children[1], post, comment, cid);
    });
}

function send_comment_data(data, element)
{
    //console.log("sending: ", data);
    var success_str = "success;" + data.post + ";";
    $.post('post_comment.php',
        data,
        function(data, _status)
        {
            //console.log(data, _status);
            if (_status == "success" && data.startsWith(success_str))
            {
                element.innerHTML = data.slice(success_str.length);
                //console.log(element.innerHTML);
            }
            else
            {
                element.innerHTML = "error sending the comment. <a href='javascript:void()'>retry</a>";
                element.getElementsByTagName('a')[0].onclick = function() { send_comment_data(data, element); };
                                    
            }
        }
    );
}

function send_comment(element, post_id, comment, parent_cid)
{
    data = {
        post: post_id,
        text: comment
    };

    if (parent_cid)
        data.parent_id = parent_cid;

    send_comment_data(data, element);
}
