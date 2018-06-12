<?php
namespace ItForFree\SimpleMVC;

/**
 * Класс для удобного доступа к сущностям проекта
 */
class SMVC
{
    /**
     * Вернёт элемент из массива конфигурации приложения
     * 
     * @param string $inConfigArrayPath ключ в виде строки, разделёной точками -- путь в массиве
     * @return type
     */
    public static function config($inConfigArrayPath)
    {
        $configValue = Application::get()->config($inConfigArrayPath);
        return $configValue;
    }
    
    /**
     * Создаст и вернёт объект по его имени из массива
     * 
     * @param string $inConfigArrayPath ключ в виде строки, разделёной точками -- путь в массиве
     * @return type
     */
    public function configObject($inConfigArrayPath)
    {
        $configValue = self::config($inConfigArrayPath);
        return (new $configValue);
    }

 
}
