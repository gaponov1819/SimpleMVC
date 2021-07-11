<?php

namespace application\models;

/**
 * Пример реализации класса пользователя (реализуем требующие этого методы абстрактные методы)
 * Эту модель наследуем от специального класа-модели User из ядра SimpleMVC
 */
class ExampleUser extends \ItForFree\SimpleMVC\User 
{
    public function __construct()
    {
        parent::__construct(); 
    }
    
    protected function checkAuthData($login, $pass) 
    {
    }
  
    protected function getRoleByUserName($userName)
    {
    }
}
