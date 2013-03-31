<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Extends SplFileInfo to support relative paths
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ehough_finder_SplFileInfo extends SplFileInfo
{
    private $relativePath;
    private $relativePathname;

    /**
     * Constructor
     *
     * @param string $file             The file name
     * @param string $relativePath     The relative path
     * @param string $relativePathname The relative path name
     */
    public function __construct($file, $relativePath, $relativePathname)
    {
        parent::__construct($file);
        $this->relativePath = $relativePath;
        $this->relativePathname = $relativePathname;
    }

    /**
     * Returns the relative path
     *
     * @return string the relative path
     */
    public function getRelativePath()
    {
        return $this->relativePath;
    }

    /**
     * Returns the relative path name
     *
     * @return string the relative path name
     */
    public function getRelativePathname()
    {
        return $this->relativePathname;
    }

    /**
     * Returns the contents of the file
     *
     * @return string the contents of the file
     *
     * @throws RuntimeException
     */
    public function getContents()
    {
        $level = error_reporting(0);
        $content = file_get_contents($this->getRealpath());
        error_reporting($level);
        if (false === $content) {
            $error = error_get_last();
            throw new RuntimeException($error['message']);
        }

        return $content;
    }

    public function getPathname()
    {
        $pathName = parent::getPathname();

        if (version_compare(PHP_VERSION, '5.3') < 0 && $this->_endsWithSlash($pathName)) {

            return substr($pathName, 0, strlen($pathName) - 1);
        }

        return $pathName;
    }

    private function _endsWithSlash($path)
    {
        $length = strlen(DIRECTORY_SEPARATOR);
        if ($length == 0) {
            return true;
        }

        return (substr($path, -$length) === DIRECTORY_SEPARATOR);
    }
}
