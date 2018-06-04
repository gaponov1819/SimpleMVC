<?php
namespace ItForFree\SimpleMVC;

/**
 * Класс-хранилище настроек проекта
 */
class Config
{
    public static $options = [
        'core' => [ // подмассив используемые самим ядром фреймворка
            'db' => [
                'dns' => 'mysql:host=localhost;dbname=dbname',
                'username' => 'root',
                'password' => '1234'
            ]
        ]
    ];
 
}
