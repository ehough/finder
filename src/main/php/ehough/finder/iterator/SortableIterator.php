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
 * ehough_finder_iterator_SortableIterator applies a sort on a given Iterator.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ehough_finder_iterator_SortableIterator implements IteratorAggregate
{
    const SORT_BY_NAME = 1;
    const SORT_BY_TYPE = 2;
    const SORT_BY_ACCESSED_TIME = 3;
    const SORT_BY_CHANGED_TIME = 4;
    const SORT_BY_MODIFIED_TIME = 5;

    private $iterator;
    private $sort;

    /**
     * Constructor.
     *
     * @param Traversable     $iterator The Iterator to filter
     * @param integer|callback $sort     The sort type (SORT_BY_NAME, SORT_BY_TYPE, or a PHP callback)
     *
     * @throws InvalidArgumentException
     */
    public function __construct(Traversable $iterator, $sort)
    {
        $this->iterator = $iterator;

        if (self::SORT_BY_NAME === $sort) {
            $this->sort = array($this, '_callbackSortName');
        } elseif (self::SORT_BY_TYPE === $sort) {
            $this->sort = array($this, '_callbackSortType');
        } elseif (self::SORT_BY_ACCESSED_TIME === $sort) {
            $this->sort = array($this, '_callbackSortTime');
        } elseif (self::SORT_BY_CHANGED_TIME === $sort) {
            $this->sort = array($this, '_callbackSortChangedTime');
        } elseif (self::SORT_BY_MODIFIED_TIME === $sort) {
            $this->sort = array($this, '_callbackSortModTime');
        } elseif (is_callable($sort)) {
            $this->sort = $sort;
        } else {
            throw new InvalidArgumentException('The ehough_finder_iterator_SortableIterator takes a PHP callback or a valid built-in sort algorithm as an argument.');
        }
    }

    public function getIterator()
    {
        $array = iterator_to_array($this->iterator, true);
        uasort($array, $this->sort);

        return new ArrayIterator($array);
    }

    public function _callbackSortModTime($a, $b)
    {
        return ($a->getMTime() - $b->getMTime());
    }

    public function _callbackSortChangedTime($a, $b)
    {
        return ($a->getCTime() - $b->getCTime());
    }

    public function _callbackSortTime($a, $b)
    {
        return ($a->getATime() - $b->getATime());
    }

    public function _callbackSortType($a, $b)
    {
        if ($a->isDir() && $b->isFile()) {
            return -1;
        } elseif ($a->isFile() && $b->isDir()) {
            return 1;
        }

        return strcmp($a->getRealpath(), $b->getRealpath());
    }

    public function _callbackSortName($a, $b)
    {
        return strcmp($a->getRealpath(), $b->getRealpath());
    }
}