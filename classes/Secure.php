<?php

/**
 * Created by PhpStorm.
 * User: sallon
 * Date: 06/05/17
 * Time: 09:59
 */
class Secure
{
    /**
     * Gera um hash e um salt a partir de uma string
     * @param $data
     * @param bool $salt
     * @param int $salt_length
     * @return object
     */
    public static function hash($data, $salt=false, $salt_length=0){
        $salt_length = round($salt_length);

        if($salt === false){
            $salt_length = $salt_length > 0 ? $salt_length : round(random_int(4, 16));
            $salt = random_bytes($salt_length);
            $salt = hash('sha256', $salt);
        }

        $hash = $salt.$data.$salt;
        $hash = hash('sha512', $hash);

        return (object) [
            'hash' => $hash,
            'salt' => $salt
        ];
    }

    /**
     * Compara um dado com um hash e um salt
     * @param $data
     * @param $hash
     * @param $salt
     * @return bool
     */
    public static function hash_compare($data, $salt, $hash){
        $hash_test = self::hash($data, $salt);
        return $hash_test->hash === $hash;
    }
}


