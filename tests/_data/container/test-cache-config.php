<?php
/**
 * Конфигурационной файл приложения
 */
$config = [
    'core' => [ // подмассив используемый самим ядром фреймворка
        'first' => [ // подсистема авторизации
            'class' => \application\models\testCache\OneClassCache::class, 
        ],
        'second' => [ // подсистема авторизации
            'class' => \application\models\testCache\OneClassCache::class, 
        ],
    ]    
];

return $config;