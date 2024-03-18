<?php

namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\Usuario;

class LoginController {
    public static function login(Router $router){
      

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

        //renderizar la vista
        $router->render('auth/login',[
            'titulo'=> 'Iniciar Sesión'
        ]);


    }

    public static function logout(){
        echo "desde el logout";



    }

    public static function crear(Router $router){
        $alertas=[];
        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();//validar formulario
           
            if (empty($alertas)) {
                //si está ok el formulario verifica que no existe el usuario
                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario) {
                    Usuario::setAlerta('error','El Usuario ya está registrado');
                    $alertas = Usuario::getAlertas();
                }else{
                    //hashing password
                    $usuario->hashPassword();
                    //eliminar password2
                    unset($usuario->password2);
                    //generar token
                    $usuario->crearToken();
                   //crear el usuario
                   $resultado = $usuario->guardar();
                   //enviar email
                   $email= new Email($usuario->email,$usuario->nombre,$usuario->token);
                    debuguear($email);
                   if ($resultado) {
                    header('Location: /mensaje');
                   }
                }
            }



        }

            //renderizar la vista
            $router->render('auth/crear',[
                'titulo'=> 'Nuevo Usuario',
                'usuario'=> $usuario,
                'alertas'=> $alertas
            ]);
        

    }

    public static function olvide(Router $router){
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

            //renderizar la vista
            $router->render('auth/olvide',[
            'titulo'=> 'Olvide mi password'
            ]);


    }

    public static function restablecer(Router $router){
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

        //renderizar la vista
        $router->render('auth/restablecer',[
            'titulo'=> 'Olvide mi password'
        ]);

    }

    public static function mensaje(Router $router){
        
    //renderizar la vista
    $router->render('auth/mensaje',[
        'titulo'=> 'mensaje'
    ]);


    }

    public static function confirmar(Router $router){
       
        //renderizar la vista
        $router->render('auth/confirmar',[
            'titulo'=> 'confirmar cuenta'
        ]);

    }
}