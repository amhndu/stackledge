<?php

function time_helper($n, $str)
{
    $str = "$n $str";
    if ($n != 1) $str .= 's';
    return $str . " ago";
}

function human_timediff_from_mysql($mysqltime)
{
    $time = new DateTime($mysqltime);
    $interval = $time->diff(new DateTime());
    if ($interval->y > 0)
        return time_helper($interval->y, "year");
    if ($interval->m > 0)
        return time_helper($interval->m, "month");
    if ($interval->d > 0)
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


?>
