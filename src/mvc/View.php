<?php

namespace ItForFree\SimpleMVC\mvc;
use ItForFree\SimpleMVC\Config;

/**
 * Элементарный класс для работы с представлениями
 * -- позволят отделить HTML от PHP 
 */
class View 
{
    /**
     * @var string Стандартный путь к корневому каталогу шаблонов (view) 
     */
    public $templateBasePath = '/';
    
    /**
     * @var array Массив, содержащий все переменные программы для их 
     * транспортировки из области видимости контроллеров в представления
     */
    private $vars = [];
    
    /**
     * @var string Путь к общему "подвалу" сайта
     */
    public $footerFilePath = 'footer.php'; 
    
    /**
     * @var string Путь к общей "шапке" сайта
     */
    public $headerFilePath = 'header.php';
   
    /**
     * Задаёт путь к корневому каталогу
     */
    public function __construct() {
        $this->templateBasepath = 
            rpath(Config::get('core.mvc.views.base-template-path'));
        $this->footerFilePath = 'footer.php';
        $this->headerFilePath = 'header.php';
        
    }

    /**
     * Добавить переменную в шаблон
     * 
     * @param type $name
     * @param type $value
     */
    public function addVar($name, $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * Формирует окончательное представление страницы. 
     * Собирает базовый HTML
     * и индивидуальный для каждой страницы
     * 
     * @param string Путь к целевой странице
     */
    public function render($path, $text = '')
    {
        extract($this->vars);
               
        include($this->templateBasepath . $this->headerFilePath);
        
        echo $text;
        
        include($this->templateBasepath . $path);
        
        include($this->templateBasepath . $this->footerFilePath);
        
    }
    
    /**
     * Формирует частичную печать страницы. 
     * Собирает базовый HTML
     * и индивидуальный для каждой страницы
     * 
     * @param string Путь к целевой странице
     */
    public function renderPartition($path)
    {
        extract($this->vars);
                
        include($this->templateBasePath . $path);
        
    }
    
    
}

