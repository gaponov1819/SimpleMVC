<?php

namespace ItForFree\SimpleMVC;

use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\interfaces\ExceptionHandlerInterface;

class ExceptionHandler implements ExceptionHandlerInterface
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
                throw $exception;
            }
        }
    }

}
