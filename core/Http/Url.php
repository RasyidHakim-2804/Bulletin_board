<?php

namespace Core\Http;

class Url
{
    public function getBaseUrl()
    {
        $uri = preg_replace('/\/++/', '/', $_SERVER['REQUEST_URI']);
        $protocol = $this->getProtocol();
        $baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $uri;

        return $baseUrl;
    }

    public function getPath()
    {
        $uri = preg_replace('/\/++/', '/', $_SERVER['REQUEST_URI']);

        //membersihkan url dari nama domain
        $uri = str_replace($_ENV['DOMAIN'], '', $uri);

        /**
         * Memeriksa apakah URI setelah dibersihkan bukan merupakan tanda garis miring tunggal (/). 
         * Jika itu bukan (/), maka fungsi rtrim digunakan untuk menghapus tanda garis miring di ujung 
         * kanan URI.
         */
        if ($uri !== '/') $uri = rtrim($uri, '/');

        /**
         * Menggunakan fungsi parse_url untuk mem-parsing URI yang telah dibersihkan menjadi
         * komponen-komponen seperti skema, host, path, dan sebagainya.
         */
        $uri = parse_url($uri);

        return $uri['path'] ?? $uri;
    }

    public function getProtocol()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    }

    public function getScheme()
    {
        return parse_url($this->getBaseUrl())['scheme'];
    }

    public function getHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    public function getQuery()
    {
        return parse_url($this->getBaseUrl())['query'] ?? null;
    }
}
