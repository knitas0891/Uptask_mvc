<?php

namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\Usuario;

class LoginController {
    public static function login(Router $router){
        $alertas =[];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();

            if(empty($alertas)){
                //verificar que el usuario exista
                $usuario = Usuario::where('email',$usuario->email);
                if (!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('error', 'El usuario No Existe o no está confirmado');
                }else {
                    //el usuario existe y está confirmado, validar password
                    if (password_verify($_POST['password'],$usuario->password)) {
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        header('Location: /dashboard');

                    }else{
                        Usuario::setAlerta('error', 'El usuario o contraseña no validos');
                        
                     
                    }
                }

            }
            

        }
        $alertas=Usuario::getAlertas();

        //renderizar la vista
        $router->render('auth/login',[
            'titulo'=> 'Iniciar Sesión',
            'alertas'=>$alertas
        ]);

    }

    public static function logout(){
        session_start();
        $_SESSION =[];

        header('Location: /');

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
                $email->enviarConfirmacion();
                   if ($resultado) {
                    header('Location: /mensaje');
                   }else{
                    debuguear($resultado);
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
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                //buscar email
                $usuario = Usuario::where('email', $usuario->email);
                
                if ($usuario && $usuario->confirmado) {
                    
                    //generar nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);
                    //actualizar el usuario
                    $usuario->guardar();
                    //enviar el email
                    $email= new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarInstrucciones();
                    //imprimir la alerta
                    Usuario::setAlerta('exito','Hemos enviado las instrucciones a tu email');
                } else {
                    Usuario::setAlerta('error', 'El Usuario no existe o no está confirmado');
                    
                }

                
            }
        }
            $alertas = Usuario::getAlertas();
            //renderizar la vista
            $router->render('auth/olvide',[
            'titulo'=> 'Olvide mi password',
            'alertas'=>$alertas
            ]);


    }

    public static function restablecer(Router $router){
        $token= s($_GET['token']);
        $mostrar = true;

        if (!$token) header('Location: /');

        //Identificar el usuario con el token
        $usuario = Usuario::where('token',$token);


        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token No Valido');
            $mostrar=false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarPassword();

            if(empty($alertas)){
                //hashear new password
                $usuario->hashPassword();
                unset($usuario->password2);
                //borramos token
                $usuario->token = null;
                
                //guardar usuario
                $resultado = $usuario->guardar();
                //redireccionar
                if($resultado){
                    header('Location: /');
                }
                
            }
        }

        $alertas = Usuario::getAlertas();
        
        //renderizar la vista
        $router->render('auth/restablecer',[
            'titulo'=> 'Olvide mi password',
            'alertas'=>$alertas,
            'mostrar'=>$mostrar
        ]);

    }

    public static function mensaje(Router $router){
        
    //renderizar la vista
    $router->render('auth/mensaje',[
        'titulo'=> 'mensaje'
    ]);


    }

    public static function confirmar(Router $router){
       
            $token = s($_GET['token']);
            if (!$token) header('Location: /');
            $usuario = Usuario::where('token', $token);
            if(empty($usuario)){
                Usuario::setAlerta('error', 'Token no valido');
            }else{

                $usuario->confirmado = 1;
                $usuario->token = null;
                unset($usuario->password2);
                $usuario->guardar();

                Usuario::setAlerta('exito', 'Cuenta Registrada con exito');
            
    
            }
            $alertas = Usuario::getAlertas();


   

        //renderizar la vista
        $router->render('auth/confirmar',[
            'titulo'=> 'confirmar cuenta',
            'alertas'=>$alertas
        ]);

    }
}