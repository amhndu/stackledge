function make_red(element, id)
{
    element.getElementsByTagName('div')[0].classList.add('red');
}

function make_nored(element, id)
{
    element.getElementsByTagName('div')[0].classList.remove('red');
}

function is_red(element)
{
    return element.getElementsByTagName('div')[0].classList.contains('red');
}

function get_other(element)
{
    return element.parentElement.getElementsByClassName(element.classList.contains('upvote') ? 'downvote' : 'upvote')[0];
}

function sendPostVote(id, weight, element)
{
    // disable the buttons until we hear back from the server
    var element_cb = element.onclick,
        other_cb   = get_other(element).onclick;

    element.onclick = function() { return 0; };
    get_other(element).onclick = function() { return 0; };

    $.post('vote.php',
        {
            post: id,
            weight: weight
        },
        function(data, status)
        {
            console.log(data, status);
            if (status == "success")
            {
                data = data.split(' ');
                if (data[0] == 'success' && data[1] == id)
                {
                    if (is_red(element) && !is_red(get_other(element)))
                    {
                        make_nored(element, id);
                        make_nored(get_other(element), id);
                    }
                    else
                    {
                        make_red(element, id);
                        make_nored(get_other(element), id);
                    }
                }
            }
            // set back the cbs
            element.onclick = element_cb;
            get_other(element).onclick = other_cb;
        }
    );
    return false;
}
