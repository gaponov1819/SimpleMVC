<?php
namespace ItForFree\SimpleMVC;

use ItForFree\SimpleMVC\exceptions\SmvcUsageException;

/**
 * Класс-маршрутизатор, его задача по переданной строке (предположительно это какой-то адресе на сайте),
 * определить какой контролеер и какое действие надо вызывать.
 */

class Router
{

   /**
    * Имя контроллера, которое надо указывать, если иное не найдено
    * @var string 
    */
   protected static $defaultControllerName = 'Homepage';
    
    /**
     * Вызовет действие контроллера, разобрав переданный маршрут
     * 
     * @param srting $route маршрут: Любая строка (подразумевается, что это url или фрагмент), по которой можно определить вызываемый контроллер (класс) и его действие (метод)
     * @return $this
     * @throws SmvcUsageException
     */
    public function callControllerAction($route)
    {
        $controllerName = "\\application\\controllers\\" . self::getControllerClassName($route);
        
        if (!class_exists($controllerName)) {
            throw new SmvcUsageException("Контроллер не найден.");
        }
        $controller = new $controllerName();

        $controller->callAction($route);
        
        return $this;
    }
    
    /**
     *  Сформаирует имя класса контроллера, на осонвании переданного маршрута
     * 
     * @param string $route маршрут, запрошенный пользотелем
     * @return  string
     */
    public static function getControllerClassName($route)
    {
        $result = self::$defaultControllerName;
                
        $urlFragments = explode('/', $route);
        
        if (!empty($urlFragments[0])) {
            
            $result = "";
            
            $classNameIndex = count($urlFragments)-2;
            $className = $urlFragments[$classNameIndex];
            $firstletterToUp = ucwords($className); // поднимаем первую букву в имени класса
            if (count($urlFragments) > 2) {  // следовательно присутствует доп подпространство внутри кcontrollers
                $i = 0;
                while($i < $classNameIndex) {
                    $result .= $urlFragments[$i] . "\\"; //прибавляем подпространство к имени класса
                    $i++;
                }
            }
            $result .= $firstletterToUp;
//            \DebugPrinter::debug($result, 'результат после сложения неймспейса и имени контроллера');
        } 
        return $result. "Controller";
    }
    
}
