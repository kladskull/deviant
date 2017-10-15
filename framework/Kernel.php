<?php declare(strict_types=1); // strict mode

/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 9/28/17
 * Time: 7:27 PM
 */
class Kernel
{
    protected $app_version = '0.0.1';
    protected $base_path = '';
    public $currentUser = null;

    public function __construct()
    {
        $this->base_path = __FILE__;

        if (Auth::isLoggedIn()) {
            $this->currentUser = new User();
            $this->currentUser->load((int)$_SESSION['user_id']);
        }
    }

    public function basePath(): string
    {
        $last_slash = strrpos($this->base_path, DIRECTORY_SEPARATOR);
        $target_slash = strrpos($this->base_path, DIRECTORY_SEPARATOR, $last_slash - strlen($this->base_path) - 1);

        return substr($this->base_path, 0, $target_slash) . DIRECTORY_SEPARATOR;
    }

    public function version(): string
    {
        return $this->app_version;
    }

}