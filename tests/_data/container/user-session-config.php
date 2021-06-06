<?php
/**
 * Конфигурационной файл приложения
 */
$config = [
    'core' => [ // подмассив используемый самим ядром фреймворка
	'db' => [
            'dns' => 'mysql:host=localhost;dbname=dbname',
            'username' => 'root',
            'password' => '1234'
        ],
        'user' => [ // подсистема авторизации
            'class' => \application\models\ExampleUser::class,
            'params' => [
                'session' => '@session',
                'param2' => 'param2',
                'param3' => 'param3',
                'param4' => 'param4',
                'param5' => 'param5'
            ]
        ],
        'session' => [ // подсистема работы с сессиями
            'class' => ItForFree\SimpleMVC\Session::class,
            'alias' => '@session'
        ]
    ]    
];

return $config;