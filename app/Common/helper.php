<?php

function prx($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";

}

function replaceStr($str)
{
    return (preg_replace('/\s+/', '_', $str));
}