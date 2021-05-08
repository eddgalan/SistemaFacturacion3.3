<?php
  require 'models/usuario.php';
  require 'models/cliente.php';
  require 'models/pac.php';
  require 'models/producto.php';
  require 'models/serie.php';
  require 'models/emisor.php';
  require 'models/comprobante.php';
  require 'models/csd.php';

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

          $usuario = new UsuarioPDO();

          if($usuario->validate_user($usr_name, $usr_pass)){
            // write_log("USUARIO Y CONTASEÑA CORRECTA");
            $session = new UserSession();
            $session->set_session($usuario->get_userdata($usr_name));
            header("location: ./dashboard");
          }else{
            header("location: ./login");
          }
        }
      }else{
        $data['title'] = "Facturación 3.3 | Inicio de sesión";
        $data['host'] = $host_name;
        $data['sitio'] = $site_name;
        $this->view = new View();
        $this->view->render('views/modules/login.php', $data);
      }
    }
  }

  class Logout{
    function __construct($hostname){
      $session = new UserSession();
      $session->close_sesion();
      header("location: ". $hostname ."/login");
    }
  }

  class Dashboard {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Dashboard";
      $data['host'] = $host_name;
      $this->view = new View();
      $this->view->render('views/modules/dashboard.php', $data, true);
    }
  }

  class ViewUsuarios {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Administrar | Usuarios";
      $data['host'] = $host_name;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();

      $usuario = new UsuarioPDO();
      $data['usuarios'] = $usuario->get_users();

      $this->view = new View();
      $this->view->render('views/modules/administrar/usuarios.php', $data, true);
    }
  }

  class SwitchActivo{
    function __construct($host_name="", $site_name="", $datos=null){
      // PONER TOKEN!!!!
      $user_id = $datos[1];
      $status_actual = $datos[2];

      if($status_actual == 1){
        $nuevo_status = 0;
        $msg_status="Se ha desactivado el usuario.";
      }else{
        $nuevo_status = 1;
        $msg_status="Se ha activado el usuario.";
      }

      $usuario = new UsuarioPDO($user_id, $nuevo_status);
      $sesion = new UserSession();
      if($usuario->cambiar_activo()){
        $sesion->set_notification("OK", $msg_status);
      }else{
        $sesion->set_notification("ERROR", "Ocurrió un error al realizar el cambio de Estatus");
      }
      header("location: " . $host_name . "/administrar/usuarios");
    }
  }

  class ProcessUsuario {
    function __construct($host_name="", $site_name="", $variables=null){
      if ($_POST){
        // Valida el Token de la sesión
        $token = $_POST['token'];
        $sesion = new UserSession();
        write_log($token);
        if($sesion->validate_token($token)){
          if (empty($_POST['id_usuario'])){
            // Si NO se recibe id_usuario es una Alta de Usuario
            // Obtiene los datos del Formulario (Variables POST)
            $username = $_POST['username'];
            $contra = $_POST['password'];
            $contra = password_hash($contra, PASSWORD_DEFAULT, ['cost' => 15]);
            $email = $_POST['email'];
            // Crea una instancia de UsuarioPDO con los datos del formulario
            $usuario = new UsuarioPDO('0', 1, $username, $contra, $email);
            $usuario_creado = $usuario->insert_usuario();  // Crea el usuario con los datos que mandamos
            // Verifica si se creó el usuario y hace el msg
            $sesion = new UserSession();
            if($usuario_creado){
              $sesion->set_notification("OK", "Se ha creado un nuevo usuario");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al crear el usuario. Intente de nuevo.");
            }
          }else{
            // Si se recibe id_usuario es un UPDATE de Usuario
            // Obtiene los datos del Formulario (Variables POST)
            if(isset($_POST['user_activo'])){
              $activo = 1;
            }else{
              $activo = 0;
            }
            $id_usuario = $_POST['id_usuario'];
            $username = $_POST['username_edit'];
            $email = $_POST['email_edit'];
            // Valida si se ingresó una nueva contraseña
            if (empty($_POST['password_edit'])){
              $contra = "";
            }else{
              $contra = password_hash($_POST['password_edit'], PASSWORD_DEFAULT, ['cost' => 15]);
            }
            // Crea una instancia de UsuarioPDO con los datos del formulario
            $usuario = new UsuarioPDO($id_usuario, $activo, $username, $contra, $email);
            $usuario_actualizado = $usuario->actualizar_usuario();        // Actualiza el usuario con los datos que mandamos
            // Verifica si se actualizó el usuario y genera el msg/notificación
            $sesion = new UserSession();
            if($usuario_actualizado){
              $sesion->set_notification("OK", "Los datos del usuario se actualizaron.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar los datos del usuario.");
            }
          }
        }
      }else{
        write_log("ProcessUsuario\nNO se recibieron datos por POST");
      }
      // Redirecciona a la página de administrar/usuarios
      header("location: " . $host_name . "/administrar/usuarios");
    }
  }

  class ViewEmisores {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Administrar | Emisores";
      $data['host'] = $host_name;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();

      $pac = new PacPDO();
      $data['pacs'] = $pac->get_active_pac();

      $this->view = new View();
      $this->view->render('views/modules/administrar/emisores.php', $data, true);
    }
  }

  class ViewProdServ {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Catalogo Productos y Servicios";
      $data['host'] = $host_name;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();

      $cat_prodserv = new CatSATProdServ();
      $data['cat_prodserv'] = $cat_prodserv->get_all_catsat();

      $data['claves_prodserv'] = $cat_prodserv->get_all();

      $this->view = new View();
      $this->view->render('views/modules/catsat/prodserv.php',$data, true);
    }
  }

  class ProcessProdServ{
    function __construct($host_name="", $site_name="", $datos=null){
      if ($_POST){
        $clave = $_POST['clave_prodserv'];

        $clave_prodserv = new CatSATProdServ();
        $sesion = new UserSession();

        if($clave_prodserv->add_prodserv($clave)){
          $sesion->set_notification("OK", "Se agregó la Clave de Producto o Servicio a su catálogo");
        }else{
          $sesion->set_notification("ERROR", "Ocurrió un error al agregar la Clave de Producto o Servicio. Intente de nuevo");
        }
        header("location: " . $host_name . "/catalogosSAT/prod_serv");
      }else{
        write_log("ProcessUsuario\nNO se recibieron datos por POST");
      }
    }
  }

  class SwitchActivoProdServ{
    function __construct($host_name="", $site_name="", $datos=null){
      // PONER TOKEN!!!!
      $prodserv_id = $datos[1];
      $status_actual = $datos[2];

      if($status_actual == 1){
        $nuevo_status = 0;
        $msg_status="Se ha desactivado la Clave de Producto o Servicio.";
      }else{
        $nuevo_status = 1;
        $msg_status="Se ha activado la Clave de Producto o Servicio.";
      }

      $prodserv = new CatSATProdServ($prodserv_id, $nuevo_status);
      $sesion = new UserSession();

      if($prodserv->cambiar_activo()){
        $sesion->set_notification("OK", $msg_status);
      }else{
        $sesion->set_notification("ERROR", "Ocurrió un error al realizar el cambio de Estatus");
      }
      header("location: " . $host_name . "/catalogosSAT/prod_serv");
    }
  }

  class ViewsFacturas{
    function __construct($hostname='', $site_name='', $variables=null){
      $data['title'] = "Facturación 3.3 | Facturas";
      $data['host'] = $hostname;

      $comprobante_pdo = new ComprobantePDO();
      $data['comprobantes'] = $comprobante_pdo->get_comprobantes();

      $this->view = new View();
      $this->view->render('views/modules/cfdis/facturas.php', $data, true);
    }

  }

  class ViewDetalleFactura{
    function __construct($hostname='', $sitename='', $dataurl=null){
      $data['title'] = "Facturación 3.3 | Facturas";
      $data['host'] = $hostname;

      $id_comprobante = $dataurl[1];
      // Obtiene el Emisor
      $sesion = new UserSession();
      $data_session = $sesion->get_session();
      $emisor = $data_session['Emisor'];
      // Crea una instancia ComprobantePDO y obtiene los datos del comprobante
      $comprobante_pdo = new ComprobantePDO();
      $data['comprobante'] = $comprobante_pdo->get_comprobante($id_comprobante, $emisor);
      $data['prod_serv'] = $comprobante_pdo->get_detalles($id_comprobante);

      $this->view = new View();
      $this->view->render('views/modules/cfdis/detalle_factura.php', $data, true);
    }
  }

  class ViewNuevaFactura {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Facturas | Nueva Factura";
      $data['host'] = $host_name;
      $data['sitio'] = $site_name;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();

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
      // Obtiene los productos
      $productos = new ProductoPDO();
      $data['productos'] = $productos->get_all();


      $this->view = new View();
      $this->view->render('views/modules/cfdis/nuevo_cfdi.php', $data, true);
    }
  }

  class ProcessTimbrarCFDI{
    function __construct($hostname='', $sitename='', $dataurl=null){
      $id_comprobante = $dataurl[1];
      // Obtiene el Emisor
      $sesion = new UserSession();
      $data_session = $sesion->get_session();
      $emisor = $data_session['Emisor'];
      // Obtiene el certificado y nocertificado
      $csd_pdo = new CSD_PDO('', '', $emisor);
      $datos_csd = $csd_pdo->get_csd();
      $certificado = $datos_csd['Certificado'];
      $nocertificado = $datos_csd['NoCertificado'];
      // Crea una instancia de ComprobantePDO
      $comprobante_pdo = new ComprobantePDO();
      // Crea el XML y devulve la ruta y nombre del archivo creado
      $path_xml = $comprobante_pdo->create_xml($id_comprobante, $emisor, $certificado, $nocertificado);

      if( $path_xml != false ){
        $emisor_pdo = new EmisorPDO($emisor);
        $datos_emisor = $emisor_pdo->get_emisor();
        $pac_id = $datos_emisor['Id'];
        // Obtiene la información del PAC
        $pac_pdo = new PacPDO();
        $pac_info = $pac_pdo->get_pac($pac_id);
        // Timbra el comprobante con los datos del PAC
        if($comprobante_pdo->timbrar($id_comprobante, $path_xml, $pac_info, $datos_emisor['Testing'])){
          if($comprobante_pdo->create_pdf($id_comprobante, $path_xml, $datos_emisor)){
            $sesion->set_notification("OK", "Se timbró la factura de forma correcta. Para verificar su estatus en el SAT existe un tiempo de espera de hasta 72 horas");
          }else{
            $sesion->set_notification("WARNING", "Se timbró la factura, pero ocurrió un error al crear el PDF.");
          }
        }else{
          $sesion->set_notification("Error", "Ocurrió un error al momento de timbrar. Verifique los datos e intente de nuevo. Si el problema persiste, contacte al administrador");
        }
      }else{
        $sesion->set_notification("ERROR", "Ocurrió un error al generar el XML. Intentelo de nuevo");
      }
      // Redirecciona a la página del comprobante
      header("Location: " . $hostname . "/CFDIs/facturas/detalles/" . $id_comprobante);
    }
  }

  class ViewUnidades {
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Catalogo Unidades";
      $data['host'] = $host_name;

      $unidades = new CatSATUnidades();
      $data['cat_unidades'] = $unidades->get_all_catsat();

      $this->view = new View();
      $this->view->render('views/modules/catsat/unidades.php',$data, true);
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
