<?php

defined('__IN_SCRIPT__') || exit(1);

function get($key, $default = null)
{
    $val = $_GET[$key] ?? $default;

    $val = htmlspecialchars_decode($val);
    $val = strip_tags($val);

    return $val;
}
