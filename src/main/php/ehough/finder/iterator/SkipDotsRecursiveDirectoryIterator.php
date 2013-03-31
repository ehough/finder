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
 * Extends the \RecursiveDirectoryIterator to support relative paths
 *
 * @author Victor Berchet <victor@suumit.com>
 */
class ehough_finder_iterator_SkipDotsRecursiveDirectoryIterator extends RecursiveDirectoryIterator
{
    /**
     * Return an instance of SplFileInfo with support for relative paths
     *
     * @return SplFileInfo File information
     */
    public function current()
    {
        return new ehough_finder_SplFileInfo(parent::current()->getPathname(), $this->getSubPath(), $this->getSubPathname());
    }

    /**
     * @return mixed object
     *
     * @throws (ehough_finder_exception_AccessDeniedException
     */
    public function getChildren()
    {
        try {
            return parent::getChildren();
        } catch (UnexpectedValueException $e) {
            throw new ehough_finder_exception_AccessDeniedException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function next()
    {
        parent::next();

        while ($this->isDot()) {

            parent::next();
        }
    }

    public function getPathname()
    {
        $pathName = parent::getPathname();

        if ($this->_endsWithSlash($pathName)) {

            return substr($pathName, 0, strlen($pathName) - 1);
        }

        return $pathName;
    }

    private function _endsWithSlash($path)
    {
        if (! is_dir($path)) {

            return false;
        }

        $length = strlen(DIRECTORY_SEPARATOR);
        if ($length == 0) {
            return true;
        }

        return (substr($path, -$length) === DIRECTORY_SEPARATOR);
    }
}
