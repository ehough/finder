<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ehough_finder_shell_CommandTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf('ehough_finder_shell_Command', ehough_finder_shell_Command::create());
    }

    public function testAdd()
    {
        $cmd = ehough_finder_shell_Command::create()->add('--force');
        $this->assertSame('--force', $cmd->join());
    }

    public function testAddAsFirst()
    {
        $cmd = ehough_finder_shell_Command::create()->add('--force');

        $cmd->addAtIndex(ehough_finder_shell_Command::create()->add('-F'), 0);
        $this->assertSame('-F --force', $cmd->join());
    }

    public function testAddAsLast()
    {
        $cmd = ehough_finder_shell_Command::create()->add('--force');

        $cmd->addAtIndex(ehough_finder_shell_Command::create()->add('-F'), 1);
        $this->assertSame('--force -F', $cmd->join());
    }

    public function testAddInBetween()
    {
        $cmd = ehough_finder_shell_Command::create()->add('--force');
        $cmd->addAtIndex(ehough_finder_shell_Command::create()->add('-F'), 0);

        $cmd->addAtIndex(Command::create()->add('-X'), 1);
        $this->assertSame('-F -X --force', $cmd->join());
    }

    public function testCount()
    {
        $cmd = ehough_finder_shell_Command::create();
        $this->assertSame(0, $cmd->length());

        $cmd->add('--force');
        $this->assertSame(1, $cmd->length());

        $cmd->add('--run');
        $this->assertSame(2, $cmd->length());
    }

    public function testTop()
    {
        $cmd = ehough_finder_shell_Command::create()->add('--force');

        $cmd->top('--run');
        $this->assertSame('--run --force', $cmd->join());
    }

    public function testTopLabeled()
    {
        $cmd = ehough_finder_shell_Command::create()->add('--force');

        $cmd->top('--run');
        $cmd->ins('--something');
        $cmd->top('--something');
        $this->assertSame('--something --run --force ', $cmd->join());
    }

    public function testArg()
    {
        $cmd = ehough_finder_shell_Command::create()->add('--force');

        $cmd->arg('--run');
        $this->assertSame('--force \'--run\'', $cmd->join());
    }

    public function testCmd()
    {
        $cmd = ehough_finder_shell_Command::create()->add('--force');

        $cmd->cmd('run');
        $this->assertSame('--force run', $cmd->join());
    }

    public function testInsDuplicateLabelException()
    {
        $cmd = ehough_finder_shell_Command::create()->add('--force');

        $cmd->ins('label');
        $this->setExpectedException('RuntimeException');
        $cmd->ins('label');
    }

    public function testEnd()
    {
        $parent = ehough_finder_shell_Command::create();
        $cmd = ehough_finder_shell_Command::create($parent);

        $this->assertSame($parent, $cmd->end());
    }

    public function testEndNoParentException()
    {
        $cmd = ehough_finder_shell_Command::create();

        $this->setExpectedException('RuntimeException');
        $cmd->end();
    }

    public function testGetMissingLabelException()
    {
        $cmd = ehough_finder_shell_Command::create();

        $this->setExpectedException('RuntimeException');
        $cmd->get('invalid');
    }

    public function testErrorHandler()
    {
        $cmd = ehough_finder_shell_Command::create();
        $handler = function() { return 'error-handler'; };
        $cmd->setErrorHandler($handler);

        $this->assertSame($handler, $cmd->getErrorHandler());
    }

    public function testExecute()
    {
        $cmd = ehough_finder_shell_Command::create();
        $cmd->add('php');
        $cmd->add('--version');
        $result = $cmd->execute();

        $this->assertTrue(is_array($result));
        $this->assertNotEmpty($result);
        $this->assertRegexp('/PHP|HipHop/', $result[0]);
    }

    public function testCastToString()
    {
        $cmd = ehough_finder_shell_Command::create();
        $cmd->add('--force');
        $cmd->add('--run');

        $this->assertSame('--force --run', (string) $cmd);
    }
}
