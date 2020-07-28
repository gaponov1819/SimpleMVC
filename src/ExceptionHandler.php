<?php

namespace ItForFree\SimpleMVC;

use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\interfaces\ExceptionsHandler;

class ExceptionHandler implements ExceptionsHandler
{
    public function __construct()
    {
        set_exception_handler(array($this, 'handleException'));
    }

    public function handleException(\Exception $exception): void
    {
        $handlers = Config::get('core.handlers');
        foreach ($handlers as $exceptionName => $handlerName){
            if ($exceptionName == get_class($exception)){
                $thatHandler = Config::getObject('core.handlers.'.$exceptionName);
                $thatHandler->handleException($exception);
            }else{
                $this->displayException($exception);
            }
        }
    }

    public function displayException($exception)
    {      
        return $exception;
        $route = 'error/';
        
        $Router = Config::getObject('core.router.class');
        $Router->callControllerAction($route, $exception);        
    }
}
