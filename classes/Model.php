<?php
/**
 * Created by PhpStorm.
 * User: sallon
 * Date: 05/05/17
 * Time: 19:08
 */
abstract class Model{
    protected $__table__;
    protected $__data__;
    protected $__fields__;
    protected $__pk__;
    private static $__pre__ = [];

    /**
     * Model constructor.
     * @param $table
     * @param $pk
     * @param $data
     * @return Model
     */
    public function __construct($table, $pk, $data){
        $this->__table__  = $table;
        $this->__pk__     = $pk;
        $this->construct($data);
    }

    /**
     * Salva o model no banco de dados
     */
    public function save(){
        self::__run_pre__(__FUNCTION__, $this);

        $data = array_values($this->__data__);
        return Fn::$db->insert($this->__table__, $this->__fields__, $data);
    }

    /**
     * Atualiza os dados do model no banco de dados
     */
    public function update(){
        self::__run_pre__(__FUNCTION__, $this);

        $stmt = "UPDATE `{$this->__table__}` SET `".join("`=?,`", $this->__fields__)."`=? WHERE `{$this->__pk__}`=?";
        $params = array_values(array_merge($this->__data__, [$this->__data__[$this->__pk__]]));

        var_dump($stmt, $params);

        return Fn::$db->pquery($stmt, $params);
    }

    /**
     * Apaga o model do banco de dados
     */
    public function delete(){
        self::__run_pre__(__FUNCTION__, $this);

        $stmt = "DELETE FROM `{$this->__table__}` WHERE `{$this->__pk__}`=?";
        return Fn::$db->pquery($stmt, $this->__data__[$this->__pk__]);
    }

    /**
     * Atualiza o cache do objeto
     */
    public function read(){
        self::__run_pre__(__FUNCTION__, $this);

        $stmt = "SELECT * FROM `{$this->__table__}` WHERE `".join('`=? AND `', $this->__fields__)."`=? LIMIT 1";
        $stmt = Fn::$db->pquery($stmt, array_values($this->__data__));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->destroy();
        $this->construct($data);

        return $stmt;
    }

    /**
     * Define dados da instância
     * @param $data
     */
    public function construct($data){
        $this->__fields__ = array_keys($data);

        foreach ($data as $property => $value){
            $this->$property = $value;
        }
    }

    /**
     * Apaga a instância do model
     */
    public function destroy(){
        self::__run_pre__(__FUNCTION__, $this);

        // Ignorar propriedadas da própria classe
        $ignore       = array_merge(get_class_vars(self::class));
        $properties   = get_object_vars($this);
        $properties   = array_keys($properties);

        foreach($properties as $property){
            if(!in_array($property, $ignore)){
                unset($this->$property);
            }
        }

        return $this;
    }

    /**
     * Define uma função a ser chamada antes de executar uma ação
     * @param $action
     * @param $callback
     */
    public static function pre($action, $callback){
        self::$__pre__[$action] = $callback;
    }

    /**
     * Executa uma definida função antes de executar uma ação
     * @param $action
     * @param $instance
     */
    public static function __run_pre__($action, &$instance){
        $function = self::$__pre__[$action] ?? function(){};
        $function($instance);
    }
}