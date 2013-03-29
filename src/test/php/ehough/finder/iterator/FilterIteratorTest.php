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
 * @author Alex Bogomazov
 */
class ehough_finder_iterator_FilterIteratorTest extends ehough_finder_iterator_RealIteratorTestCase
{
    private $_i;

    public function testFilterFilesystemIterators()
    {
        $i = new DirectoryIterator($this->toAbsolute());

        // it is expected that there are test.py test.php in the tmpDir
        $i = $this->getMockForAbstractClass('ehough_finder_iterator_FilterIterator', array($i));
        $this->_i = $i;
        $i->expects($this->any())
            ->method('accept')
            ->will($this->returnCallback(array($this, '_callback'))
        );

        $c = 0;
        foreach ($i as $item) {
            $c++;
        }

        $this->assertEquals(1, $c);

        $i->rewind();

        $c = 0;
        foreach ($i as $item) {
            $c++;
        }

        // This would fail with \FilterIterator but works with Symfony\Component\FinderIterator\FilterIterator
        // see https://bugs.php.net/bug.php?id=49104
        $this->assertEquals(1, $c);
    }

    public function _callback()
    {
        return (bool) preg_match('/\.php/', (string) $this->_i->current());
    }
}
