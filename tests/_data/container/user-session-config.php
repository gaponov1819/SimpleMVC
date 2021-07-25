<?php
/**
 * Конфигурационной файл приложения
 */
$config = [
    'core' => [ // подмассив используемый самим ядром фреймворка
        'user' => [ // подсистема авторизации
            'class' => \application\models\ExampleUser::class,
            'params' => [
                'session' => '@session',
                'param2' => 'param2',
                'param3' => 'param3',
                'param4' => 'param4',
                'param5' => 'param5'
            ],
            'construct' => [
                'session' => '@session',
              ],  
        ],
        'session' => [ // подсистема работы с сессиями
            'class' => \application\models\Session::class,
            'alias' => '@session'
        ]
    ]    
];

return $config;