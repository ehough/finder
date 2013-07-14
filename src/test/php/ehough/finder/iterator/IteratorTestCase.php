<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

abstract class ehough_finder_iterator_IteratorTestCase extends PHPUnit_Framework_TestCase
{
    protected function assertIterator($expected, Traversable $iterator)
    {
        // set iterator_to_array $use_key to false to avoid values merge
        // this made ehough_finder_FinderTest::testAppendWithAnArray() failed with GnuFinderAdapter
        $values = array_map(array($this, '_callbackAssertIterator1'), iterator_to_array($iterator, false));

        $expected = array_map(array($this, '_callbackAssertIterator2'), $expected);

        sort($values);
        sort($expected);

        $this->assertEquals($expected, array_values($values));
    }

    protected function assertOrderedIterator($expected, Traversable $iterator)
    {
        $values = array_map(array($this, '_callbackAssertOrderIterator'), iterator_to_array($iterator));

        $this->assertEquals($expected, array_values($values));
    }

    /**
     * Same as IteratorTestCase::assertIterator with foreach usage
     *
     * @param array $expected
     * @param \Traversable $iterator
     */
    protected function assertIteratorInForeach($expected, \Traversable $iterator)
    {
        $values = array();
        foreach ($iterator as $file) {
            $this->assertInstanceOf('ehough_finder_SplFileInfo', $file);
            $values[] = $file->getPathname();
        }

        sort($values);
        sort($expected);

        $this->assertEquals($expected, array_values($values));
    }

    /**
     * Same as IteratorTestCase::assertOrderedIterator with foreach usage
     *
     * @param array $expected
     * @param \Traversable $iterator
     */
    protected function assertOrderedIteratorInForeach($expected, \Traversable $iterator)
    {
        $values = array();
        foreach ($iterator as $file) {
            $this->assertInstanceOf('ehough_finder_SplFileInfo', $file);
            $values[] = $file->getPathname();
        }

        $this->assertEquals($expected, array_values($values));
    }

    public function _callbackAssertOrderIterator(SplFileInfo $fileinfo)
    {
        return $fileinfo->getPathname();
    }

    public function _callbackAssertIterator2($path)
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }

    public function _callbackAssertIterator1(SplFileInfo $fileinfo)
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $fileinfo->getPathname());
    }
}
