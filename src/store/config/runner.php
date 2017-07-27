<?php
/**
 * Project system runner
 * ## Project system runner api console implemantation
 */

return [
    'mixed'=>[
        'php api project create mobi',
        'php api service create mobi:stk',
        'php api model create mobi file:user table:users',
        'php api migration pull:mobi --seed'
    ]
];
