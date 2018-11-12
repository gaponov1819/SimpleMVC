<?php

namespace ItForFree\SimpleMVC\components\SimpleAsset;

use ItForFree\SimpleMVC\components\SimpleAsset\SimpleAssetManager;

/**
 * Базовый класс
 */
class SimpleAsset extends SimpleAssetManager
{
   public $basePath = '';
   
   public $js = [];
   
   public $css = [];
   
   /**
    * Добавляет ресурсы (информацию о них) данного пакета к глобальному списку, который 
    * далее можно будет распечатать в шаблоне с помощью
    * класса SimpleAssetManager
    */
   public function add()
   {
       SimpleAssetManager::addAsset($this);
   }
   
   
}
