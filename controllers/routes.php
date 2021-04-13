<?php
  require 'controllers/render.php';
  require 'controllers/api.php';

  class Routes{
    function __construct($host_name, $site_name){
      /* ...:: Views :::.. */
      $routes["dashboard"]="Dashboard";
      $routes["CFDIs/facturas/nueva"]="ViewNuevaFactura";

      /* ...:: APIs ::... */
      $routes["API/clientes/get_clientes"]="ClienteAPI/get_clientes";


      //Si no está vacía la variable $_GET['url'] la usamos para navegar
      if(!empty($_GET['url'])){
        $url = $_GET['url'];

        $array_rutas=[];

        // Pasamos los índices a array_rutas
        while (current($routes)) {
          array_push($array_rutas, key($routes));
          next($routes);
        }

        // Llamamos a la función 'url_valida' que retorna si la URL es válida
        $valida = url_valida($url, $array_rutas);

        // Verificamos el valor de $valida
        if ($valida === false){
          include_once 'views/modules/error.php';
        } else {
          // Validamos si la URL es para una API
          if( strpos($url, "API") === 0 ){
            $array_url = $routes[$valida[0]];
            // Convierte la URL en ARRAY
            $array_url = rtrim($array_url,'/');
            $array_url = explode('/',$array_url);

            $class_control = $array_url[0];
            $method_control = $array_url[1];

            $api = new $class_control;

            //Verifica si $valida tiene variables
            if (count($valida)>1){
              $api -> {$method_control}($valida);
            } else {
              $api -> {$method_control}();
            }

          } else {
            // Asignamos el nombre del archivo del controlador
            $clase_controlador = $routes[$valida[0]];
            // Validamos si hay variables en la URL
            if (count($valida)>1){
              // Creamos un controlador con el nombre de la clase y le mandamos las variables
              $controller = new $clase_controlador($host_name, $site_name, $valida);
            } else {
              // Creamos un controlador con el nombre de la clase
              $controller = new $clase_controlador($host_name, $site_name);
            }

          }
        }
        // write_log(serialize($valida));
      } else {
        $redirect_url = $host_name . "/dashboard";
        header("Location: $redirect_url");
      }

    }
  }


  function url_valida($url, $array_rutas){
    $data=[];             // Variable que guarda los datos de la URL
    $url_valida = true;   // Bandera para indicar si la URL es válida

    // Convierte la URL en ARRAY
    $array_url = rtrim($url,'/');
    $array_url = explode('/',$array_url);

    for ($i=0;$i<count($array_rutas);$i++){
      $data[0] = $array_rutas[$i];    //Guarda la dirección de la ruta de $routes[]
      $dir_ruta = $array_rutas[$i];
      $dir_ruta = rtrim($dir_ruta,'/');
      $dir_ruta = explode('/',$dir_ruta);
      // Valida que sean del mismo tamaño
      if (count($dir_ruta) == count($array_url)){
        for ($j=0;$j<count($array_url);$j++){
          // Valida si hay una variable en la URL
          if ($dir_ruta[$j] == "_data_"){
            $dir_ruta[$j] = $array_url[$j];
            // Guarda la variable en un array ($data)
            array_push($data, $array_url[$j]);
          }
          if ($array_url[$j] != $dir_ruta[$j]){
            $url_valida = false;
            // write_log("URL NO Válida!!\n" . $dir_ruta[$j]);
            break;
          } else {
            $url_valida = true;
          }
        }
        if($url_valida){
          break;
        }
      }
    }
    if ($url_valida){
      return $data;
    } else {
      return false;
    }
  }
 ?>
