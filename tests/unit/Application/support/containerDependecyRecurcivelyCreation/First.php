<?php
namespace application\models\dependecy;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FirstClass
 *
 * @author qwe
 */
class First {
    //put your code here
    static $countCreateObject = 0;
    
    public $property = null;
    
    public function __construct()
    {
        static::$countCreateObject++;
        $this->property = '1024';
    }
}
