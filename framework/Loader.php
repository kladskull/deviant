<?php declare(strict_types=1); // strict mode

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Loader Class
 *
 * This class contains utilities that load various parts of the
 * framework.
 *
 * @category   Framework
 * @package    DeviantFramework
 * @author     Mike Curry <mikecurry74@gmail.com>
 * @license    [MIT license](http://opensource.org/licenses/MIT)
 * @since      File available since Release 0.0.1
 */
class Loader
{
    /**
     * include_directory()
     * auto include PHP files by directory with caching
     *
     * TODO: Add caching? Maybe not... we could just use composer..
     * TODO: Replace this with Composer magic/include/functionality
     *
     * @param string      directory       The Directory to include
     * @param array       do_not_include  Any files to NOT include (optional)
     *
     * @return  bool        returns success
     * @throws  Exception   If directory doesn't exist.
     *
     */
    public static function includeDirectory(string $directory, array $do_not_include = []): bool
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
            return false;
        }
        return true;
    }
}