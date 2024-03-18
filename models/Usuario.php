<?php

namespace Model;

class Usuario extends ActiveRecord{

    protected static $tabla ='usuarios';
    protected static $columnasDB =['id','nombre','email','password','token','confirmado'];

    public function __construct($args =[]){

        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }

    public function validarNuevaCuenta(){
        if (!$this->nombre) {
            self::$alertas['error'][]='El nombre del Usuario es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][]='El Email del Usuario es Obligatorio';
        }

        if (!$this->password) {
            self::$alertas['error'][]='El Password no puede ir Vacio';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][]='El Password tiene que tener mas de 6 caracteres';
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'][]='Los Passwords no Coinciden';
        }


        return self::$alertas;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);


    }

    public function crearToken(){
        $this->token=uniqid();
    }
}