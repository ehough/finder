<?php

__throwback::$config = array(

    'name'         => 'ehough_finder',
    'autoload'     => dirname(__FILE__) . '/../../main/php',
    'dependencies' => array(

        array('ehough/filesystem', 'git://github.com/ehough/filesystem.git', 'src/main/php')
    )
);