<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @group legacy
 */
class ehough_finder_GnuFinderTest extends ehough_finder_FinderTest
{
    protected function buildFinder()
    {
        $adapter = new ehough_finder_adapter_GnuFindAdapter();

        if (!$adapter->isSupported()) {
            $this->markTestSkipped(get_class($adapter).' is not supported.');
        }

        return ehough_finder_Finder::create()
            ->removeAdapters()
            ->addAdapter($adapter);
    }
}
