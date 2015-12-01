<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once 'Iterator.php';

class ehough_finder_iterator_CustomFilterIteratorTest extends ehough_finder_iterator_IteratorTestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithInvalidFilter()
    {
        new ehough_finder_iterator_CustomFilterIterator(new ehough_finder_iterator_Iterator(), array('foo'));
    }

    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($filters, $expected)
    {
        $inner = new ehough_finder_iterator_Iterator(array('test.php', 'test.py', 'foo.php'));

        $iterator = new ehough_finder_iterator_CustomFilterIterator($inner, $filters);

        $this->assertIterator($expected, $iterator);
    }

    public function getAcceptData()
    {
        return array(
            array(array(array($this, '_callbackGetAcceptData1')), array()),
            array(array(array($this, '_callbackGetAcceptData2')), array('test.php', 'test.py')),
            array(array('is_dir'), array()),
        );
    }

    public function _callbackGetAcceptData2(SplFileInfo $fileinfo)
    {
        return 0 === strpos($fileinfo, 'test');
    }

    public function _callbackGetAcceptData1(SplFileInfo $fileinfo)
    {
        return false;
    }
}
