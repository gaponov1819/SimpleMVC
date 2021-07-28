<?php
/**
 * Конфигурационной файл приложения
 */
$config = [
    'core' => [ // подмассив используемый самим ядром фреймворка
        'firstCache' => [ // подсистема авторизации
            'class' => \application\models\containerElementsCaching\OneClassCache::class, 
        ],
        'secondCache' => [ // подсистема авторизации
            'class' => \application\models\containerElementsCaching\OneClassCache::class, 
        ],
    ]    
];

return $config;