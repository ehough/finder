<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ehough_finder_iterator_SizeRangeFilterIteratorTest extends ehough_finder_iterator_RealIteratorTestCase
{
    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($size, $expected)
    {
        $inner = new InnerSizeIterator(self::$files);

        $iterator = new ehough_finder_iterator_SizeRangeFilterIterator($inner, $size);

        $this->assertIterator($expected, $iterator);
    }

    public function getAcceptData()
    {
        $lessThan1KGreaterThan05K = array(
            '.foo',
            '.git',
            'foo',
            'test.php',
            'toto',
        );

        return array(
            array(array(new ehough_finder_comparator_NumberComparator('< 1K'), new ehough_finder_comparator_NumberComparator('> 0.5K')), $this->toAbsolute($lessThan1KGreaterThan05K)),
        );
    }
}

class InnerSizeIterator extends ArrayIterator
{
    public function __construct(array $values = array())
    {
        $toSendToParent = array();

        foreach ($values as $value) {

            if ($this->_endsWithSlash($value)) {

                $toSendToParent[] = rtrim($value, DIRECTORY_SEPARATOR);
            } else {

                $toSendToParent[] = $value;
            }
        }

        parent::__construct($toSendToParent);
    }

   public function current()
    {
        return new SplFileInfo(parent::current());
    }

    public function getFilename()
    {
        return parent::current();
    }

    public function isFile()
    {
        return $this->current()->isFile();
    }

    public function getSize()
    {
        return $this->current()->getSize();
    }

    private function _endsWithSlash($haystack)
    {
        return (substr($haystack, -1) === DIRECTORY_SEPARATOR);
    }
}
