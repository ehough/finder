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

//use Symfony\Component\Finder\Iterator\CustomFilterIterator;

class ehough_finder_iterator_CustomFilterIteratorTest extends IteratorTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWithInvalidFilter()
    {
        new ehough_finder_iterator_CustomFilterIterator(new Iterator(), array('foo'));
    }

    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($filters, $expected)
    {
        $inner = new Iterator(array('test.php', 'test.py', 'foo.php'));

        $iterator = new ehough_finder_iterator_CustomFilterIterator($inner, $filters);

        $this->assertIterator($expected, $iterator);
    }

    public function getAcceptData()
    {
        return array(
            array(array(function (\SplFileInfo $fileinfo) { return false; }), array()),
            array(array(function (\SplFileInfo $fileinfo) { return preg_match('/^test/', $fileinfo) > 0; }), array('test.php', 'test.py')),
            array(array('is_dir'), array()),
        );
    }
}
