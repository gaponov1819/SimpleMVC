<?php

namespace ItForFree\SimpleMVC\components\SimpleAsset;

use ItForFree\SimpleMVC\components\SimpleAsset\SimpleAssetManager;
use ItForFree\rusphp\File\Path;
use ItForFree\rusphp\PHP\Hash\LengthHash;
use ItForFree\rusphp\Common\Directory\Directory;

/**
 * Базовый класс
 */
class SimpleAsset
{
   /**
    * Путь относительно корня сайта к базовой директории
    * @var string 
    */
   public $basePath = '';
   
   public $js = [];
   
   public $css = [];
   
   /**
    * Добавляет ресурсы (информацию о них) данного пакета к глобальному списку, который 
    * далее можно будет распечатать в шаблоне с помощью
    * класса SimpleAssetManager
    */
   public static function add()
   {
       $Asset = new static();
       $Asset->basePath = Path::addToDocumentRoot($Asset->basePath); // делаем относительный путь абсолютным
       SimpleAssetManager::addAsset($Asset);
   }

  
   protected function publish()
   {
       $baseAssetPublishPath = $this->basePath . LengthHash::md5($this::class, 10);
       
       if (!is_dir($baseAssetPublishPath)) { // создаём базовую директорию, если её нет
            if(!mkdir($baseAssetPublishPath, 0777, true)) {
                throw new \Exception("Не удалось создать директорию $baseAssetPublishPath");
            }
       }
       
       $lastChangeFileTimestamp = $this->getLastChangeFileTimestamp();
       $baseAssetTimePath = $baseAssetPublishPath 
            . DIRECTORY_SEPARATOR . $lastChangeFileTimestamp;
       
       if (!is_dir($baseAssetTimePath)) {
           return; // если ничего не изменилось
       } else {
           Directory::clear($baseAssetPublishPath); // полностью очищаем родительскую директорию
           $this->copyToAssetsDir($baseAssetTimePath . DIRECTORY_SEPARATOR);
       }
   }
   
   protected function copyToAssetsDir($basePublishPath)
   {
        $assetSourcePath = $this->basePath;
        foreach ($this->js as $filePath) {
            $fullPubPath = $basePublishPath . 'js/' 
                    . DIRECTORY_SEPARATOR . $filePath;
            $fullSourcePath = $assetSourcePath . DIRECTORY_SEPARATOR . $filePath;
            copy($fullSourcePath, $fullPubPath); 
        }
        
        foreach ($this->css as $filePath) {
            $fullPubPath = $basePublishPath . 'css/' 
                    . DIRECTORY_SEPARATOR . $filePath;
            $fullSourcePath = $assetSourcePath . DIRECTORY_SEPARATOR . $filePath;
            copy($fullSourcePath, $fullPubPath); 
        }
   }

   protected function getLastChangeFileTimestamp()
   {
        $assetSourcePath = $this->basePath;
        $lasttime = null;

        foreach ($this->js as $filePath) {
            $fullPath = $assetPubPath . DIRECTORY_SEPARATOR . $filePath;
            $lasttime = filemtime($fullPath);
        }
        
        foreach ($this->css as $filePath) {
            $fullPath = $assetPubPath . $filePath;
            $lasttime = filemtime($fullPath);
        }
        
        return $lasttime; 
   } 
}
