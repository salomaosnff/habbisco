<?php

// Retorna a configuração ou exibe um erro
function __cms_config_data($settings, $name){
    if($name === true) return;

    if(isset($settings[$name])){
        return $settings[$name];
    } else {
        throw new Error("Configuração '{$name}' não não existe.");
    }
}
/**
 * Class Fn
 * @property Database $db
 */
class Fn {
    // Db connection
    public static $db;
    private static $cms_setings;

    /**
     * Get or set CMS Setting
     * @param $name
     * @param null $value
     * @return object
     */
    public static function cms_config($name, $value=null){
        // Já foram carregadas as configurações ou força a atualização do cache
        if(self::$cms_setings == null || $name === true){
            self::$cms_setings = [];

            $settings = self::$db->pquery('SELECT `name`, `value` from `cms_settings`');
            $settings = $settings->fetchAll(PDO::FETCH_OBJ);

            foreach ($settings as $i => $setting){
                self::$cms_setings[$setting->name] = $setting->value;
            }
        }

        // Se for definido um valor, atualizar a configuração
        if($value !== null && $name !== true){
            self::$db->pquery('UPDATE cms_settings SET `value`=? WHERE `name`=?', $value, $name);
            self::$cms_setings[$name] = $value;
        }

        return __cms_config_data(self::$cms_setings, $name);
    }
}