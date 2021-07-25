<?php
/**
 * Конфигурационной файл приложения
 */
$config = [
    'core' => [ // подмассив используемый самим ядром фреймворка
        'OneClassCache' => [ // подсистема авторизации
            'class' => \application\models\testCache\OneClassCache::class,
            
        ],
    ]    
];

return $config;