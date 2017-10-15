<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Headers Class
 *
 * This handles/organized all of the headers.
 *
 * @category   Framework
 * @package    DeviantFramework
 * @author     Mike Curry <mikecurry74@gmail.com>
 * @license    [MIT license](http://opensource.org/licenses/MIT)
 * @since      File available since Release 0.0.1
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

    // TODO: make return string, use '' instead of null
    public function getHeader(string $header)
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