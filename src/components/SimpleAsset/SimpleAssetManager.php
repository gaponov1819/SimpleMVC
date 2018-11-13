<?php

namespace ItForFree\SimpleMVC\components\SimpleAsset;

/**
 * Используется, в частности для непостредственого отображения CSS и JS
 */
class SimpleAssetManager
{
    public static $assetsPath = 'assets/';
    
    /**
     * Данные об используемых js файлвх
     * @var array 
     */
    protected static $jsList = [];
    
    /**
     * Данные об используемых CSS файлах
     * @var array
     */
    protected static $cssList = [];
    
    /**
     * Массив объектов-ассетов, которые нужно будет использовать на странице 
     * (на которых был вызван метод ->add())
     * 
     * @var array объектов ItForFree\SimpleMVC\components\SimpleAsset\SimpleAsset
     */
    protected static $assets = [];
    
    public static function printJs()
    {
        static::publishJs();
        
        foreach (static::$jsList as $js) {
            echo("<script type=\"text/javascript\" src=\"$js\"></script>\n");
        }
    }
    
    /**
     * Добавит ассет в глобальный список (зарегистрирует его)
     * 
     * @param \ItForFree\SimpleMVC\components\SimpleAsset\SimpleAsset $SimpleAssetObject
     */
    public static function addAsset($SimpleAssetObject)
    {
        static::$assets[] = $SimpleAssetObject;
        
        foreach ($SimpleAssetObject->js as $jsFile) {
            static::$jsList[] = [
                'source' => $jsFile,
                'assetClassName' => $SimpleAssetObject::class,

            ];
        }
        $SimpleAssetObject->publish();
    }

    protected static function publishJs()
    {
        
    }
}
