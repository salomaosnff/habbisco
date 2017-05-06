<?php
/**
 * name: Habbisco Default
 * description: Tema padrão da CMS
 * author: Habbisco
 * updates: http://github.com/habbisco/themes/habbisco
 */

define('THEME_PATH', View::$theme_path);

View::setLayout('__layout__');
View::setGlobalVars([
    'title' => "View sem título",
    'metas' => [],
    'links' => [],
    'css'   => [
        THEME_PATH.'/css/layout.css'
    ],
    'js'    => [],
    'fjs'   => []
]);