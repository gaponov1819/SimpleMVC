<?php
namespace ItForFree\SimpleMVC\interfaces;

/**
 *  Интерфейс для классов обработки ошибок
 */
interface ExceptionHandlerInterface
{
    /**
     * Метод для обработки перехваченной ошибки
     * 
     * @param \Exception $exception
     */
    public function handleException(\Exception $exception);
}
