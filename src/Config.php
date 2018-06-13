<?php
namespace ItForFree\SimpleMVC;
use ItForFree\SimpleMVC\Application;

/**
 * Прокси-класс для удобного доступа к конфигурации приложения
 */
class Config
{
    /**
     * Вернёт элемент из массива конфигурации приложения
     * 
     * @param string $inConfigArrayPath ключ в виде строки, разделёной точками -- путь в массиве
     * @return mixed
     */
    public static function get($inConfigArrayPath)
    {
        return Application::getConfigElement($inConfigArrayPath);
    }
    
    
    /**
     * Создаст и вернёт объект по его имени из массива
     * 
     * @param string $inConfigArrayPath ключ в виде строки, разделёной точками -- путь в массиве
     * @return mixed
     */
    public static function getObject($inConfigArrayPath)
    {
        return Application::getConfigObject($inConfigArrayPath);
    }
}
