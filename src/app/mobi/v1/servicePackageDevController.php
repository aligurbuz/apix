<?php
/**
 * Service package dev file
 * it is mainly service package dev for service
 * service package dev
 */

return [
    'packageDevSource'=>[
        'package'=>['adminlogin'],
        'packageDefinition'=>[
            'adminlogin'=>[
                'query'=>[
                    'post'=>[
                        'username',
                        'password'
                    ]

                ]
            ]
        ]
    ]
];