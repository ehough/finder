<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ehough_finder_iterator_RecursiveDirectoryIteratorTest extends ehough_finder_iterator_IteratorTestCase
{
    /**
     * @group network
     */
    public function testRewindOnFtp()
    {
        try {
            $i = new ehough_finder_iterator_RecursiveDirectoryIterator('ftp://speedtest.tele2.net/', RecursiveDirectoryIterator::SKIP_DOTS);
        } catch (UnexpectedValueException $e) {
            $this->markTestSkipped('Unsupported stream "ftp".');
        }

        $i->rewind();

        $this->assertTrue(true);
    }

    /**
     * @group network
     */
    public function testSeekOnFtp()
    {
        try {
            $i = new ehough_finder_iterator_RecursiveDirectoryIterator('ftp://speedtest.tele2.net/', RecursiveDirectoryIterator::SKIP_DOTS);
        } catch (UnexpectedValueException $e) {
            $this->markTestSkipped('Unsupported stream "ftp".');
        }

        $contains = array(
            'ftp://speedtest.tele2.net'.DIRECTORY_SEPARATOR.'1000GB.zip',
            'ftp://speedtest.tele2.net'.DIRECTORY_SEPARATOR.'100GB.zip',
        );
        $actual = array();

        $i->seek(0);
        $actual[] = $i->getPathname();

        $i->seek(1);
        $actual[] = $i->getPathname();

        $this->assertEquals($contains, $actual);
    }
}
