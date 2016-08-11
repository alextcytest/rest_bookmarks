<?php

namespace AppBundle\Service;



/**
 * Class UrlService
 * @package AppBundle\Service
 * @author Aleksey Tsymbaliuk <alex.tcy@outlook.com>
 */
class UrlService
{
    /**
     * @param string $url
     *
     * @return string
     */
    public function prepareHash($url)
    {
        return md5($this->cleanUrl($url));
    }

    /**
     * Remove `www` prefix from url string
     * @param $url
     *
     * @return string
     */
    private function cleanUrl($url)
    {
        $url = preg_replace('#^(http(s)?://)?w{3}\.#', '$1', $url);
        $url = rtrim($url, '/');

        return $url;
    }
}
