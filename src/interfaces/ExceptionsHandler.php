<?php
namespace ItForFree\SimpleMVC\interfaces;

/**
 *  Интерфейс для классов обработки ошибок
 */
interface ExceptionsHandler
{
    /**
     * 
     * @param \Exception $exception
     */
    public function handleException(\Exception $exception);
}
