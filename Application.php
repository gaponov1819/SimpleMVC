<?php
namespace ItForFree\SimpleMVC;

/**
 * Класс-"точка входа" для работы фреймворка SimpleMVC
 */
class Application
{
    

    /**
     * Запускает приложение
     */
    public function run(\ItForFree\SimpleMVC\interfaces\RouterInterface $Router) {
        $route = \core\mvc\view\Url::getRoute();
        $obj = new \core\Router($route);
    }
}
