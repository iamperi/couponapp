<?php

if(!function_exists('couponCode')) {
    function generateCode($prefix) {
        return $prefix . substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
    }
}

if(!function_exists('fakeDni')) {
    function fakeDni() {
        $number = rand(11111111, 99999999);
        $letter = substr("TRWAGMYFPDXBNJZSQVHLCKE", strtr($number, "XYZ", "012") % 23, 1);
        return "$number$letter";
    }
}
