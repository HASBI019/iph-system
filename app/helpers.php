<?php

if (!function_exists('formatPresisi')) {
    function formatPresisi($angka) {
        if (is_null($angka)) return '';
        return rtrim(rtrim((string)$angka, '0'), '.');
    }
}
