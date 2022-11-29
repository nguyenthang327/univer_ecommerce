<?php

namespace App\Helpers;

class RequestHelper
{
    /**
     * Remove parameters of request
     *
     * @param $url
     * @return mixed|string
     */
    public function parseRequestUri($url) {
        return explode('?', $url)[0];
    }
}