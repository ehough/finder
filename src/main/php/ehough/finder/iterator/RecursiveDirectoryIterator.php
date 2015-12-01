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
 * Extends the \RecursiveDirectoryIterator to support relative paths.
 *
 * @author Victor Berchet <victor@suumit.com>
 */
class ehough_finder_iterator_RecursiveDirectoryIterator extends RecursiveDirectoryIterator
{
    /**
     * @var bool
     */
    private $ignoreUnreadableDirs;

    /**
     * @var bool
     */
    private $rewindable;

    /**
     * Constructor.
     *
     * @param string $path
     * @param int    $flags
     * @param bool   $ignoreUnreadableDirs
     *
     * @throws RuntimeException
     */
    public function __construct($path, $flags = 0, $ignoreUnreadableDirs = false)
    {
        if ($flags & (self::CURRENT_AS_PATHNAME | self::CURRENT_AS_SELF)) {
            throw new RuntimeException('This iterator only support returning current as fileinfo.');
        }

        @parent::__construct($path, $flags);
        $this->ignoreUnreadableDirs = $ignoreUnreadableDirs;
    }

    /**
     * Return an instance of SplFileInfo with support for relative paths.
     *
     * @return SplFileInfo File information
     */
    public function current()
    {
        return new ehough_finder_SplFileInfo(parent::current()->getPathname(), $this->getSubPath(), $this->getSubPathname());
    }

    /**
     * @return RecursiveIterator
     *
     * @throws (ehough_finder_exception_AccessDeniedException
     */
    public function getChildren()
    {
        try {
            $children = parent::getChildren();

            if ($children instanceof self) {
                // parent method will call the constructor with default arguments, so unreadable dirs won't be ignored anymore
                $children->ignoreUnreadableDirs = $this->ignoreUnreadableDirs;
            }

            return $children;
        } catch (UnexpectedValueException $e) {
            if ($this->ignoreUnreadableDirs) {
                // If directory is unreadable and finder is set to ignore it, a fake empty content is returned.
                return new RecursiveArrayIterator(array());
            } else {

                if (version_compare(PHP_VERSION, '5.3') >= 0) {

                    throw new ehough_finder_exception_AccessDeniedException($e->getMessage(), $e->getCode(), $e);
                }

                throw new ehough_finder_exception_AccessDeniedException($e->getMessage(), $e->getCode());
            }
        }
    }

    /**
     * Do nothing for non rewindable stream.
     */
    public function rewind()
    {
        if (false === $this->isRewindable()) {
            return;
        }

        // @see https://bugs.php.net/bug.php?id=49104
        parent::next();

        parent::rewind();

        $this->skipdots();
    }

    /**
     * Checks if the stream is rewindable.
     *
     * @return bool true when the stream is rewindable, false otherwise
     */
    public function isRewindable()
    {
        if (null !== $this->rewindable) {
            return $this->rewindable;
        }

        if (false !== $stream = @opendir($this->getPath())) {
            $infos = stream_get_meta_data($stream);
            closedir($stream);

            if ($infos['seekable']) {
                return $this->rewindable = true;
            }
        }

        return $this->rewindable = false;
    }

    public function next() {

        parent::next();

        $this->skipdots();
    }

    protected function skipdots() {

        while ($this->isDot()) {

            parent::next();
        }
    }
}
