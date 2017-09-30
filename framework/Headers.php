<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/28/17
 * Time: 8:31 PM
 */

class Headers
{
    protected $headers = [];

    public function __construct()
    {

    }

    public function addHeader($header, $data): bool
    {
        $this->headers[trim($header)] = trim($data);
        return true;
    }

    public function addHeaders($headers): bool
    {
        foreach ($headers as $header => $data) {
            $this->headers[trim($header)] = trim($data);
        }
        return true;
    }

    public function getHeader(string $header): string
    {
        $header_data = null;
        if (!empty($this->headers[$header])) {
            $header_data = $this->headers[$header];
        }
        return $header_data;
    }

    public function removeHeader(string $header): bool
    {
        if (!empty($this->headers[$header])) {
            unset($this->headers[$header]);
        }

        return true;
    }

    public function outputHeaders(): bool
    {
        foreach ($this->headers as $header => $header_data) {
            header($header . ': ' . $header_data);
        }

        return true;
    }
}