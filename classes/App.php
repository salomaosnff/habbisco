<?php

/**
 * Created by PhpStorm.
 * User: sallon
 * Date: 05/05/17
 * Time: 11:48
 */
class App{
    private $db;
    private $url;
    private $args;

    /**
     * App constructor.
     */
    public function __construct(){
        $this->url = '/'.trim($_GET['request'] ?? '', "\\/\s");
        $this->db = Fn::$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Configuração da view
        View::setPath(VW_PATH);
        View::setDefaultTheme(VW_THEME);
        View::loadTheme();

        // Carrega o controller
        $this->loadController();
    }

    /**
     * Carrega o controlador
     */
    public function loadController(){
        $xcontroller = array_filter(explode("/", $this->url)); // Divide a url
        $args        = array_slice($xcontroller, 2); // Pega os argumentos

        // Valida o Controller
        $controller  = $this->url == '/' ? 'index' : $xcontroller[1];
        $controller  = strtolower(preg_replace("/[^a-z0-9\-]/i", "", $controller))."-Controller";
        $controller  = ucwords($controller, "-");
        $controller  = str_replace("-", "", $controller);

        // Validada a ação do controller
        $action      = $xcontroller[2] ?? "index";
        $action      = preg_replace("/[^a-z0-9\-\s]/i", "", $action);
        $action      = preg_replace("/\s/i", "-", $action);

        // Se existir, carregar o controlador
        if(class_exists($controller) && method_exists($controller, $action)){
            $controller = new $controller($controller, $args);
            $controller->$action();
        } else { // Se não...
            // Erro 404
            echo "404";
        }
    }
}