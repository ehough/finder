<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require 'FinderTest.php';

class ehough_finder_BsdFinderTest extends ehough_finder_FinderTest
{
    protected function getAdapter()
    {
        $adapter = new ehough_finder_adapter_BsdFindAdapter();

        if (!$adapter->isSupported()) {
            $this->markTestSkipped(get_class($adapter).' is not supported.');
        }

        return $adapter;
    }
}
