<?php
namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController{

    public static function index(Router $router){

        session_start();
        isAuth();

        $id=$_SESSION['id'];
        $proyectos= Proyecto::belongsTo('propietarioId',$id);

     
        $router->render('dashboard/index',[
            'titulo'=> 'Proyectos',
            'proyectos' =>$proyectos
        ]);
    }

    public static function crear(Router $router){
        session_start();
        isAuth();
        $alertas=[];

        if ($_SERVER['REQUEST_METHOD']=== 'POST') {
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validarProyecto();

           if (empty($alertas)) {
            //generar url unica y asignarla
            $proyecto->url = md5(uniqid());

            //almacenar el creador
            $proyecto->propietarioId = $_SESSION['id'];

            //guardar el proyecto

            $proyecto->guardar();

            //redireccionar al proyecto
            header('Location: /proyecto?id='. $proyecto->url);
            
           }
        }

        $router->render('dashboard/crear-proyecto',[
            'titulo'=> 'Crear Proyecto',
            'alertas'=>$alertas
        ]);
    }


    public static function proyecto(Router $router){
        session_start();
        isAuth();
    
        $token = $_GET['id'];
    
        // Primero, verifica si el token está presente
        if (!$token) {
            header('Location: /dashboard');
            exit;
        }
    
        // Luego, busca el proyecto en la base de datos
        $proyecto = Proyecto::where('url', $token);
    
        // Verifica si se encontró el proyecto y si el propietario es el usuario logueado
        if (!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
            exit;
        }
    
        // Renderiza la vista si las verificaciones son exitosas
        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto,
        ]);
    }

    public static function perfil(Router $router){
        session_start();
        
        $router->render('dashboard/perfil',[
            'titulo'=> 'Perfil',
        ]);
    }


}