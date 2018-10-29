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

class Handler {

    /**
     * @var \Lomouty\Mock\Lib\Basic
     */
    protected $basic;

    public function __construct() {
        if (!$this->basic) {
            $this->basic = new Basic();
        }
    }

    /**
     * generate mock data as array
     *
     * @param $template
     * @param $name
     */
    public function gen($template, $name = ''){
        $rule = Parser::parse($name);
        $type = Util::type($template);

        if (method_exists($this, 'type'.ucfirst($type))) {

            $options = array(
                'type' => $type,
                'template' => $template,
                'name' => $name,
                'parsedName' => $name ? preg_replace(Constant::RE_KEY, '$1', $name) : $name,
                'rule' => $rule,
            );
            $data = $this->{'type'.ucfirst($type)}($options);

            return $data;
        }
        return $template;
    }

    /**
     * numeric array operate function
     * @param $options
     * @return array
     */
    public function typeArray($options){
        $result = array();
        $temp_len = count($options['template']);
        // "name|1":[]  "name|count":[]   "name|min-max":[]

        if ($temp_len == 0) {
            return $result;
        }
        // "arr": [{"email":"@EMAIL"},{"email":"@EMAIL"}]
        if (!$options['rule']['parameters']) {
            foreach ($options['template'] as $key => $item) {
                $result[] = $this->gen($item, $key);
            }
        } else {
            if ($options['rule']['min'] === 1 && $options['rule']['max'] === null) {
                // get rand val of template
                $randTemp = $options['template'][array_rand($options['template'])];
                $result = $this->gen($randTemp);
            } else {
                if ($options['rule']['parameters'][2]) {
                    // 'data|+1':[{},{}]
                    // todo:: iterator
                    $result = $this->gen($options['template'])[0];
                } else {
                    // 'data|1-10':[{}]
                    for ($i=0;$i<$options['rule']['count'];$i++) {
                        foreach ($options['template'] as $key=>$item) {
                            $result[] = $this->gen($item);
                        }
                    }
                }
            }
        }
        return $result;
    }

    /**
     * associative array operate function
     * @param $options
     * @return array
     */
    public function typeObject($options){
        $result = array();

        // "obj|min-max":{}
        if ($options['rule']['min'] != null) {
            $keys = array_keys($options['template']);
            shuffle($keys);
            $keys = array_slice($keys, 0, $options['rule']['count']);

            for ($i=0;$i<count($keys);$i++) {
                $key = $keys[$i];
                $parsedKey = preg_replace(Constant::RE_KEY, '$1', $key);
                $result[$parsedKey] = $this->gen($options['template'][$key], $key);
            }
        } else {
            // todo:: to add function type operation
            // "arr": {"email":"@EMAIL"}
            if (!$options['rule']['parameters']) {
                foreach ($options['template'] as $key => $item) {
                    $parsedKey = preg_replace(Constant::RE_KEY, '$1', $key);
                    $result[$parsedKey] = $this->gen($item, $key);
                }
            }
        }
        return $result;
    }

    public function typeNumber($options) {
        if (isset($options['rule']['decimal'])) {       // float
            $parts = explode('.', (string)$options['template']);
            $parts[0] = isset($options['rule']['range']) ? $options['rule']['count'] : $parts[0];
            $parts[1] = substr((isset($parts[1]) ? $parts[1] : ''), 0 , $options['rule']['dcount']);
            while (strlen(floor($parts[1])) < $options['rule']['dcount']) {
                // 浮点最后一位不能为0
                $pool = strlen(floor($parts[1])) < $options['rule']['dcount']-1 ? 'number' : '123456789';
                $parts[1] .= $this->basic->character($pool);
            }
            $result = (float)($parts[0].'.'.$parts[1]);
        } else {    // integer
            $result = (isset($options['rule']['range']) && !$options['rule']['parameter'][2]) ? $options['rule']['count'] : $options['template'];
        }
        return $result;
    }

    public function typeBoolean($options) {
        return (isset($options['rule']['parameters']))?$this->basic->boolean($options['rule']['min'],$options['rule']['max']): $options['template'];
    }

    public function typeString($options) {
        $result = '';
        if (strlen($options['template'])) {
            if ($options['rule']['count'] == null) {
                $result .= $options['template'];
            } else {
                for ($i = 0; $i < $options['rule']['count']; $i++) {
                    $result .= $options['template'];
                }
            }

            // todo:: add placeholder replacement   "name|1-10":"@sentence()"
            //            preg_match_all(Constant::RE_PLACEHOLDER, $result, $placeholders);
        } else {
            // 'name|1-10':''  or  'name':''
            $result = isset($options['rule']['range'])? $this->basic->string($options['rule']['count']) : $options['template'];
        }
        return $result;
    }

    public function __call($name, $arguments) {
        // TODO: Implement __call() method.
    }
}