<?php

/**
 * Created by PhpStorm.
 * User: sallon
 * Date: 05/05/17
 * Time: 11:53
 */
class View{
    private static $global_vars;
    private static $theme = 'default';
    public static $theme_path;
    private static $views_path;
    private static $layout;
    private $__view_path;
    private $__theme;
    private $__name;

    /**
     * View constructor.
     * @param $name
     */
    public function __construct(string $name){

        $this->__theme      = self::$theme;

        self::$theme_path = self::$views_path.'/'.$this->__theme.'/';

        $this->__name       = $name;
        $this->__view_path  = self::$theme_path.$name.'.view.php';
    }

    /**
     * Define os dados da view
     * @param array $vars
     * @return $this
     */
    public function __setVars(array $vars){
        foreach (self::$global_vars as $var => $value){
            $this->$var = $value;
        }

        foreach ($vars as $var => $value){
            $this->$var = $value;
        }

        return $this;
    }

    /**
     * Renderiza a view
     * @return bool
     */
    public function __render(){
        $layout_file = self::$theme_path.self::$layout.'.view.php';

        if(file_exists($layout_file)) include_once $layout_file;
        else $this->__content();

        return file_exists($this->__view_path);
    }

    /**
     * Renderiza o conteúdo da view
     */
    public function __content(){
        if (file_exists($this->__view_path)) include_once $this->__view_path;
        else View::error("A view '{$this->__name}' não existe no tema '{$this->__theme}'.");
        return file_exists($this->__view_path);
    }

    /**
     * Define o tema da view
     * @param $name
     */
    public function setTheme(string $name){
        var_dump($name);
        $this->__theme = $name;
    }

    /**
     * Define o tema padrão das views
     * @param $name
     * @return string
     */
    public static function setDefaultTheme(string $name){
        self::$theme = $name;
        self::$theme_path = self::$views_path.'/'.$name;

        return $name;
    }

    /**
     * Define o diretório das views
     * @param $path
     * @return mixed
     */
    public static function setPath(string $path){
        return self::$views_path = $path;
    }

    /**
     * Exibe um erro
     * @param $message
     */
    public static function error(string $message){
        echo "<h1>Falha na Engine de Views:</h1>";
        echo "<p>$message</p>";
    }

    public static function loadTheme(){
        $bootstrap_file = self::$theme_path.'/'.self::$theme.'.theme.php';

        if(file_exists($bootstrap_file)) include_once $bootstrap_file;
    }

    /**
     * Define o arquivo de view base
     * @param $name
     * @return string
     */
    public static function setLayout(string $name){
        self::$layout = $name;
        return $name;
    }

    /**
     * Define as variáveis globais do tema
     * @param array $vars
     * @return array
     */
    public static function setGlobalVars(array $vars){
        self::$global_vars = $vars;
        return $vars;
    }
}