<?php
namespace ItForFree\SimpleMVC;

use ItForFree\rusphp\PHP\ArrayLib\DotNotation\Dot;

/**
 * Класс-"точка входа" для работы фреймворка SimpleMVC
 */
class Application
{
    
    
    
    public function __construct($config) {
        ;
    }
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
