<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 10/18/17
 * Time: 8:14 PM
 */

namespace Deviant\Framework;

class Route
{
    protected bool $sslEnabled;

    public function __construct()
    {
        // initialize CSRF?
        if (!defined(CSRF_INITIALIZED)) {
            // initialize CSRF protection
            //csrfProtector::init();
            define('CSRF_INITIALIZED', true);
        }

        // is this request SSL?
        if (!defined(SSL_INITIALIZED)) {
            if (Http::isSSL()) {
                define('SSL_INITIALIZED', true);
            } else {
                define('SSL_INITIALIZED', false);
            }
        }
    }

    /**
     * @return mixed
     */
    protected function getSslEnabled(): bool
    {
        return $this->sslEnabled;
    }

    /**
     * @param mixed $sslEnabled
     */
    protected function setSslEnabled(bool $sslEnabled): void
    {
        $this->sslEnabled = $sslEnabled;
    }


}