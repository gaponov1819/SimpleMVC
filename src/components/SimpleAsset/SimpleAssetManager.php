<?php

namespace ItForFree\SimpleMVC\components\SimpleAsset;

/**
 * Используется, в частности для непостредственого отображения CSS и JS
 */
class SimpleAssetManager
{
    protected $jsList = [];
    
    protected $cssList = [];
    
    public static function printJs()
    {
        foreach (static::$jsList as $js) {
            echo("<script type=\"text/javascript\" src=\"$js\"></script>\n");
        }
    }
    
    /**
     * Добавит ассет в глобальный список
     * 
     * @param type $SimpleAssetObject
     */
    public static function addAsset($SimpleAssetObject)
    {
        
    }
}
