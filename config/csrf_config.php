<?php declare(strict_types=1); // strict mode
/**
 * Configuration file for CSRF Protector
 */
return [
    'CSRFP_TOKEN' => '',
    'logDirectory' => '../log',
    'failedAuthAction' => [
        'GET' => 0,
        'POST' => 0,
    ],
    'errorRedirectionPage' => '',
    'customErrorMessage' => '',
    'jsPath' => '../js/csrfprotector.js',
    'jsUrl' => '/js/csrfprotector.js',
    'tokenLength' => 10,
    'secureCookie' => false,
    'disabledJavascriptMessage' => 'This site attempts to protect users against <a href=\'https://www.owasp.org/index.php/Cross-Site_Request_Forgery_%28CSRF%29\'>
    Cross-Site Request Forgeries </a> attacks. In order to do so, you must have JavaScript enabled in your web browser otherwise this site will fail to work correctly for you.
     See details of your web browser for how to enable JavaScript.',
    'verifyGetFor' => [],
];
