<?php
namespace ItForFree\SimpleMVC;

use ItForFree\rusphp\PHP\ArrayLib\DotNotation\Dot;
use ItForFree\SimpleMVC\ExceptionHandler;
use ItForFree\SimpleMVC\exceptions\SmvcUsageException;
use ItForFree\SimpleMVC\exceptions\SmvcConfigException;
use ItForFree\rusphp\PHP\Object\ObjectFactory;
use ItForFree\rusphp\PHP\ArrayLib\Structure;

/**
 * Класс-"точка входа" для работы фреймворка SimpleMVC
 * 
 * Реализует паттерн "Одиночка" @see http://fkn.ktu10.com/?q=node/5572
 */
class Application
{
    /**
     * Массив конфигурации приложенияъ
     * 
     * @var ItForFree\rusphp\PHP\ArrayLib\DotNotation\Dot
     */
    protected $config = null;

    
    /**
     * Cкрываем конструктор для того чтобы класс нельзя было создать в обход get() 
     */
    protected function __construct() {}
    
    /**
     * Метод для получения текущего объекта приложения
     * 
     * @staticvar type $instance
     * @return ItForFree\SimpleMVC\Applicaion объект приложения
     */
    public static function get()
    {
        static $instance = null; // статическая переменная
        if (null === $instance) { // проверка существования
            $instance = new static();
        }
        return $instance;
    }
 
    /**
     * Запускает функционал ядра, 
     * именно этот метод должно вызвать приложение, использущее SimpleMVC 
     * для запуска системы
     * 
     * @return $this
     * @throws SmvcCoreException
     */
    public function run() {
        
        $exceptionHandler = new ExceptionHandler();
        try{
            if (!empty($this->config)) {
                $route = $this->getConfigObject('core.url.class')::getRoute();
                /**
		 * @var \ItForFree\SimpleMVC\Router
		 */
                $Router = $this->getConfigObject('core.router.class');
                $Router->callControllerAction($route); // определяем и вызываем нужно действие контроллера
            } else {
                throw new SmvcCoreException('Не задан конфигурационный массив приложения!');
            }

            return $this;   
        } catch (\Exception $exc) {
            $exceptionHandler->handleException($exc);
        }
    }
    
    /**
     * Устанавливает конфигурацию приложения из массива
     * 
     * @param  array $config многомерный массив конфигурации приложения
     * @return $this
     */
    public function setConfiguration($config)
    {
        $this->config = new Dot($config);
        return $this;
    }
    
    /**
     * Вернёт элемент из массива конфигурации приложения
     * 
     * @param string $inConfigArrayPath ключ в виде строки, разделёной точками -- путь в массиве
     * $withException - флаг, кторый определяет омежт ли бросать исключения метод или нет
     * @return mixed
     */
    public static function getConfigElement($inConfigArrayPath, $withException = true)
    {
        if (empty(self::get()->config)) {
            throw new SmvcUsageException('Не задан конфигурационный массив приложения!');
        }
        
        $configValue = self::get()->config->get($inConfigArrayPath);
       
        if ($withException && is_null($configValue)) {
           throw new SmvcConfigException("Элемент с данным путём [$inConfigArrayPath]"
                   . " отсутствует в конфигурационном массиве приложения!");
        }
        
        return $configValue;
    }
    
    /**
     * Создаст и вернёт объект по его имени из массива
     * 
     * @param string $inConfigArrayPath ключ в виде строки, разделёной точками -- путь в массиве
     * @return mixed                    $a[] = $param;
     */
    public static function getConfigObject($inConfigArrayPath)
    {
        $params = array();
        $publicParams = array();
        $fullClassName = self::getConfigElement($inConfigArrayPath);
        
        if (!class_exists($fullClassName)) {
            throw new SmvcConfigException("Вы  запросили получение экземпляра класса "
                . "$fullClassName "
                . " (был добавлен в конфиг по адресу $fullClassName),"
                . " но такой класс не был ранее объеляен, "
                . "убедитесь чтобы его код подключен "
                . "до  обращения к экземпляру объекта ");
        }
            $paramsPath = static::getPathParams($inConfigArrayPath);
            if($paramsPath) $params = self::getConfigElement($paramsPath, false);
            if (!empty($params)) {
                foreach($params as $param) {
                    $conf = self::get()->config;
                    if (static::isAlias($param)) {
                        $pathToTheDesiredElement = Structure::getPathForElementWithValue(self::get()->config, 'alias', $param);
                        $pathToTheDesiredElement = implode('.', $pathToTheDesiredElement) . '.class';
                        $elementInConfigByParthAlias = self::getConfigElement($pathToTheDesiredElement, false);
                        if (!empty($elementInConfigByParthAlias)) {
                            self::getConfigObject($pathToTheDesiredElement);
                        } else {
                            $param = $pathToTheDesiredElement;
                        }  
                    }
                }
            }

        return static::getInstanceOrSingletone($fullClassName, $publicParams);
    }
    
    
    protected static function getInstanceOrSingletone($className, $publicParams = [], $singletoneInstanceAccessStaticMethodName = 'get', )
    {
       $result = null;
       if (\ItForFree\rusphp\PHP\Object\ObjectClass\Constructor::isPublic($className)) {
          $result = new $className;
          if (!empty($publicParams)) {
            ObjectFactory::setPublicParams($result, $publicParams);
          }
       } else {
            $result =  call_user_func($className . '::' 
                . $singletoneInstanceAccessStaticMethodName); 
       }
       
       return $result;
    }
    
    protected static function getPathParams($PathClassName) {
        
        $pathParams = explode('.', $PathClassName);
        return $pathParams[0] . '.' . $pathParams[1] . '.' . 'params';
    }
    
    protected static function isAlias($param)
    {
        if(strpos($param, '@') === 0) return true;
    }
}
