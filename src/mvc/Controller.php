<?php

namespace ItForFree\SimpleMVC\mvc;
/**
 * Базовый класс для работы с конроллерами
 */
class Controller 
{
    use \ItForFree\SimpleMVC\traits\AccessControl;
    
    /**
     * @var \ItForFree\SimpleMVC\mvc\View Хранит экземпляр класса View
     */
    public $view = null;
    
    /**
     * @var string Имя (путь относительно базовой папки шаблонов, определяемой в классе конфиге приложения) шаблона (для представлений)
     */
    public $layoutPath = 'main.php';
    
    /**
     * Создаёт экземпляр класса View для работы с представлениями
     */
    public function __construct() {
        $this->view = new View($this->layoutPath);

    }
    
    public function header($path) { // 302 редирет
        header ("Location: $path");
    }
}

