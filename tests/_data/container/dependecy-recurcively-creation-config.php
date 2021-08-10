<?php
/**
 * Конфигурационной файл приложения
 */
$config = [
    'core' => [ 
        'first' => [ 
            'class' => \application\models\dependecy\First::class,
            'params' => [
                'session' => '@second',
                'param2' => 'param2',
                'param3' => 'param3',
                'param4' => 'param4',
                'param5' => 'param5'
            ],
            'construct' => [
                'second' => '@third',
              ],  
        ],
        'second' => [ 
            'class' => \application\models\dependecy\Second::class,
            'alias' => '@second'
        ],
         'third' => [ 
            'class' => \application\models\dependecy\Third::class,
            'alias' => '@third'
        ]
    ]    
];

return $config;