<?php
/**
 * System status codes
 * The HTTP verbs comprise a major portion of our “uniform interface” constraint and provide
 * us the action counterpart to the noun-based resource. The primary or most-commonly-used HTTP verbs
 * (or methods, as they are properly called) are POST, GET, PUT, PATCH, and DELETE. These correspond to create,
 * read, update, and delete (or CRUD) operations, respectively. There are a number of other verbs, too,
 * but are utilized less frequently. Of those less-frequent methods,
 * OPTIONS and HEAD are used more often than others.
 */

return [

    'GET'       =>200,
    'POST'      =>201,
    'PUT'       =>200,
    'PATCH'     =>200,
    'DELETE'    =>200
];
