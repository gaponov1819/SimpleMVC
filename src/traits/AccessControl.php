<?php
namespace ItForFree\SimpleMVC\traits;


use \ItForFree\SimpleMVC\User;
use ItForFree\SimpleMVC\exceptions\SmvcAccessException;
use ItForFree\SimpleMVC\exceptions\SmvcUsageException;


/* 
 * Система контроля доступа
 */
trait AccessControl {
     
    /**
     * Массив, содержащий имена методов, доступных пользователю с данной ролью
     * (должен переопределяться в контроллерах)
     * @var array 
     */ 
    protected $rules = [];

    /**
     * Запускает метод класса ***Controller полученный через GET-параметр
     * @param type 
     */
    public function callAction($route) 
    {
        $actionName = $this->getControllerActionName($route);

          
        if ($this->isEnabled($route, $actionName)) {
            $methodName =  $this->getControllerMethodName($actionName);
            
            if (!method_exists($this, $methodName)) {
                throw new SmvcUsageException("Метод контроллера для данного действия не найден.");
            }

            
            $this->$methodName();
        } else {
            throw  new SmvcAccessException("Доступ к маршруту $route запрещен.");
        }
    }
    
    /**
     * Проверит разрешено ли текущему пользователю использовать данный маршрут
     * 
     * @param string $route  маршрут
     * @param string $actionName имя дествия (как в маршруте)
     * @return boolean разрешено ли текущему пользователю
     */
    public function IsEnabled($route, $actionName)
    {
        if ($this->isRules($route)) {
            $rules = $this->rules;
            $currentRole = User::get()->role;

            
            // Сначала проверим, есть ли правило конкретно для данного действия
            if (!empty($rules[$actionName])) {
                if (!empty($rules[$actionName]['deny'])) {
                    foreach ($rules[$actionName]['deny'] as $k => $role) {  // перебираем имена ролей пользователей
                        if ($currentRole == $role) {
                            return false;
                        }
                    }
                }   
                if (!empty($rules[$actionName]['allow'])) {
                    foreach ($rules[$actionName]['allow'] as $k => $role) { // перебираем имена ролей пользователей
                        if ($currentRole == $role) {
                            return true;
                        }
                    }
                }
            }
            
            // Если правил для конкретного действия не оказалось - -смотрим глобальные правила контролеера для всех ролей
            if (!empty($rules['all'])) {
                if (!empty($rules['all']['deny'])) {
                    foreach ($rules['all']['deny'] as $k => $action) { // перебираем имена действий
                        if ($actionName == $action) {
                            return false;
                        }
                    }
                }   
                if (!empty($rules['all']['allow'])) {
                    foreach ($rules['all']['allow'] as $k => $action) {  // перебираем имена действий 
                        if ($actionName == $action) {
                            return true;
                        }
                    }
                }
            }
        }

        return true; // В данном контроллере правил нет, или разрешено всем, для текущей роли нет запрещающего указания.
    }
    
    /**
     * Есть ли правила в данном контроллере
     */
    private function isRules($route)
    {
        $controllerClassName = "\\application\\controllers\\" . \ItForFree\SimpleMVC\Router::getControllerClassName($route);
        $controller = new $controllerClassName();
        if (!empty($controller->rules)) {
            return true;
        }
        return false;
    }
    
    /**
     * Возвращает массив с правилами данного контроллера 
     * @return array['action'] = 'user'
     */
    public function getControllerRules()
    {
        return $this->rules;
    }
    
     /**
     * Формирует полное имя метода контроллера по GET-параметру
     * @param type $route -- строка GET-параметр
     */
    public function getControllerActionName($route)
    {
        $result =  'index';
         
        $urlFragments = explode('/', $route);
        $n = count($urlFragments);
        if (!empty($urlFragments[$n-1])) {
            $result = $urlFragments[$n-1];
        } 
         
         return $result;
    }
    
    
    /**
     * Формирует имя метода контроллера по GET-параметру
     * @param type $action -- строка GET-параметр
     */
    public function getControllerMethodName($action)
    {
        return $action . 'Action';
    }
    

}
    
