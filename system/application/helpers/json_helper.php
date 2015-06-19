<?php

/* 
 * Leogent Haromunthe
 * http://leogent.haromunthe.com
 * leogent@gmail.com
 */


if (!function_exists('json_decode')) {
    function json_decode($content, $assoc=false) {

        if ($assoc) {
            $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        }
        else {
            $json = new Services_JSON;
        }
        return $json->decode($content);
    }
}

if (!function_exists('json_encode')) {
    function json_encode($content) {
 
        $json = new Services_JSON;
        return $json->encode($content);
    }
}