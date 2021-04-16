<?php
  require 'models/usuario.php';
  require 'models/cliente.php';
  require 'models/catsat/prodserv.php';
  require 'models/catsat/metodos_pago.php';
  require 'models/catsat/formas_pago.php';
  require 'models/catsat/usos_cfdi.php';
  require 'models/catsat/moneda.php';
  require 'models/catsat/series.php';
  require 'models/catsat/unidades.php';

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

  class Dashboard {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Dashboard";
      $data['host'] = $host_name;
      $this->view = new View();
      $this->view->render('views/modules/dashboard.php', $data);
    }
  }

  class ViewProdServ {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Catalogo Productos y Servicios";
      $data['host'] = $host_name;

      $cat_prodserv = new CatSATProdServ();
      $data['cat_prodserv'] = $cat_prodserv->get_all_catsat();

      $this->view = new View();
      $this->view->render('views/modules/catsat/prodserv.php',$data);
    }
  }

  class ViewNuevaFactura {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Facturas | Nueva Factura";
      $data['host'] = $host_name;
      $data['sitio'] = $site_name;
      // Obtiene los clientes del usuario (Emisor)
      $cliente = new ClientePDO();
      $data['clientes'] = $cliente->get_clientes();
      // Obtiene los metodos de pago
      $metodo = new CatSATMetodos();
      $data['metodos_pago'] = $metodo->get_all();
      // Obtiene las formas de pago
      $forma_pago = new CatSATFormaPago();
      $data['formas_pago'] = $forma_pago->get_all();
      // Obtiene los usos CFDI
      $usos_cfdi = new CatSATUsosCFDI();
      $data['usos_cfdi'] = $usos_cfdi->get_all();
      // Obtiene las monedas
      $moneda = new CatSATMoneda();
      $data['monedas'] = $moneda->get_all();
      // Obtiene las monedas
      $serie = new SeriesPDO();
      $data['series'] = $serie->get_all();


      $this->view = new View();
      $this->view->render('views/modules/cfdis/nuevo_cfdi.php', $data);
    }
  }

  class ViewUnidades {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Catalogo Unidades";
      $data['host'] = $host_name;

      $unidades = new CatSATUnidades();
      $data['cat_unidades'] = $unidades->get_all_catsat();

      $this->view = new View();
      $this->view->render('views/modules/catsat/unidades.php',$data);
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
