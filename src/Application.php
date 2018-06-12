<?php
namespace ItForFree\SimpleMVC;

use ItForFree\rusphp\PHP\ArrayLib\DotNotation\Dot;
use ItForFree\SimpleMVC\exceptions\SmvcCoreException;

/**
 * Класс-"точка входа" для работы фреймворка SimpleMVC
 * 
 * Реализует паттерн "Одиночка" @see http://fkn.ktu10.com/?q=node/5572
 */
class Application
{
    
    /**
     * Массив конфигурации приложенияъ
     * 
     * @var ItForFree\rusphp\PHP\ArrayLib\DotNotation\Dot
     */
    public $config = null;
    
    
    /**
     * Cкрываем конструктор для того чтобы класс нельзя было создать в обход get() 
     */
    protected function __construct() {}
    
    /**
     * Метод для получения текущего объекта приложения
     * 
     * @staticvar type $instance
     * @return ItForFree\SimpleMVC\Applicaion объект приложения
     */
    public static function get()
    {
        static $instance = null; // статическая переменная
        if (null === $instance) { // проверка существования
            $instance = new static();
        }
        return $instance;
    }
    

    /**
     * Запускает приложение
     * 
     * @param array $config Конфигурационный масиив приложения
     */
    public function run() {
        
        if (!empty($this->config)) {
            
            $route = \core\mvc\view\Url::getRoute();
            $obj = new \core\Router($route);
            
        } else {
            throw new SmvcCoreException ('Не задан конфигурационный массив приложения!');
        }

        
        return $this;
    }
    
    
    public function setConfiguration($config)
    {
        $this->config = new Dot($config);
        return $this;
    }
}
