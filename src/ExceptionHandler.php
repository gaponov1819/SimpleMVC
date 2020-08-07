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
    
    /**
     * Метод обработки исключения. Проверяет существует ли пользовательский обработчик.
     * Если пользовательский обработчик найден, то исключение передаётся ему на обработку.
     * Если пользовательского обработчика нет то исключение никак не обрабатывается.
     * @param \Exception $exception
     * @return void
     * @throws \Exception
     */
    public function handleException(\Exception $exception): void
    {
        $handlers = Config::get('core.handlers');
        
        if(array_key_exists(get_class($exception), $handlers)){
            $exceptionName = get_class($exception);
            $thatHandler = Config::getObject('core.handlers.'.$exceptionName);
            $thatHandler->handleException($exception);
        } else {
            throw $exception;
        }
    }
}
