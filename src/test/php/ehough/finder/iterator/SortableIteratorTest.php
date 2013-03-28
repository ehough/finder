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

//use Symfony\Component\Finder\Iterator\SortableIterator;

class ehough_finder_iterator_SortableIteratorTest extends ehough_finder_iterator_RealIteratorTestCase
{
    public function testConstructor()
    {
        try {
            new ehough_finder_iterator_SortableIterator(new ehough_finder_iterator_Iterator(array()), 'foobar');
            $this->fail('__construct() throws an \InvalidArgumentException exception if the mode is not valid');
        } catch (\Exception $e) {
            $this->assertInstanceOf('InvalidArgumentException', $e, '__construct() throws an \InvalidArgumentException exception if the mode is not valid');
        }
    }

    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($mode, $expected)
    {
        $inner = new ehough_finder_iterator_Iterator(self::$files);

        $iterator = new ehough_finder_iterator_SortableIterator($inner, $mode);

        $this->assertOrderedIterator($expected, $iterator);
    }

    public function getAcceptData()
    {

        $sortByName = array(
            '.bar',
            '.foo',
            '.foo/.bar',
            '.foo/bar',
            '.git',
            'foo',
            'foo bar',
            'foo/bar.tmp',
            'test.php',
            'test.py',
            'toto',
        );

        $sortByType = array(
            '.foo',
            '.git',
            'foo',
            'toto',
            '.bar',
            '.foo/.bar',
            '.foo/bar',
            'foo bar',
            'foo/bar.tmp',
            'test.php',
            'test.py',
        );

        $customComparison = array(
            '.bar',
            '.foo',
            '.foo/.bar',
            '.foo/bar',
            '.git',
            'foo',
            'foo bar',
            'foo/bar.tmp',
            'test.php',
            'test.py',
            'toto',
        );

        return array(
            array(ehough_finder_iterator_SortableIterator::SORT_BY_NAME, $this->toAbsolute($sortByName)),
            array(ehough_finder_iterator_SortableIterator::SORT_BY_TYPE, $this->toAbsolute($sortByType)),
            array(function (\SplFileInfo $a, \SplFileInfo $b) { return strcmp($a->getRealpath(), $b->getRealpath()); }, $this->toAbsolute($customComparison)),
        );
    }
}
