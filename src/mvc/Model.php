<?php

namespace ItForFree\SimpleMVC\mvc;

use ItForFree\SimpleMVC\Config as Config;
use ItForFree\SimpleMVC\Application;
use ItForFree\rusphp\Log\SimpleEchoLog;

/**
 * Базовый класс для модолей: используя конфиг приложения, как минимум подключается к базе данных и даёт 
 * потомкам работать с соединением.
 */
class Model 
{
    /**
     * @var object Хранит соединение с БД
     */
    public $pdo;
   
    /**
     * @var string Имя обрабатываемой таблицы 
     */
    public $tableName = '';
    
    
    /**
     *  @var string Имя поля по котору сортируем
     */
    public $orderBy = '';
    
    /**
    * @var int ID сущности в базе данных
    */
    public $id = null;

    /**
     * 
     * @param array $data необязательный массив для инициаллизации свойств объекта модели
     */
    public function __construct($data = null) 
    {
        $this->setPdoSettings();
        if (is_array($data)) {
            $this->setObjectVars($this, $data);
        }
    }
    
   /**
    * Присваивает свойствам объекта, соответствующие по имена ключей значений из массива
    */
    private function setObjectVars($object, array $vars) 
    {
        $has = get_object_vars($object);
        foreach ($has as $name => $oldValue) {
            $object->$name = isset($vars[$name]) ? $vars[$name] : $object->$name; 
        }
    } 
    
    /**
     * Устанавливает настройки доступа к БД и сохраяет объект PDO в одноименное свойство модели
     *  ($this->pdo)
     */
    protected function setPdoSettings()
    {
        $dbSettings = Application::getConfigElement('core.db');
        $this->pdo = new \PDO($dbSettings['dns'], 
                $dbSettings['username'],
                $dbSettings['password'],
                array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
        );
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
   
    /**
     * Получает из БД все поля одной строки таблицы, с соответствующим Id
     * Возвращает объект класса модели
     * @param int $id  id строки
     * @param string   $tableName  имя таблицы (необязатлеьный параметр)
     * 
     * @return \ItForFree\SimpleMVC\mvc\Model
     */
    public function getById($id, $tableName = '')
    {  
        $tableName = !empty($tableName) ? $tableName : $this->tableName;
        
        $sql = "SELECT * FROM $tableName where id = :id";      
        $modelClassName = static::class;
        
        $st = $this->pdo->prepare($sql); 
        
        $st->bindValue(":id", $id, \PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();
        
        if ($row) { 
            return new $modelClassName( $row );
        } else {
            return null;
        }
    }
   
    /**
    * Возвращает все (или диапазон) объекты Article из базы данных
    *
    * @param int Optional Количество возвращаемых строк (по умолчанию = all)
    * @param int Optional Вернуть статьи только из категории с указанным ID
    * @param string Optional Столбц, по которому выполняется сортировка статей (по умолчанию = "publicationDate DESC")
    * @return Array|false Двух элементный массив: results => массив объектов Article; totalRows => общее количество строк
    */
        
    public function getList($numRows=1000000)  
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $this->tableName
                ORDER BY  $this->orderBy LIMIT :numRows";
        
        $modelClassName = static::class;
       
        $st = $this->pdo->prepare($sql);
        $st->bindValue( ":numRows", $numRows, \PDO::PARAM_INT );
        $st->execute();
        $list = array();
        
        while ($row = $st->fetch()) {
            $example = new $modelClassName($row);
            $list[] = $example;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows"; //  получаем число выбранных строк
        $totalRows = $this->pdo->query($sql)->fetch();
        return (array ("results" => $list, "totalRows" => $totalRows[0]));
    }
    
    /**
     * Метод для пейджинации данных из БД
     * 
     * @param int $pageNumber  номер страницы
     * @param int $limit       число элементов на странице
     * @return array           массив  кортежей из БД
     */
    public function getPage($pageNumber = 1, $limit = 2)
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $this->tableName
                ORDER BY  $this->orderBy LIMIT :limit OFFSET :offset";

        $modelClassName = static::class;
        $offset = ($pageNumber - 1)*$limit;

        $st = $this->pdo->prepare($sql);
        $st->bindValue( ":limit", intval($limit), \PDO::PARAM_INT );
        $st->bindValue( ":offset", intval($offset), \PDO::PARAM_INT );

        $st->execute();
        
        while ( $row = $st->fetch() ) {
            $example = new $modelClassName( $row );
            $list[] = $example;
        }
       // Получаем общее количество статей, которые соответствуют критерию
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $this->pdo->query( $sql )->fetch();
        return array("results" => $list, "totalRows" => $totalRows[0]);
    }
  
    /**
     * 
     * @todo проверить нужность.
     * 
     * @param type $arr
     * @return \ItForFree\SimpleMVC\mvc\modelClassName
     */
    public function loadFromArray($arr)
    {
        $modelClassName = static::class;
        return new $modelClassName($arr);
    }
    
    /**
    * Удаляем текущий объект статьи из базы данных
    */
    public function delete() 
    {
        $st = $this->pdo->prepare("DELETE FROM $this->tableName WHERE id = :id LIMIT 1" );
        $st->bindValue( ":id", $this->id, \PDO::PARAM_INT );
        $st->execute();
    }   
}
