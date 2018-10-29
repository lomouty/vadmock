<?php
/**
 * This file is part of the mock package.
 *
 * (c) lomouty <lomouty@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lomouty\Mock;

use Lomouty\Mock\Lib\Handler;

class Mock {

    /**
     * @var \Lomouty\Mock\Lib\Handler
     */
    protected static $handler;

    public static function mock($template = array()){
        if (!(self::$handler instanceof Handler)) {
            self::$handler = new Handler();
        }
        return self::$handler->gen($template);
    }

}