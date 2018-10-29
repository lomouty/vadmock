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


class Parser {
    public static function parse($name = ''){
        preg_match(Constant::RE_KEY, $name, $parameters);
        // range of integer
        $random = new Basic();
        $range = array();
        $parameters && $parameters[3] && preg_match(Constant::RE_RANGE, $parameters[3], $range);
        $min = ($range && $range[1]) ? intval($range[1]) : null;
        $max = ($range && $range[2]) ? intval($range[2]) : null;

        $count = $range ? (!$range[2] ? intval($range[1]) : $random->integer($min, $max)) : null;
        // range of decimal
        $decimal = array();
        $parameters && $parameters[4] && preg_match(Constant::RE_RANGE, $parameters[4], $decimal);
        $dmin = ($decimal && $decimal[1]) ? intval($decimal[1]) : null;
        $dmax = ($decimal && $decimal[2]) ? intval($decimal[2]) : null;

        $dcount = $decimal ? (!$decimal[2] ? intval($decimal[1]) : $random->integer($dmin, $dmax)) : null;

        $result = array(
            // 1 name, 2 inc, 3 range, 4 decimal
            'parameters' => $parameters,
            // 1 min, 2 max
            'range' => $range,
            'min' => $min,
            'max' => $max,
            // min-max
            'count' => $count,

            'decimal' => $decimal,
            'dmin' => $dmin,
            'dmax' => $dmax,
            'dcount' => $dcount,
        );

        foreach ($result as $r) {
            if (!(is_array($r) && empty($r)) && $r != null) {
                return $result;
            }
        }
        return array();
    }
}