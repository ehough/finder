<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ehough_finder_iterator_MockFileListIterator extends ArrayIterator
{
    public function __construct(array $filesArray = array())
    {
        $files = array_map(array($this, '_callback'), $filesArray);
        parent::__construct($files);
    }

    public function _callback($file)
    {
        return new ehough_finder_iterator_MockSplFileInfo($file);
    }
}
