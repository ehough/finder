<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ehough_finder_iterator_Iterator implements Iterator
{
    protected $values = array();

    public function __construct(array $values = array())
    {
        foreach ($values as $value) {

            if ($this->_endsWithSlash($value)) {

                $value = rtrim($value, DIRECTORY_SEPARATOR);
            }

            $this->attach(new SplFileInfo($value));
        }
        $this->rewind();
    }

    public function attach(SplFileInfo $fileinfo)
    {
        $this->values[] = $fileinfo;
    }

    public function rewind()
    {
        reset($this->values);
    }

    public function valid()
    {
        return false !== $this->current();
    }

    public function next()
    {
        next($this->values);
    }

    public function current()
    {
        return current($this->values);
    }

    public function key()
    {
        return key($this->values);
    }

    private function _endsWithSlash($haystack)
    {
        return (substr($haystack, -1) === DIRECTORY_SEPARATOR);
    }
}
