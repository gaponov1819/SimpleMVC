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
   public $basePath = 'test-source-path/';
   
   public $js = [];
   
   public $css = [];
   
   /**
    * Добавляет ресурсы (информацию о них) данного пакета к глобальному списку, который 
    * далее можно будет распечатать в шаблоне с помощью
    * класса SimpleAssetManager
    */
   public static function add()
   {
       $name = get_called_class();
       $Asset = new $name;
       $Asset->basePath = Path::addToDocumentRoot($Asset->basePath); // делаем относительный путь абсолютным
       if (!is_dir($Asset->basePath)) {
            throw new \Exception("Source asset dir {$Asset->basePath} not exists for " . get_class($Asset) ."! ");
       }
       SimpleAssetManager::addAsset($Asset);
   }

  
   public function publish()
   {
       $baseAssetPublishPath = SimpleAssetManager::getPublishBasePath() . LengthHash::md5(static::class, 10);
//       pdie($baseAssetPublishPath);
       

       Directory::createRecIfNotExists($baseAssetPublishPath, 0777);
       
       $lastChangeFileTimestamp = $this->getLastChangeFileTimestamp();
       
//       pdie($lastChangeFileTimestamp); 
       $baseAssetTimePath = $baseAssetPublishPath 
            . DIRECTORY_SEPARATOR . $lastChangeFileTimestamp;
       
          
       if (is_dir($baseAssetTimePath)) {
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
            $pubFolderPath = $basePublishPath . 'js/' ;
            Directory::createRecIfNotExists($pubFolderPath, 0777);
            
            $fullPubPath = $pubFolderPath . Path::getFileName($filePath);
            $fullSourcePath = $assetSourcePath . DIRECTORY_SEPARATOR . $filePath;
//            ppre($fullSourcePath);
//            pdie($fullPubPath);
            copy($fullSourcePath, $fullPubPath); 
        }
        
        foreach ($this->css as $filePath) {
            $pubFolderPath = $basePublishPath . 'css/' ;
            Directory::createRecIfNotExists($pubFolderPath, 0777);
            
            $fullPubPath = $pubFolderPath . Path::getFileName($filePath);
            $fullSourcePath = $assetSourcePath . DIRECTORY_SEPARATOR . $filePath;
            copy($fullSourcePath, $fullPubPath); 
        }
   }

   protected function getLastChangeFileTimestamp()
   {
        $assetSourcePath = $this->basePath;
        
        $lasttime = 0;

        foreach ($this->js as $filePath) {
            $fullPath = $assetSourcePath . DIRECTORY_SEPARATOR . $filePath;
//            ppre($fullPath);
            $currentLastTime = filemtime($fullPath);
            
            if ($lasttime < $currentLastTime) {
                $lasttime = $currentLastTime;
            }
        }
        
        foreach ($this->css as $filePath) {
            $fullPath = $assetSourcePath . DIRECTORY_SEPARATOR . $filePath;
            $currentLastTime = filemtime($fullPath);
            
            if ($lasttime < $currentLastTime) {
                $lasttime = $currentLastTime;
            }
        }
        
//        pdie($lasttime);
        
        return $lasttime; 
   } 
}
