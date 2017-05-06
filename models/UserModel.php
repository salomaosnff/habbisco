<?php

/**
 * Created by PhpStorm.
 * User: sallon
 * Date: 05/05/17
 * Time: 18:51
 */
class UserModel extends Model {
    /**
     * User constructor
     * @param $data
     */
    public function __construct($data){
        $this->__data__ = (array) $data;
        $this->__fields__ = array_keys($data);

        parent::__construct('users', 'id', $data);
    }


}
// Antes de salvar o usuário, crie um hash e um salt para ele
UserModel::pre('save', function($user){
    if(!$user->password) return;

    $hash = Secure::hash($user->password);

    $user->password = $hash->hash;
    $user->salt     = $hash->salt;
});