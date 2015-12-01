<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


class ehough_finder_GlobTest extends PHPUnit_Framework_TestCase
{

    public function testGlobToRegexDelimiters()
    {
        $this->assertEquals(ehough_finder_Glob::toRegex('.*'), '#^\.[^/]*$#');
        $this->assertEquals(ehough_finder_Glob::toRegex('.*', true, true, ''), '^\.[^/]*$');
        $this->assertEquals(ehough_finder_Glob::toRegex('.*', true, true, '/'), '/^\.[^/]*$/');
    }
}
