lomouty/vadmock
=======

This project is a simple library for php to generate mock data with configured mock rules.
The mock rules of this project refer to mockjs.

## Installation

To install this library,run the command blew and you will get the latest version.
```shell
composer require --dev lomouty/mock
```

## Explain
The current version supports mock in the following formats.
```shell
integer
string
boolean
object
array
```

## Examples

```php
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
            'tmp1' => 12,
            'tmp2' => 34,
        ),
    ),
);

$res = \Lomouty\Mock\Mock::mock($template);
```
According to the code above, you will get result of array like blew.

```php
Array
(
    [number] => 6
    [string] => **********
    [boolean] => 
    [object] => Array
        (
            [test3] => fggs
            [test5] => blockkid
            [test4] => gddee
        )

    [array] => Array
        (
            [0] => test
            [1] => 123
            [2] => 
            [3] => Array
                (
                    [tmp1] => 23
                    [tmp3] => 23
                    [tmp4] => 23
                )

            [4] => 233.3455
            [5] => vtest
        )

)
```
