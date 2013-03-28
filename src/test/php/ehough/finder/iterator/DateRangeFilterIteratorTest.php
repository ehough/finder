<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//namespace Symfony\Component\Finder\Tests\Iterator;

//use Symfony\Component\Finder\Iterator\DateRangeFilterIterator;
//use Symfony\Component\Finder\Comparator\DateComparator;

class ehough_finder_iterator_DateRangeFilterIteratorTest extends ehough_finder_iterator_RealIteratorTestCase
{
    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($size, $expected)
    {
        $inner = new ehough_finder_iterator_Iterator(self::$files);

        $iterator = new ehough_finder_iterator_DateRangeFilterIterator($inner, $size);

        $this->assertIterator($expected, $iterator);
    }

    public function getAcceptData()
    {
        $since20YearsAgo = array(
            '.git',
            'test.py',
            'foo',
            'foo/bar.tmp',
            'test.php',
            'toto',
            '.bar',
            '.foo',
            '.foo/.bar',
            'foo bar',
            '.foo/bar',
        );

        $since2MonthsAgo = array(
            '.git',
            'test.py',
            'foo',
            'toto',
            '.bar',
            '.foo',
            '.foo/.bar',
            'foo bar',
            '.foo/bar',
        );

        $untilLastMonth = array(
            '.git',
            'foo',
            'foo/bar.tmp',
            'test.php',
            'toto',
            '.foo',
        );

        return array(
            array(array(new ehough_finder_comparator_DateComparator('since 20 years ago')), $this->toAbsolute($since20YearsAgo)),
            array(array(new ehough_finder_comparator_DateComparator('since 2 months ago')), $this->toAbsolute($since2MonthsAgo)),
            array(array(new ehough_finder_comparator_DateComparator('until last month')), $this->toAbsolute($untilLastMonth)),
        );
    }
}
