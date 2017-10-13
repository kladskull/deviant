<?php
/**
 * Created by PhpStorm.
 * User: mcurry
 * Date: 10/13/17
 * Time: 1:49 PM
 */

class Loader
{
    /**
     * include_directory()
     * auto include PHP files by directory with caching
     *
     * TODO: Replace this with Composer magic/include/functionality
     *
     * @param   string      directory       The Directory to include
     * @param   array       do_not_include  Any files to NOT include (optional)
     *
     * @throws  Exception   If directory doesn't exist.
     *
     * @return  bool        returns success
     */
    public static function includeDirectory(string $directory, array $do_not_include = [])
    {
        if (file_exists($directory)) {
            $include_data = [];
            $iterator = new DirectoryIterator($directory);
            foreach ($iterator as $file_info) {
                if ($file_info->isFile() && !in_array($file_info->getFilename(), $do_not_include, true)) {
                    include($directory . DIRECTORY_SEPARATOR . $file_info->getFilename());
                }
            }
        } else {
            throw new Exception($directory . ' does not exist or is inaccessible.');
        }
    }
}