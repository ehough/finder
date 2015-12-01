<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ehough_finder_iterator_PathFilterIteratorTest extends ehough_finder_iterator_IteratorTestCase
{
    /**
     * @dataProvider getTestFilterData
     */
    public function testFilter(Iterator $inner, array $matchPatterns, array $noMatchPatterns, array $resultArray)
    {
        $iterator = new ehough_finder_iterator_PathFilterIterator($inner, $matchPatterns, $noMatchPatterns);
        $this->assertIterator($resultArray, $iterator);
    }

    public function getTestFilterData()
    {
        $inner = new ehough_finder_iterator_MockFileListIterator();

        //PATH:   A/B/C/abc.dat
        $inner[] = new ehough_finder_iterator_MockSplFileInfo(array(
            'name'              => 'abc.dat',
            'relativePathname'  => 'A'.DIRECTORY_SEPARATOR.'B'.DIRECTORY_SEPARATOR.'C'.DIRECTORY_SEPARATOR.'abc.dat',
        ));

        //PATH:   A/B/ab.dat
        $inner[] = new ehough_finder_iterator_MockSplFileInfo(array(
            'name'              => 'ab.dat',
            'relativePathname'  => 'A'.DIRECTORY_SEPARATOR.'B'.DIRECTORY_SEPARATOR.'ab.dat',
        ));

        //PATH:   A/a.dat
        $inner[] = new ehough_finder_iterator_MockSplFileInfo(array(
            'name'              => 'a.dat',
            'relativePathname'  => 'A'.DIRECTORY_SEPARATOR.'a.dat',
        ));

        //PATH:   copy/A/B/C/abc.dat.copy
        $inner[] = new ehough_finder_iterator_MockSplFileInfo(array(
            'name'              => 'abc.dat.copy',
            'relativePathname'  => 'copy'.DIRECTORY_SEPARATOR.'A'.DIRECTORY_SEPARATOR.'B'.DIRECTORY_SEPARATOR.'C'.DIRECTORY_SEPARATOR.'abc.dat',
        ));

        //PATH:   copy/A/B/ab.dat.copy
        $inner[] = new ehough_finder_iterator_MockSplFileInfo(array(
            'name'              => 'ab.dat.copy',
            'relativePathname'  => 'copy'.DIRECTORY_SEPARATOR.'A'.DIRECTORY_SEPARATOR.'B'.DIRECTORY_SEPARATOR.'ab.dat',
        ));

        //PATH:   copy/A/a.dat.copy
        $inner[] = new ehough_finder_iterator_MockSplFileInfo(array(
            'name'              => 'a.dat.copy',
            'relativePathname'  => 'copy'.DIRECTORY_SEPARATOR.'A'.DIRECTORY_SEPARATOR.'a.dat',
        ));

        return array(
            array($inner, array('/^A/'),       array(), array('abc.dat', 'ab.dat', 'a.dat')),
            array($inner, array('/^A\/B/'),    array(), array('abc.dat', 'ab.dat')),
            array($inner, array('/^A\/B\/C/'), array(), array('abc.dat')),
            array($inner, array('/A\/B\/C/'),  array(), array('abc.dat', 'abc.dat.copy')),

            array($inner, array('A'),      array(), array('abc.dat', 'ab.dat', 'a.dat', 'abc.dat.copy', 'ab.dat.copy', 'a.dat.copy')),
            array($inner, array('A/B'),    array(), array('abc.dat', 'ab.dat', 'abc.dat.copy', 'ab.dat.copy')),
            array($inner, array('A/B/C'),  array(), array('abc.dat', 'abc.dat.copy')),

            array($inner, array('copy/A'),      array(), array('abc.dat.copy', 'ab.dat.copy', 'a.dat.copy')),
            array($inner, array('copy/A/B'),    array(), array('abc.dat.copy', 'ab.dat.copy')),
            array($inner, array('copy/A/B/C'),  array(), array('abc.dat.copy')),

        );
    }
}
