<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ehough_finder_comparator_DateComparatorTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        try {
            new ehough_finder_comparator_DateComparator('foobar');
            $this->fail('__construct() throws an InvalidArgumentException if the test expression is not valid.');
        } catch (Exception $e) {
            $this->assertInstanceOf('InvalidArgumentException', $e, '__construct() throws an InvalidArgumentException if the test expression is not valid.');
        }

        try {
            new ehough_finder_comparator_DateComparator('');
            $this->fail('__construct() throws an InvalidArgumentException if the test expression is not valid.');
        } catch (Exception $e) {
            $this->assertInstanceOf('InvalidArgumentException', $e, '__construct() throws an InvalidArgumentException if the test expression is not valid.');
        }
    }

    /**
     * @dataProvider getTestData
     */
    public function testTest($test, $match, $noMatch)
    {
        $c = new ehough_finder_comparator_DateComparator($test);

        foreach ($match as $m) {
            $this->assertTrue($c->test($m), '->test() tests a string against the expression');
        }

        foreach ($noMatch as $m) {
            $this->assertFalse($c->test($m), '->test() tests a string against the expression');
        }
    }

    public function getTestData()
    {
        date_default_timezone_set('America/New_York');

        return array(
            array('< 2005-10-10', array(strtotime('2005-10-09')), array(strtotime('2005-10-15'))),
            array('until 2005-10-10', array(strtotime('2005-10-09')), array(strtotime('2005-10-15'))),
            array('before 2005-10-10', array(strtotime('2005-10-09')), array(strtotime('2005-10-15'))),
            array('> 2005-10-10', array(strtotime('2005-10-15')), array(strtotime('2005-10-09'))),
            array('after 2005-10-10', array(strtotime('2005-10-15')), array(strtotime('2005-10-09'))),
            array('since 2005-10-10', array(strtotime('2005-10-15')), array(strtotime('2005-10-09'))),
            array('!= 2005-10-10', array(strtotime('2005-10-11')), array(strtotime('2005-10-10'))),
        );
    }
}
