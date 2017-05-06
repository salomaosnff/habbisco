<?php

/**
 * Created by PhpStorm.
 * User: sallon
 * Date: 05/05/17
 * Time: 13:24
 */
abstract class Controller{
    private $args;
    private $name;

    /**
     * Controller constructor.
     * @param $name
     * @param $args
     */
    public function __construct($name, $args){
        $this->name = $name;
        $this->args = $args;
    }

    /**
     * Renderiza uma view
     * @param $viewname
     * @param array $data
     */
    public function render($viewname, $data = []){
        $view = new View($viewname);
        $view->__setVars($data);
        $view->__render();
    }

    /**
     * Default action
     */
    public function index(){
        echo "<h1>{$this->name} está pronto!</h1><p>O Controlador '{$this->name}' está pronto, sobreescreva o método index para remover esta mensagem.</p>";
    }

    /**
     * Executa o callback de acordo com o tipo de requisição
     * @param $method
     * @param $callback
     * @return null
     */
    public function method($method, $callback){
        $method = strtoupper($method);
        if($_SERVER['REQUEST_METHOD'] === $method) return $callback();
        return null;
    }
}