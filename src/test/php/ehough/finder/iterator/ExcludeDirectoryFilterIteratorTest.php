<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ehough_finder_iterator_ExcludeDirectoryFilterIteratorTest extends ehough_finder_iterator_RealIteratorTestCase
{
    /**
     * @dataProvider getAcceptData
     */
    public function testAccept($directories, $expected)
    {
        if (version_compare(PHP_VERSION, '5.3') < 0) {

            $flags = 0;

        } else {

            $flags = FilesystemIterator::SKIP_DOTS;
        }

        $inner = new RecursiveIteratorIterator(new ehough_finder_iterator_RecursiveDirectoryIterator($this->toAbsolute(), $flags), RecursiveIteratorIterator::SELF_FIRST);

        $iterator = new ehough_finder_iterator_ExcludeDirectoryFilterIterator($inner, $directories);

        $this->assertIterator($expected, $iterator);
    }

    public function getAcceptData()
    {
        $foo = array(
            '.bar',
            '.foo',
            '.foo/.bar',
            '.foo/bar',
            '.git',
            'test.py',
            'test.php',
            'toto',
            'toto/.git',
            'foo bar',
        );

        $fo = array(
            '.bar',
            '.foo',
            '.foo/.bar',
            '.foo/bar',
            '.git',
            'test.py',
            'foo',
            'foo/bar.tmp',
            'test.php',
            'toto',
            'toto/.git',
            'foo bar',
        );

        return array(
            array(array('foo'), $this->toAbsolute($foo)),
            array(array('fo'), $this->toAbsolute($fo)),
        );
    }
}
