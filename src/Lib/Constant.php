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


class Constant {

    const GUID = 1;

    const RE_KEY = '/(.+)\|(?:\+(\d+)|([\+\-]?\d+-?[\+\-]?\d*)?(?:\.(\d+-?\d*))?)/';

    const RE_RANGE = '/([\+\-]?\d+)-?([\+\-]?\d+)?/';

    const RE_PLACEHOLDER = '/\\\\*@([^@#%&()\?\s]+)(?:\((.*?)\))?/';

}