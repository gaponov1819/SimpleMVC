<?php
namespace ItForFree\SimpleMVC;

/**
 * Класс для работы с URL и формирования ссылок
 */
class Url
{
    /**
     * Получаем URL
     */
    public static function getRoute()
    {
        $getValue = isset($_GET['route'] ) ? $_GET['route'] : "";
        return $getValue;
    }
         
    public static function link($route)
    {
        $path = "/index.php?route=$route"; 
        return $path;
    }
}

