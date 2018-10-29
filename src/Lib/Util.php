<?php
/**
 * This file is part of the mock package.
 *
 * (c) lomouty <lomouty@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lomouty\Mock\Lib;


class Util {
    public static function type($obj){
        return is_array($obj) ? (self::_checkAssocArray($obj) ? 'array' : 'object') : (is_numeric($obj) ? 'number': (is_bool($obj) ? 'boolean' : 'string'));
    }

    private static function _checkAssocArray($arr){
        $index = 0;
        foreach ( array_keys($arr) as $key ) {
            if ($index !== $key) {return false;}
            $index++;
        }
        return true;
    }
}