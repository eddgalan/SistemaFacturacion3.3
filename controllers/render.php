<?php
  require 'models/usuario.php';
  require 'models/cliente.php';

  class Dashboard {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Dashboard";
      $data['host'] = $host_name;
      $data['sitio'] = $site_name;
      $this->view = new View();
      $this->view->render('views/modules/dashboard.php', $data);
    }
  }

  class ViewNuevaFactura {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Facturas > Nueva Factura";
      $data['host'] = $host_name;
      $data['sitio'] = $site_name;
      $this->view = new View();
      $this->view->render('views/modules/cfdis/nuevo_cfdi.php', $data);
    }
  }

  class Login {
    function __construct($host_name="", $site_name="", $variables=null){
      if($_POST){
        if(isset($_POST['username']) && isset($_POST['password'])) {
          $usr_name = $_POST['username'];
          $usr_pass = $_POST['password'];

          $usuario = new Usuario();

          if($usuario->validate_user($usr_name, $usr_pass)){
            $session = new UserSession();
            $session->set_session($usuario->get_userdata($usr_name));
            header("location: ./dashboard");
          }else{
            header("location: ./login");
          }
        }
      }else{
        $data['title'] = "Tarjetas de Lealtad | Login";
        $data['host'] = $host_name;
        $data['sitio'] = $site_name;
        $this->view = new View();
        $this->view->render('views/modules/login.php', $data);
      }
    }
  }

  class Logout{
    function __construct(){
      $session = new UserSession();
      $session->close_sesion();
      header("location: ./login");
    }
  }

  class ErrorURL {
    function __construct(){
      $data['title'] = 'Error 404';
      $vista = new View();
      $vista->render('views/modules/error.php');
    }
  }

?>
