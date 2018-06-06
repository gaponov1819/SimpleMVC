<?php
namespace ItForFree\SimpleMVC;

/**
 * Класс-"точка входа" для работы фреймворка SimpleMVC
 */
class Application
{
    

    /**
     * Запускает приложение
     * 
     * @param array $config Конфигурационный масиив приложения
     */
    public function run($config) {
        $route = \core\mvc\view\Url::getRoute();
        $obj = new \core\Router($route);
    }
}
