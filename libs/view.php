<?php
  require 'models/session.php';

  class View{
    function render($modulo, $data=null, $login=false){
      if($login){
          $session = new UserSession();
          if($session->validate_session()){
            require $modulo;
          }else{
            write_log("NO hay una sesión Activa | Redirigiendo a login");
            header("location: ./login");     // Poner a qué dirección se desea redirigir si no hay sesión
          }
      }else{
        if($modulo == 'views/modules/login.php'){
          $session = new UserSession();
          if($session->validate_session()){
            header("location: " . $data['host'] . "/dashboard");
          }else{
            require $modulo;
          }
        }else{
          require $modulo;
        }
      }
    }
  }
?>
