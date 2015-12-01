<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ehough_finder_iterator_FileTypeFilterIteratorTest extends ehough_finder_iterator_RealIteratorTestCase
{
    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($mode, $expected)
    {
        $inner = new InnerTypeIterator(self::$files);

        $iterator = new ehough_finder_iterator_FileTypeFilterIterator($inner, $mode);

        $this->assertIterator($expected, $iterator);
    }

    public function getAcceptData()
    {
        $onlyFiles = array(
            'test.py',
            'foo/bar.tmp',
            'test.php',
            '.bar',
            '.foo/.bar',
            '.foo/bar',
            'foo bar',
        );

        $onlyDirectories = array(
            '.git',
            'foo',
            'toto',
            '.foo',
        );

        return array(
            array(ehough_finder_iterator_FileTypeFilterIterator::ONLY_FILES, $this->toAbsolute($onlyFiles)),
            array(ehough_finder_iterator_FileTypeFilterIterator::ONLY_DIRECTORIES, $this->toAbsolute($onlyDirectories)),
        );
    }
}

class InnerTypeIterator extends ArrayIterator
{
    public function current()
    {
        return new SplFileInfo(parent::current());
    }

    public function isFile()
    {
        return $this->current()->isFile();
    }

    public function isDir()
    {
        return $this->current()->isDir();
    }

    private function _endsWithSlash($haystack)
    {
        return (substr($haystack, -1) === DIRECTORY_SEPARATOR);
    }
}
