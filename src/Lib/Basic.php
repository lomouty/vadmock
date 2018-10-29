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


class Basic {

    /**
     * return random value of boolean
     * @param int $min
     * @param int $max
     * @return boolean
     */
    public function boolean($min = 1, $max = 1){
        $min = max(min($min, 10), 1);
        $max = max(min($max, 10), 1);
        if ($max < $min) {
            $min = 1;
            $max = 1;
        }
        return (mt_rand() / mt_getrandmax()) > (1.0 / ($min + $max) * $min);
    }

    /**
     * return random value of boolean
     * @param int $min
     * @param int $max
     * @return bool
     */
    public function bool($min = 1, $max = 1){
        return $this->boolean($min, $max);
    }

    /**
     * return random value of positive integer
     * @param int $min
     * @param int $max default 2^53
     * @return integer
     */
    public function natural($min = 0, $max = 9007199254740992){
        $min = $min != null ? intval($min) : 0;
        $max = $max != null ? intval($max) : 9007199254740992;
        return $this->integer($min, $max);
    }

    /**
     * return random value of integer
     * @param int $min
     * @param int $max default 2^53
     * @return integer
     */
    public function integer($min = -9007199254740992, $max = 9007199254740992){
        $min = $min != null ? intval($min) : -9007199254740992;
        $max = $max != null ? intval($max) : 9007199254740992;
        return mt_rand($min, $max);
    }

    /**
     * return random value of integer
     * @param int $min
     * @param int $max default 2^53
     * @return integer
     */
    public function int($min = -9007199254740992, $max = 9007199254740992){
        return $this->integer($min, $max);
    }

    /**
     * random float number
     * @param int $min
     * @param int $max
     * @param int $dmin
     * @param int $dmax
     * @return float
     */
    public function float($min = 0, $max = 65535, $dmin = 2, $dmax = 10){
        $ret = $min + (mt_rand() / mt_getrandmax() * ($max - $min));
        $dcnt = mt_rand($dmin, $dmax);
        $rd = $this->character('123456789');
        $str = sprintf("%.{$dcnt}f%d", $ret, $rd);
        return (float)$str;
    }

    /**
     * return random char with pool
     * @param string $pool
     * @return string
     */
    public function character($pool = ''){
        $pools = array(
            'lower' => 'abcdefghijklmnopqrstuvwxyz',
            'upper' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'number' => '0123456789',
            'symbol' => '!@#$%^&*()[]'
        );

        $pools['alpha'] = $pools['lower'] . $pools['upper'];
        $pools['undefined'] = $pools['lower'] . $pools['upper'] . $pools['number'] . $pools['symbol'];

        $pool = !$pool ? $pools['undefined'] : ($pools[strtolower($pool)] ? : $pool);
        return substr($pool, mt_rand(0, strlen($pool)-1), 1);
    }

    /**
     * return random char with pool
     * @param string $pool
     * @return string
     */
    public function char($pool = ''){
        return $this->character($pool);
    }

    /**
     * random string with pool
     * @param string $pool
     * @param int $min
     * @param int $max
     * @return string
     */
    public function string($pool = '', $min = 3, $max = 7){
        $args_len = func_num_args();
        switch ($args_len) {
            case 0: // ()
                $len = mt_rand(3, 7);
                break;
            case 1: // (length)
                $len = $pool;
                $pool = 'undefined';
                break;
            case 2:
                if (is_string($pool)) { // (pool, length)
                    $len = $min;
                } else {        // (min, max)
                    $len = mt_rand($pool, $min);
                    $pool = 'undefined';
                }
                break;
            default:
                $len = mt_rand($min, $max);
                break;
        }
        $text = '';
        for ($i = 0; $i < $len; $i++) {
            $text .= $this->character($pool);
        }
        return $text;
    }

    /**
     * random integer array
     * @param int $start
     * @param int $stop
     * @param int $step
     * @return array
     */
    public function range($start = 0, $stop = 0, $step = 1){
        $args_len = func_num_args();
        if ($args_len <= 1) {
            $stop = $start ? : 0;
            $start = 0;
        }
        $step = $step <= 0 ? 1 : $step;

        $range = array();
        $idx = 0;
        while ($start < $stop) {
            $range[$idx++] = $start;
            $start += $step;
        }

        return $range;
    }
}