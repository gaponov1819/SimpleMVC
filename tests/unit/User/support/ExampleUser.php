<?php

namespace application\models\user;

class ExampleUser extends \ItForFree\SimpleMVC\User 
{
    public function __construct($data = null, $session = null, $router = null)
    {
        parent::__construct($data, $session, $router); 
    }
    
    protected function checkAuthData($login, $pass) 
    {
    }
  
    protected function getRoleByUserName($userName)
    {
    }
}
