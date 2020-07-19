<?php

namespace ItForFree\SimpleMVC;
use ItForFree\SimpleMVC\Application;

class ExceptionHandler
{
    public function __construct()
    {
        set_exception_handler(array($this, 'handleException'));
    }

    public function handleException(\Exception $exception): void
    {
        restore_error_handler();
        restore_exception_handler();
        $this->displayException($exception);
    }

    public function displayException($exception)
    {        
        $route = "error/";
        
        $Router = Application::getConfigObject('core.router.class');
        $Router->callControllerAction($route, $exception);        
    }
}
