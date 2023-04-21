<?php

if (! function_exists('convertBytesToMB')) {
    function convertBytesToMB($size) {
        $sizeMB=number_format($size / 1024 / 1024,2);
        return (float)$sizeMB;
    }
}