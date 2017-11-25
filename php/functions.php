<?php

function time_helper($n, $str)
{
    $str = "$n $str";
    if ($n != 1) $str .= 's';
    return $str . " ago";
}

function human_timediff_from_mysql($mysqltime, $day = false)
{
    $time = new DateTime($mysqltime);
    $interval = $time->diff(new DateTime());
    if ($interval->y > 0)
        return time_helper($interval->y, "year");
    if ($interval->m > 0)
        return time_helper($interval->m, "month");
    if ($interval->d > 0 || $day)
        return time_helper($interval->d, "day");
    if ($interval->h > 0)
        return time_helper($interval->h, "hour");
    if ($interval->i > 0)
        return time_helper($interval->i, "minute");
    return "just now";
}

function try_get($param, $default = "")
{
    if (isset($_GET[$param]))
        return $_GET[$param];
    return $default;
}

function set_GET_parameter($param, $value)
{
    $url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $url_parts = parse_url($url);

    $params = [];
    if (isset($url_parts['query']))
        parse_str($url_parts['query'], $params);

    $params[$param] = $value;     // Overwrite if exists

    $url_parts['query'] = http_build_query($params);

    return '//' . $url_parts['host'] . $url_parts['path'] . '?' . $url_parts['query'];
}


?>
