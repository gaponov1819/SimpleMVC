<?php
namespace ItForFree\SimpleMVC;

/**
 * Класс-маршрутизатор, его задача по переданной строке (предположительно это какой-то адресе на сайте),
 * определить какой контролеер и какое действие надо вызывать.
 */

class Router
{

    /**
     * Вызовет действие контроллера, разобрав переданный маршрут
     * 
     * @param srting $route маршрут: Любая строка (подразумевается, что это url или фрагмент), по которой можно определить вызываемый контроллер (класс) и его действие (метод)
     * @return $this
     */
    public function callControllerAction($route)
    {
        $controllerName = "\\application\\controllers\\" . self::getControllerClassName($route);
        $controller = new $controllerName();
        $controller->callAction($route);
        
        return $this;
    }
    
    
    public static function getControllerClassName($route)
    {
        $result = 'Homepage';
                
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
