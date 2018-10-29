<?php
/**
 * This file is test of the mock package.
 *
 * (c) lomouty <lomouty@gmail.com>
 */
require __DIR__ .'/../vendor/autoload.php';

$template = array(
    'number|1-10.1-4' => 1,
    'string|5-20' => '*',
    'boolean|1' => true,
    'object|2-4' => array(
        'test1' => 'abc',
        'test2' => 'def',
        'test3' => 'fggs',
        'test4' => 'gddee',
        'test5' => 'blockkid',
    ),
    'array|1-3' => array(
        'test',
        123,
        false,
        array(
            'tmp1' => 23,
            'tmp3' => 23,
            'tmp4' => 23,
        ),
        233.3455,
        'vtest',
    ),
);

$res = \Lomouty\Mock\Mock::mock($template);

var_dump($res);



