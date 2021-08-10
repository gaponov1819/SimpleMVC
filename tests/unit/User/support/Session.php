<?php

namespace application\models\user;

/**
 * Класс для работы с массивом $_SESSION
 * 
 * @todo Проверить на проблему блокировки сессии: @see http://php.net/manual/ru/session.examples.basic.php
 *
 * @author qwe
 */
class Session extends \ItForFree\SimpleMVC\Session
{
    public $session = null; //$_SESSION
       
    public $user = null;
    /**
    * Вернёт объект класса Session
    * 
    * @staticvar type $instance
    * @return \static
    */
    public static function get()
    {
        static $instance = null; // статическая переменная
        if (null === $instance) { // проверка существования
            $instance = new static();
        }
        return $instance;
    }
    
    /*скрываем конструктор
    - для того чтобы класс нельзя было создать в обход getInstance */
    public function __construct()
    {   
        session_start();
        $this->session = &$_SESSION;
    }
    
}
