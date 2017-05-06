<?php

/**
 * Created by PhpStorm.
 * User: sallon
 * Date: 05/05/17
 * Time: 18:16
 */
class RegisterController extends Controller{

    // Ação Padrão
    public function index(){

        // Via GET mostra a página de registro
        $this->method('GET', function(){
            $this->render('register');
        });

        // Via POST cadastra o usuário
        $this->method('POST', function(){

            $user = new UserModel([
                'username' => 'salomao',

            ]);

            $user->save();

            var_dump($user);
        });
    }
}