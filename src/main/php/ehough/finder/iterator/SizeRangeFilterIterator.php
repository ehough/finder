<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//namespace Symfony\Component\Finder\Iterator;

//use Symfony\Component\Finder\Comparator\NumberComparator;

/**
 * ehough_finder_iterator_SizeRangeFilterIterator filters out files that are not in the given size range.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ehough_finder_iterator_SizeRangeFilterIterator extends ehough_finder_iterator_FilterIterator
{
    private $comparators = array();

    /**
     * Constructor.
     *
     * @param Iterator          $iterator    The Iterator to filter
     * @param ehough_finder_comparator_NumberComparator[] $comparators An array of ehough_finder_comparator_NumberComparator instances
     */
    public function __construct(Iterator $iterator, array $comparators)
    {
        $this->comparators = $comparators;

        parent::__construct($iterator);
    }

    /**
     * Filters the iterator values.
     *
     * @return Boolean true if the value should be kept, false otherwise
     */
    public function accept()
    {
        $fileinfo = $this->current();
        if (!$fileinfo->isFile()) {
            return true;
        }

        $filesize = $fileinfo->getSize();
        foreach ($this->comparators as $compare) {
            if (!$compare->test($filesize)) {
                return false;
            }
        }

        return true;
    }
}
