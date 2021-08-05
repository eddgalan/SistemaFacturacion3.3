<?php
  require 'libs/conexion_db.php';
  require 'libs/mpdf/plantillas_mpdf.php';
  require 'models/comprobante.php';
  require 'models/csd.php';
  require 'models/mailgun.php';
  require 'models/contacto.php';
  /* ..:: Administrador ::..  */
  require 'models/administrador/pac.php';
  require 'models/administrador/usuario.php';
  require 'models/administrador/grupos.php';
  require 'models/administrador/perfiles.php';
  require 'models/administrador/emisor.php';
  require 'models/administrador/cliente.php';
  require 'models/administrador/serie.php';
  require 'models/administrador/prod_serv.php';
  /* ..:: Catálogo SAT ::..  */
  require 'models/catsat/prodserv.php';
  require 'models/catsat/metodos_pago.php';
  require 'models/catsat/formas_pago.php';
  require 'models/catsat/usos_cfdi.php';
  require 'models/catsat/moneda.php';
  require 'models/catsat/unidades.php';
  require 'models/catsat/impuestos.php';
  require 'models/catsat/regimenes.php';

  class Login{
    function __construct($host_name="", $site_name="", $variables=null){
      if($_POST){
        if(isset($_POST['username']) && isset($_POST['password'])) {
          $usr_name = $_POST['username'];
          $usr_pass = $_POST['password'];

          $usuario = new UsuarioPDO();
          if($usuario->validate_user($usr_name, $usr_pass)){
            $session = new UserSession();
            $session->set_session($usuario->get_all_userdata_by_username($usr_name));
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
    function __construct($hostname="", $sitename="", $dataurl=null){
      $data['title'] = "Facturación 3.3 | Dashboard";
      $data['host'] = $hostname;

      $sesion = new UserSession();
      $data_sesion = $sesion->get_session();
      if( $data_sesion){
        $emisor = $data_sesion['Emisor'];
        $usuario_id = $data_sesion['Id'];
        $data['token'] = $sesion->set_token();
        $usuario_pdo = new UsuarioPDO();

        $permisos = $usuario_pdo->get_permisos($usuario_id);
        if( $permisos['DashboardAdmin'] != 0 ){
          $data['show_dashboard_admin'] = true;
          // Sección Admin
          $data['no_usuarios'] = $usuario_pdo->get_count();
          $grupo_pdo = new GrupoPDO();
          $data['no_grupos'] = $grupo_pdo->get_count();
          $perfil_pdo = new PerfilPDO();
          $data['no_perfiles'] = $perfil_pdo->get_count();
          $emisor_pdo = new EmisorPDO();
          $data['no_emisores'] = $emisor_pdo->get_count();
        }else{
          $data['show_dashboard_admin'] = false;
        }
        // Sección Emisor
        $cliente_pdo = new ClientePDO();
        $data['no_clientes'] = $cliente_pdo->get_count($emisor);
        $prodserv_pdo = new ProdServPDO();
        $data['no_prodservs'] = $prodserv_pdo->get_count($emisor);
        $serie_pdo = new SeriePDO();
        $data['no_series'] = $serie_pdo->get_count($emisor);
        // Comprobantes
        $comprobante_pdo = new ComprobantePDO();
        $data['no_cfdis'] = $comprobante_pdo->get_count($emisor);

        $this->view = new View();
        $this->view->render('views/modules/dashboard.php', $data, true);
      }else{
        header("Location: ".  $hostname ."/login");
      }
    }
  }

  class ViewMiEmpresa{
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Administrar | Mi Empresa";
      $data['host'] = $host_name;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();
      $data_sesion = $sesion->get_session();

      $emisor_pdo = new EmisorPDO();
      $data['emisor'] = $emisor_pdo->get_emisor($data_sesion['Emisor']);

      $regimen_pdo = new CatSATRegimenesPDO();
      $data['regimenes'] = $regimen_pdo->get_regimenes_persona($data['emisor']['Persona']);

      $csd_pdo = new CSD_PDO();
      $data['csd'] = $csd_pdo->get_csd($data_sesion['Emisor']);

      $this->view = new View();
      $this->view->render('views/modules/administrar/miempresa.php', $data, true);
    }
  }

  class ProcessMiEmpresa{
    function __construct($host_name="", $site_name="", $variables=null){
      if ($_POST){
        // Valida el Token de la sesión
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          // Obtene los datos
          $id_emisor = $_POST['id_emisor'];
          $nombre = $_POST['nombre'];
          $direccion = $_POST['direccion'];
          $codigo_postal = $_POST['codigo_postal'];
          $tipo_persona = $_POST['persona'];
          $array_regimen = explode(" | ", $_POST['regimen']);
          $regimen = $array_regimen[0];
          $desc_regimen = $array_regimen[1];

          $emisor_pdo = new EmisorPDO();
          if( $emisor_pdo->update_miempresa($id_emisor, $nombre, $direccion, $codigo_postal, $tipo_persona, $regimen, $desc_regimen) ){
            $sesion->set_notification("OK", "Se actualizaron los datos correctamente.");
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error al actualizar los datos del usuario.");
          }
        }
      }else{
        write_log("ProcessMiEmpresa | __construct() | NO se recibieron datos por POST");
        $sesion->set_notification("ERROR", "No fue posible procesar su solicitud.");
      }
      // Redirecciona a la página de administrar/usuarios
      header("location: " . $host_name . "/administrar/miempresa");
    }
  }

  class ProcessChangeLogo{
    function __construct($host_name="", $site_name="", $variables=null){
      if($_POST){
        // Valida el Token de la sesión
        $token = $_POST['token'];
        $sesion = new UserSession();
        $data_session = $sesion->get_session();

        if($sesion->validate_token($token)){
          if(!empty($_FILES['logo_img'])){
            $file = $_FILES['logo_img'];
            $type = $file['type'];
            // Valida el Tipo de Archivo
            if($type == "image/jpg" || $type == "image/jpeg" || $type == "image/png"){
              // Obtiene el RFC del Emisor (Empresa)
              $id_emisor = $data_session['Emisor'];
              $emisor_pdo = new EmisorPDO();
              $data_emisor = $emisor_pdo->get_emisor($id_emisor);
              $rfc = $data_emisor['RFC'];

              $extension = substr($file['name'], strpos($file['name'], '.'), strlen($file['name']));
              $pathlogo = "uploads/". $rfc ."/logo" . $extension;
              // Valida si existe el directorio donde se guardará el Logo | Si NO existe lo crea
              if(!is_dir("uploads/". $rfc)){
                mkdir("uploads/". $rfc, 0777);
              }
              move_uploaded_file($file['tmp_name'], $pathlogo);
              write_log("ProcessChangeLogo | __contruct() | Se cargó la imagen de forma exitosa");
              // Actualiza el campo PathLogo del Emisor
              if( $emisor_pdo->update_logo($id_emisor, $pathlogo) ){
                $sesion->set_notification("OK", "Se cambió el logo de forma correcta.");
                write_log("ProcessChangeLogo | __contruct() | Se cargó la imagen de forma exitosa");
              }else{
                $sesion->set_notification("ERROR", "Ocurrió un error al cargar el logo. Inténtelo de nuevo.");
                write_log("ProcessChangeLogo | __contruct() | Se cargó la imagen de forma exitosa");
              }
            }else{
              write_log("ProcessChangeLogo | __contruct() | El archivo NO es una imágen");
              $sesion->set_notification("ERROR", "El Logotipo que desea cargar no es una imagen");
              header("location: " . $hostname . "/administrar/emisores");
            }
          }
        }else{
          write_log("ProcessChangeLogo | __construct() | Token NO válido");
          $sesion->set_notification("ERROR", "No fue posible procesar su solicitud.");
        }
      }else{
        write_log("ProcessChangeLogo | __construct() | NO se recibieron datos por POST");
        $sesion->set_notification("ERROR", "No fue posible procesar su solicitud.");
      }
      header("location: " . $host_name . "/administrar/miempresa");
    }
  }

  class ViewPACs{
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Administrar | PACs";
      $data['host'] = $host_name;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();
      $data_sesion = $sesion->get_session();

      $pac_pdo = new PacPDO();
      $data['pacs'] = $pac_pdo->get_active_pac();

      $this->view = new View();
      $this->view->render('views/modules/administrar/pacs.php', $data, true);
    }
  }

  class ProcessPAC{
    function __construct($hostname="", $sitename="", $dataurl=null){
      if ($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          if( empty($_POST['id_pac']) ){
            // INSERT PAC
            $nombre_pac = $_POST['nombre_pac'];
            $nombre_corto = $_POST['nombre_corto'];
            $endpoint = $_POST['endpoint'];
            $endpoint_pruebas = $_POST['endpoint_pruebas'];
            $usuario = $_POST['usuario'];
            $pass = $_POST['pass'];
            $observaciones = $_POST['observaciones'];

            $pac_pdo = new PacPDO();
            if( $pac_pdo->insert($nombre_pac, $nombre_corto, $endpoint, $endpoint_pruebas, $usuario, $pass, $observaciones) ){
              $sesion->set_notification("OK", "Se ha registrado el nuevo PAC.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al registrar el PAC. Intente de nuevo.");
            }
          }else{
            $id = $_POST['id_pac'];
            $nombre_pac = $_POST['nombre_pac_edit'];
            $nombre_corto = $_POST['nombre_corto_edit'];
            $endpoint = $_POST['endpoint_edit'];
            $endpoint_pruebas = $_POST['endpoint_pruebas_edit'];
            $usuario = $_POST['usuario_edit'];
            $pass = $_POST['pass_edit'];
            $observaciones = $_POST['observaciones_edit'];

            $pac_pdo = new PacPDO();
            if( $pac_pdo->update($id, $nombre_pac, $nombre_corto, $endpoint, $endpoint_pruebas, $usuario, $pass, $observaciones) ){
              $sesion->set_notification("OK", "Se ha actualizado el registro.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar el PAC. Intente de nuevo.");
            }
          }
        }
      }else{
        write_log("ProcessPAC | __contruct | NO se recibieron datos por POST");
      }
      header("location: " . $hostname . "/administrar/pacs");
    }
  }

  class ProcessFilesCSD{
    function __construct($hostname="", $sitename="", $variables=null){
      if($_POST){
        // Valida el Token de la sesión
        $token = $_POST['token'];
        $sesion = new UserSession();
        if($sesion->validate_token($token)){
          // Valida que se hayan cargado los 2 archivos
          if( !empty($_FILES['archivo_cer']) && !empty($_FILES['archivo_key']) && $_POST['pass_files']!="" ){
            // Obtiene los datos del Emisor para obtener el RFC
            $data_sesion = $sesion->get_session();
            $emisor_pdo = new EmisorPDO();
            $data_emisor = $emisor_pdo->get_emisor($data_sesion['Emisor']);
            $rfc = $data_emisor['RFC'];
            $password = trim( $_POST[ "pass_files" ] );
            // Subir los archivos:
          	if( isset($_FILES["archivo_cer"]["tmp_name"]) ) $file_cer = trim($_FILES["archivo_cer"]["tmp_name"]);
          	if( isset($_FILES["archivo_key"]["tmp_name"]) ) $file_key = trim($_FILES["archivo_key"]["tmp_name"]);
          	$ruta_documentos = "uploads/". $rfc. "/csd_files/";
          	if( !file_exists( $ruta_documentos ) ){
          		if( !mkdir( $ruta_documentos, 0777 ) ){
                write_log("Ocurrió un error al crear el directorio: ". $ruta_documentos);
          			die('<br>Error al crear: '. $ruta_documentos );
          		}
          	}
            $file_cer2 = $ruta_documentos.trim($_FILES["archivo_cer"]["name"]);
          	$file_key2 = $ruta_documentos.trim($_FILES["archivo_key"]["name"]);
          	$empdockeypem = "";
            // Mueve los archivos al directorio que se creó
            if(!move_uploaded_file($file_cer, $file_cer2)){
          		echo "<br> Error al subir el archivo: ($file_cer)."; exit;
          	}
          	if(!move_uploaded_file($file_key, $file_key2)) {
          		echo "<br> Error al subir el archivo: ($file_key).";  exit;
          	}
            $csd_pdo = new CSD_PDO();
            $csd_info = $csd_pdo->process_csdfiles($ruta_documentos, $rfc, $password, $file_cer2, $file_key2);
            if( $csd_pdo->update_csd_by_emisor($data_emisor['Id'], $file_cer2, $file_key2, "password", $csd_info['PathKeyPem'], $csd_info['NoCertificado'], $csd_info['Certificado'], $csd_info['FechaInicio'], $csd_info['FechaFin']) ){
              $sesion->set_notification("OK", "Se han guardado y procesado sus archivos.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al procesar sus archivos. Verifique que sean los correctos al igual que la contraseña y vuelva a intentarlo.");
            }
          }else{
            $sesion->set_notification("ERROR", "No fue posible procesar los archivos. Verifique es esté cargando los dos archivos correctos (.key y .cer).");
            write_log("ProcessFilesCSD | __construct() | No se recibieron los archivos");
          }
        }else{
          $sesion->set_notification("ERROR", "No fue posible procesar su solicitud. Inténtelo de nuevo.");
          write_log("ProcessFilesCSD | __construct() | NO se recibieron datos por POST");
        }
      }else{
        $sesion->set_notification("ERROR", "No fue posible procesar su solicitud.");
        write_log("ProcessFilesCSD | __construct() | NO se recibieron datos por POST");
      }
      header("location: " . $hostname . "/administrar/miempresa");
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

      $grupo_pdo = new GrupoPDO();
      $data['grupos'] = $grupo_pdo->get_all();

      $this->view = new View();
      $this->view->render('views/modules/administrar/usuarios.php', $data, true);
    }
  }

  class SwitchActivoUsuarios{
    function __construct($host_name="", $site_name="", $datos=null){
      // Valida la sesión del usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
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
      }else{
        header("Location: " . $hostname . "/login");
      }
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
            // INSERT Usuario
            $username = $_POST['username'];
            $contra = $_POST['password'];
            $contra = password_hash($contra, PASSWORD_DEFAULT, ['cost' => 15]);
            $email = $_POST['email'];
            // Crea una instancia de UsuarioPDO con los datos del formulario
            $usuario_pdo = new UsuarioPDO('0', 1, $username, $contra, $email);
            // Verifica si se creó el usuario y hace el msg
            if( $usuario_pdo->insert_usuario() ){
              $sesion->set_notification("OK", "Se ha creado un nuevo usuario");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al crear el usuario. Intente de nuevo.");
            }
          }else{
            // UPDATE Usuario
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
            $usuario_pdo = new UsuarioPDO($id_usuario, $activo, $username, $contra, $email);
            // Verifica si se actualizó el usuario y genera el msg/notificación
            if( $usuario_pdo->actualizar_usuario() ){
              // Verifica si los datos que de actualizaron pertenecen al usuario que está logueado
              $data_sesion = $sesion->get_session();
              if( $data_sesion['Id'] == $id_usuario ){
                // Actualiza los datos de la sesión con los datos que se actualizaron del usuario
                $sesion->set_session($usuario_pdo->get_all_userdata($id_usuario));
              }
              $sesion->set_notification("OK", "Los datos del usuario se actualizaron.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar los datos del usuario.");
            }
          }
        }
      }else{
        write_log("PreocessUsuario | __construct() | NO se recibieron datos por POST");
        $sesion->set_notification("ERROR", "Ocurrió un error al actualizar los datos del usuario. No fue posible procesar su solicitud.");
      }
      // Redirecciona a la página de administrar/usuarios
      header("location: " . $host_name . "/administrar/usuarios");
    }
  }

  class ViewGrupos{
    function __construct($hostname="", $sitename="", $dataurl=null){
      $data['title'] = "Facturación 3.3 | Administrar | Grupos";
      $data['host'] = $hostname;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();

      $grupo_pdo = new GrupoPDO();
      $data['grupos'] = $grupo_pdo->get_all();

      $this->view = new View();
      $this->view->render('views/modules/administrar/grupos.php', $data, true);
    }
  }

  class ProcessGrupos{
    function __construct($hostname="", $sitename="", $dataurl=null){
      if ($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          if (empty($_POST['id_grupo'])){
            // INSERT Grupo
            $grupo = $_POST['grupo'];
            $descripcion = $_POST['descripcion'];

            $grupo_pdo = new GrupoPDO();
            if( $grupo_pdo->insert_grupo($grupo, $descripcion) ){
              if( $grupo_pdo->crear_permisos() ){
                $sesion->set_notification("OK", "Se ha creado un nuevo grupo");
              }else{
                $sesion->set_notification("ERROR", "Ocurrió un error al crear los permisos del grupo.");
              }
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al crear el Grupo. Intente de nuevo.");
            }
          }else{
            // UPDATE Grupo
            $id_grupo = $_POST['id_grupo'];
            $grupo = $_POST['grupo_edit'];
            $descripcion = $_POST['descripcion_edit'];

            $grupo_pdo = new GrupoPDO();
            if( $grupo_pdo->update_grupo($id_grupo, $grupo, $descripcion) ){
              $sesion->set_notification("OK", "Los datos se actualizaron correctamente.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar el Grupo.");
            }
          }
        }
      }else{
        write_log("ProcessUsuario\nNO se recibieron datos por POST");
      }
      header("location: " . $hostname . "/administrar/grupos");
    }
  }

  class ProcessPermisos{
    function __construct($hostname="", $sitename="", $dataurl=null){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          /* ..:: Obtiene los datos ::.. */
          $id = $_POST['id_permiso'];
          // Mi Empresa
          if(isset($_POST['admin_miempresa'])){
            $admin_miempresa = 1;
          }else{
            $admin_miempresa = 0;
          }
          // PACs
          if(isset($_POST['admin_pacs'])){
            $admin_pacs = 1;
          }else{
            $admin_pacs = 0;
          }
          // Usuario
          if(isset($_POST['admin_usuario'])){
            $admin_usuario = 1;
          }else{
            $admin_usuario = 0;
          }
          // Grupos
          if(isset($_POST['admin_grupos'])){
            $admin_grupos = 1;
          }else{
            $admin_grupos = 0;
          }
          // Perfiles
          if(isset($_POST['admin_perfiles'])){
            $admin_perfiles = 1;
          }else{
            $admin_perfiles = 0;
          }
          // Emisores
          if(isset($_POST['admin_emisores'])){
            $admin_emisores = 1;
          }else{
            $admin_emisores = 0;
          }
          // Clientes
          if(isset($_POST['admin_clientes'])){
            $admin_clientes = 1;
          }else{
            $admin_clientes = 0;
          }
          // Productos y Servicios
          if(isset($_POST['admin_prodserv'])){
            $admin_prodserv = 1;
          }else{
            $admin_prodserv = 0;
          }
          // Series
          if(isset($_POST['admin_series'])){
            $admin_series = 1;
          }else{
            $admin_series = 0;
          }
          /* ..:: Comprobantes ::.. */
          // Facturas
          if(isset($_POST['comprobantes_facturas'])){
            $comprobantes_facturas = 1;
          }else{
            $comprobantes_facturas = 0;
          }
          /* ..:: Reportes ::.. */
          // Mensual
          if(isset($_POST['report_reportmensual'])){
            $report_reportemensual = 1;
          }else{
            $report_reportemensual = 0;
          }
          /* ..:: Catálogos SAT ::.. */
          // Claves prodserv
          if(isset($_POST['catsat_prodserv'])){
            $catsat_prodserv = 1;
          }else{
            $catsat_prodserv = 0;
          }
          // Unidades
          if(isset($_POST['catsat_unidades'])){
            $catsat_unidades = 1;
          }else{
            $catsat_unidades = 0;
          }
          // Formas de Pago
          if(isset($_POST['catsat_formaspago'])){
            $catsat_formaspago = 1;
          }else{
            $catsat_formaspago = 0;
          }
          // Claves prodserv
          if(isset($_POST['catsat_monedas'])){
            $catsat_monedas = 1;
          }else{
            $catsat_monedas = 0;
          }
          // Claves prodserv
          if(isset($_POST['catsat_impuestos'])){
            $catsat_impuestos = 1;
          }else{
            $catsat_impuestos = 0;
          }

          $grupo_pdo = new GrupoPDO();
          if( $grupo_pdo->update_permisos($id, $admin_miempresa, $admin_pacs, $admin_usuario, $admin_grupos, $admin_perfiles, $admin_emisores, $admin_clientes, $admin_prodserv, $admin_series, $comprobantes_facturas, $report_reportemensual, $catsat_prodserv, $catsat_unidades, $catsat_formaspago, $catsat_monedas, $catsat_impuestos) ){
            $sesion->set_notification("OK", "Se actualizaron los permisos del grupo indicado");
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error al actualizar los permisos del grupo.");
          }
        }
      }else{
        write_log("ProcessUsuario\nNO se recibieron datos por POST");
      }
      header("location: " . $hostname . "/administrar/grupos");
    }
  }

  class ViewPerfiles{
    function __construct($hostname="", $sitename="", $dataurl=null){
      $data['title'] = "Facturación 3.3 | Administrar | Perfiles";
      $data['host'] = $hostname;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();

      $perfil_pdo = new PerfilPDO();
      $data['perfiles'] = $perfil_pdo->get_all();

      $usuario_pdo = new UsuarioPDO();
      $data['usuarios'] = $usuario_pdo->get_users();

      $emisor_pdo = new EmisorPDO();
      $data['emisores'] = $emisor_pdo = $emisor_pdo->get_all();

      $this->view = new View();
      $this->view->render('views/modules/administrar/perfiles.php', $data, true);
    }
  }

  class ViewPerfil{
    function __construct($hostname="", $sitename="", $dataurl=null){
      $data['title'] = "Facturación 3.3 | Administrar | Perfiles";
      $data['host'] = $hostname;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();
      $data_sesion = $sesion->get_session();

      $perfil_pdo = new PerfilPDO();
      $data['perfil'] = $perfil_pdo->get_all_info($data_sesion['PerfilId']);

      $this->view = new View();
      $this->view->render('views/modules/administrar/perfil.php', $data, true);
    }
  }

  class ProcessPerfil{
    function __construct($hostname="", $sitename="", $dataurl=null){
      if($_POST){
        $sesion = new UserSession();
        $token = $_POST['token'];

        if($sesion->validate_token($token)){
          $perfil_id = $_POST['perfil_id'];
          $usuario_id = $_POST['usuario_id'];
          $nombre = $_POST['nombre'];
          $apellido_pat = $_POST['apellido_pat'];
          $apellido_mat = $_POST['apellido_mat'];
          $puesto = $_POST['puesto'];
          $email = $_POST['email'];

          $data_sesion = $sesion->get_session();
          $usuario_id = $data_sesion['Id'];
          $emisor = $data_sesion['Emisor'];

          $perfil_pdo = new PerfilPDO();
          if( $perfil_pdo->update_perfil($perfil_id, $usuario_id, $nombre, $apellido_pat, $apellido_mat, $emisor, $puesto) ){
            $usuario_pdo = new UsuarioPDO();
            if( $usuario_pdo->update_email($usuario_id, $email) ){
              $sesion->set_notification("OK", "Los datos se actualizaron correctamente.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar el email del usuario");
            }
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error al actualizar el perfil.");
          }
        }else{
          $sesion->set_notification("ERROR", "Ocurrió un error al procesar su solicitud. Inténtelo de nuevo.");
          write_log("ProcessPerfil | __construct() | Token NO valido");
        }
      }else{
        write_log("ProcessPerfil | __contruct() | NO se recibieron datos por POST");
      }
      header("location: " . $hostname . "/perfil");
    }
  }

  class ProcessChangePassPerfil{
    function __construct($hostname="", $sitename="", $dataurl=null){
      if($_POST){
        $sesion = new UserSession();
        $token = $_POST['token'];

        if($sesion->validate_token($token)){
          $usuario_id = $_POST['usuario_id'];
          $pass = $_POST['new_pass'];
          $pass_confirm = $_POST['confirm_pass'];
          if( $pass == $pass_confirm ){
            $usuario_pdo = new UsuarioPDO();
            if( $usuario_pdo->update_password($usuario_id, $pass) ){
              $sesion->set_notification("OK", "Se ha actualizado su contraseña.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar la contraseña.");
            }
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error. No coincide la confirmación de la contraseña.");
          }
        }else{
          $sesion->set_notification("ERROR", "Ocurrió un error al procesar su solicitud. Inténtelo de nuevo.");
          write_log("ProcessPerfil | __construct() | Token NO valido");
        }
      }else{
        write_log("ProcessPerfil | __contruct() | NO se recibieron datos por POST");
      }
      header("location: " . $hostname . "/perfil");
    }
  }

  class ProcessPerfiles{
    function __construct($hostname="", $sitename="", $dataurl=null){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          if (empty($_POST['perfil_id'])){
            // INSERT PERFIL
            $usuario = $_POST['user'];
            $nombre = $_POST['nombre'];
            $apellido_pat = $_POST['apellido_pat'];
            $apellido_mat = $_POST['apellido_mat'];
            $emisor = $_POST['emisor'];
            $puesto = $_POST['puesto'];

            $perfil_pdo = new PerfilPDO();
            if( $perfil_pdo->get_perfil_by_user($usuario) ){
              $sesion->set_notification("ERROR", "Ya existe un perfil con ese usuario.");
            }else{
              if( $perfil_pdo->insert_perfil($usuario, $nombre, $apellido_pat, $apellido_mat, $emisor, $puesto) ){
                $sesion->set_notification("OK", "Se ha creado un nuevo perfil");
              }else{
                $sesion->set_notification("ERROR", "Ocurrió un error al crear el perfil. Intente de nuevo.");
              }
            }
          }else{
            // UPDATE PERFIL
            $id_perfil = $_POST['perfil_id'];
            $usuario = $_POST['user_edit'];
            $nombre = $_POST['nombre_edit'];
            $apellido_pat = $_POST['apellido_pat_edit'];
            $apellido_mat = $_POST['apellido_mat_edit'];
            $emisor = $_POST['emisor_edit'];
            $puesto = $_POST['puesto_edit'];

            $perfil_pdo = new PerfilPDO();
            if( $perfil_pdo->update_perfil($id_perfil, $usuario, $nombre, $apellido_pat, $apellido_mat, $emisor, $puesto) ){
              $data_sesion = $sesion->get_session();
              if( $id_perfil == $data_sesion['PerfilId'] ){
                $usuario_pdo = new UsuarioPDO();
                $sesion->set_session($usuario_pdo->get_all_userdata($usuario));
                write_log("ProcessPerfiles | __construct() | Se actualizó el perfil de la sesión actual");
              }
              $sesion->set_notification("OK", "Los datos se actualizaron correctamente.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar el perfil.");
            }
          }
        }
      }else{
        write_log("ProcessPerfiles | __contruct() | NO se recibieron datos por POST");
      }
      header("location: " . $hostname . "/administrar/perfiles");
    }
  }

  class SwitchActivoGrupos{
    function __construct($host_name="", $site_name="", $datos=null){
      // Valida la sesión del usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
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
      }else{
        header("Location: " . $hostname . "/login");
      }
    }
  }

  class ViewEmisores{
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Administrar | Emisores";
      $data['host'] = $host_name;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();

      $pac = new PacPDO();
      $data['pacs'] = $pac->get_active_pac();

      $emisor_pdo = new EmisorPDO();
      $data['emisores'] = $emisor_pdo->get_all();

      $this->view = new View();
      $this->view->render('views/modules/administrar/emisores.php', $data, true);
    }
  }

  class ProcessEmisores{
    function __construct($hostname="", $sitename="", $dataurl=null){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if( $sesion->validate_token($token) ){
          if( empty($_POST['id_emisor']) ){
            // INSERT EMISOR
            $nombre = $_POST['nombre'];
            $rfc = $_POST['rfc'];
            $pac = $_POST['pac'];
            $tpo_persona = $_POST['tipo_persona'];

            $emisor_pdo = new EmisorPDO();
            if( $emisor_pdo->insert_emisor($nombre, $rfc, $pac, $tpo_persona) ){
              // Obtiene el Id del Emisor que se insertó
              $data_emisor = $emisor_pdo->get_emisor_by_rfc($rfc);
              if( $data_emisor ){
                // Crea el CSD del Emisor
                $csd_pdo = new CSD_PDO();
                if( $csd_pdo->insert_csd($data_emisor['Id']) ){
                  $sesion->set_notification("OK", "Se ha agregado el nuevo emisor.");
                }else{
                  $sesion->set_notification("ERROR", "Se registró el Emisor pero no fue posible crear un registro CSD ligado al Emisor.");
                }
              }
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al agregar el emisor. Intente de nuevo.");
            }
          }else{
            // UPDATE EMISOR
            $id_emisor = $_POST['id_emisor'];
            $emisor = $_POST['nombre_edit'];
            $rfc_edit = $_POST['rfc_edit'];
            $domicilio = $_POST['domicilio_edit'];
            $codigo_postal = $_POST['codigo_postal_edit'];
            $tipo_persona = $_POST['tipo_persona_edit'];
            $str_regimen = $_POST['regimen_edit'];
            $pac = $_POST['pac_edit'];
            $modo = $_POST['modo_edit'];

            $array_regimen = explode(" | ", $str_regimen);
            $regimen = $array_regimen[0];
            $desc_regimen = $array_regimen[1];
            // Valida si se ingresó un nuevo Logo
            if(!empty($_FILES['logo_edit'])){
              $file = $_FILES['logo_edit'];
              $type = $file['type'];
              // Valida el Tipo de Archivo
              if($type == "image/jpg" || $type == "image/jpeg" || $type == "image/png"){
                $extension = substr($file['name'], strpos($file['name'], '.'), strlen($file['name']));
                $pathlogo = "uploads/". $rfc_edit ."/logo" . $extension;
                // Valida si existe el directorio donde se guardará el Logo
                if(!is_dir("uploads/". $rfc_edit)){
                  mkdir("uploads/". $rfc_edit, 0777);
                }
                move_uploaded_file($file['tmp_name'], $pathlogo);
                write_log("ProcessEmisores | __contruct() | Se cargó la imagen de forma exitosa");
              }else{
                write_log("ProcessEmisores | __contruct() | El archivo NO es una imágen");
                $sesion->set_notification("ERROR", "El Logotipo que desea cargar no es una imagen");
                header("location: " . $hostname . "/administrar/emisores");
              }
            }

            $emisor_pdo = new EmisorPDO();
            $data_emisor = $emisor_pdo->get_emisor($id_emisor);
            $rfc_emisor = $data_emisor['RFC'];

            if($rfc_emisor != $rfc_edit){
              // Elimina el logotipo anterior
              unlink($data_emisor['PathLogo']);
              // Elimina la carpeta anterior
              if(rmdir("uploads/". $rfc_emisor)){
                write_log("ProcessEmisores | __contruct() | Se eliminó la carpeta del Emisor: ". $rfc_emisor);
              }else{
                write_log("ProcessEmisores | __contruct() | Ocurrió un error al eliminar la carpeta del Emisor: ". $rfc_emisor);
              }
            }
            if( empty($pathlogo) ){
              $pathlogo = $data_emisor['PathLogo'];
            }
            // Hace el UPDATE
            if( $emisor_pdo->update_emisor($id_emisor, $emisor, $rfc_edit, $domicilio, $codigo_postal, $tipo_persona,
            $regimen, $desc_regimen, $pathlogo, $pac, $modo) ){
              $sesion->set_notification("OK", "Los datos del Emisor se actualizaron correctamente.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar los datos del Emisor.");
            }
          }
        }else{
          write_log("ProcessEmisores | __contruct() | Token NO Válido");
          $sesion->set_notification("ERROR", "No fue posible procesar su solicitud. Inténtelo de nuevo.");
        }
      }else{
        write_log("ProcessEmisores | __contruct() | NO se recibieron datos por POST");
      }
      header("location: " . $hostname . "/administrar/emisores");
    }
  }

  class SwitchActivoEmisores{
    function __construct($hostname="", $sitename="", $dataurl=null){
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
        $emisor_id = $dataurl[1];
        $emisor_pdo = new EmisorPDO();

        $status_actual = $dataurl[2];

        if($status_actual == 1){
          $nuevo_status = 0;
          $msg_status="Se ha desactivado el Emisor.";
        }else{
          $nuevo_status = 1;
          $msg_status="Se ha activado el Emisor.";
        }

        if( $emisor_pdo->cambiar_activo($emisor_id, $nuevo_status) ){
          $sesion->set_notification("OK", $msg_status);
        }else{
          $sesion->set_notification("ERROR", "Ocurrió un error al realizar el cambio de Estatus del Emisor.");
        }
      }else{
        header("Location: " . $hostname . "/login");
      }
      header("location: " . $hostname . "/administrar/emisores");
    }
  }

  class ViewClientes{
    function __construct($hostname="", $sitename="", $dataurl=null){
      $data['title'] = "Facturación 3.3 | Administrar | Clientes";
      $data['host'] = $hostname;

      $sesion = new UserSession();
      $data_session = $sesion->get_session();
      $emisor = $data_session['Emisor'];
      $data['token'] = $sesion->set_token();

      $cliente_pdo = new ClientePDO();
      $data['clientes'] = $cliente_pdo->get_clientes($emisor);

      $this->view = new View();
      $this->view->render('views/modules/administrar/clientes.php', $data, true);
    }
  }

  class ViewDetalleClientes{
    function __construct($hostname="", $sitename="", $dataurl=null){
      $data['title'] = "Facturación 3.3 | Administrar | Cliente";
      $data['host'] = $hostname;

      $id_cliente = $dataurl[1];

      $sesion = new UserSession();
      $data_session = $sesion->get_session();
      $emisor = $data_session['Emisor'];
      $data['token'] = $sesion->set_token();

      $cliente_pdo = new ClientePDO();
      $data['cliente'] = $cliente_pdo->get_cliente($id_cliente, $emisor);

      $contacto_pdo = new ContactoPDO();
      $data['contactos'] = $contacto_pdo->get_contactos_cliente($data['cliente']['Id']);

      if( $data['cliente'] ){
        $this->view = new View();
        $this->view->render('views/modules/administrar/clientes_detalles.php', $data, true);
      }else{
        $sesion->set_notification("ERROR", "Ocurrió un error al obtener los datos del cliente o NO tiene los permisos para consultarlo");
        header("location:". $hostname . "/administrar/clientes/". $id_cliente);
      }
    }
  }

  class ProcessClientes{
    function __construct($hostname="", $sitename="", $dataurl=null){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        if($sesion->validate_token($token)){
          if( empty($_POST['id_cliente']) ){
            // INSERT CLIENTE
            $nombre = $_POST['nombre'];
            $rfc = $_POST['rfc'];
            $tipo_persona = $_POST['tipo_persona'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];

            $cliente_pdo = new ClientePDO();
            if( $cliente_pdo->insert_cliente($emisor, $nombre, $rfc, $tipo_persona, $direccion, $telefono, $correo) ){
              $sesion->set_notification("OK", "Se ha agregado el nuevo cliente. ");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al registrar el producto o servicio.");
            }
            $redirect = $hostname ."/administrar/clientes";
          }else{
            // UPDATE CLIENTE
            $id = $_POST['id_cliente'];
            $nombre = $_POST['nombre_edit'];
            $rfc = $_POST['rfc_edit'];
            $tipo_persona = $_POST['tipo_persona_edit'];
            $direccion = $_POST['direccion_edit'];
            $telefono = $_POST['telefono_edit'];
            $correo = $_POST['correo_edit'];

            $cliente_pdo = new ClientePDO();
            if( $cliente_pdo->update_cliente($id, $emisor, $nombre, $rfc, $tipo_persona, $direccion, $telefono, $correo) ){
              $sesion->set_notification("OK", "Se actualizaron los datos de su cliente.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar los datos de su cliente. Inténtelo nuevamente.");
            }
            $redirect = $hostname ."/administrar/clientes/detalles/". $id;
          }
        }
      }else{
        write_log("ProcessClientes | __contruct() | NO se recibieron datos por POST");
      }
      header("location: " . $redirect);
    }
  }

  class SwitchActivoClientes{
    function __construct($hostname="", $sitename="", $dataurl=null){
      // Valida la sesión del usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
        $cliente_id = $dataurl[1];
        $status_actual = $dataurl[2];

        if($status_actual == 1){
          $nuevo_status = 0;
          $msg_status="Se ha desactivado el cliente";
        }else{
          $nuevo_status = 1;
          $msg_status="Se ha activado el cliente";
        }

        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        $cliente_pdo = new ClientePDO();
        if($cliente_pdo->cambiar_activo($cliente_id, $emisor, $nuevo_status)){
          $sesion->set_notification("OK", $msg_status);
        }else{
          $sesion->set_notification("ERROR", "Ocurrió un error al realizar el cambio de Estatus");
        }
        header("location: " . $hostname . "/administrar/clientes");
      }else{
        header("Location: " . $hostname . "/login");
      }
    }
  }

  class ProcessContactos{
    function __construct($hostname="", $sitename="", $dataurl=null){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        if($sesion->validate_token($token)){
          if( empty($_POST['contacto_id']) ){
            // INSERT CONTACTO
            $id_cliente = $_POST['cliente_id'];
            $alias = $_POST['alias'];
            $nombre = $_POST['nombre'];
            $apellido_pat = $_POST['apellido_pat'];
            $apellido_mat = $_POST['apellido_mat'];
            $puesto = $_POST['puesto'];
            $email = $_POST['email'];
            $tel_1 = $_POST['tel_1'];
            $tel_2 = $_POST['tel_2'];

            $contacto_pdo = new ContactoPDO();
            if( $contacto_pdo->insert_contacto($id_cliente, $alias, $nombre, $apellido_pat, $apellido_mat, $puesto, $email, $tel_1, $tel_2) ){
              $sesion->set_notification("OK", "Se ha agregado el nuevo contacto. ");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al registrar el nuevo contacto. Intente realizarlo nuevamente.");
            }
            $redirect = $hostname ."/administrar/clientes/detalles/". $id_cliente;
          }else{
            // UPDATE CONTACTO
            $id_contacto = $_POST['contacto_id'];
            $id_cliente = $_POST['cliente_id'];
            $alias = $_POST['alias_edit'];
            $nombre = $_POST['nombre_edit'];
            $apellido_pat = $_POST['apellido_pat'];
            $apellido_mat = $_POST['apellido_mat'];
            $puesto = $_POST['puesto'];
            $email = $_POST['email'];
            $tel1 = $_POST['tel_1'];
            $tel2 = $_POST['tel_2'];

            $contacto_pdo = new ContactoPDO();
            if( $contacto_pdo->update_contacto($id_contacto, $id_cliente, $alias, $nombre, $apellido_pat, $apellido_mat, $puesto, $email, $tel1, $tel2) ){
              $sesion->set_notification("OK", "Se actualizaron los datos de su contacto.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar los datos de su contacto. Inténtelo nuevamente.");
            }
          }
        }
      }else{
        write_log("ProcessContactos | __contruct() | NO se recibieron datos por POST");
      }
      header("location: " . $hostname ."/administrar/clientes/detalles/". $id_cliente);
    }
  }
  class DeleteContactos{
    function __construct($hostname="", $sitename="", $dataurl=null){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $cliente_id = $_POST['cliente_id'];

        if($sesion->validate_token($token)){
          if( empty($_POST['contacto_id']) ){
            $sesion->set_notification("ERROR", "No fue posible realizar la operación solicitada.");
            write_log("DeleteContactos | __construct() | No se recibió el 'contacto_id'");
          }else{
            // DELETE CONTACTO
            $id_contacto = $_POST['contacto_id'];
            $contacto_pdo = new ContactoPDO();
            if( $contacto_pdo->delete_contacto($id_contacto, $cliente_id) ){
              $sesion->set_notification("OK", "Se ha eliminado el contacto.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al eliminar el contacto. Intentelo nuevamente.");
            }
          }
        }
      }else{
        write_log("ProcessContactos | __contruct() | NO se recibieron datos por POST");
      }
      header("location: " . $hostname ."/administrar/clientes/detalles/". $cliente_id);
    }
  }

  class ViewProdServs{
    function __construct($hostname="", $sitename="", $dataurl=null){
      $data['title'] = "Facturación 3.3 | Administrar | Productos y Servicios";
      $data['host'] = $hostname;

      $sesion = new UserSession();
      $data_session = $sesion->get_session();
      $emisor = $data_session['Emisor'];
      $data['token'] = $sesion->set_token();

      $prod_serv_pdo = new ProdServPDO();
      $data['prod_servs'] = $prod_serv_pdo->get_all($emisor);
      // Obtiene las Claves Activas de Productos/Servicios del Emisor
      $clave_prodserv_pdo = new CatSATProdServ();
      $data['claves_prodserv'] = $clave_prodserv_pdo->get_all_actives($emisor);
      // Obtiene las Claves Activas de Unidades del Emisor
      $catsatunidad_pdo = new CatSATUnidades();
      $data['unidades'] = $catsatunidad_pdo->get_all_actives($emisor);
      // Obtiene los Impuestos Activos del Emisor
      $catsatimpuestos_pdo = new CatSATImpuestos();
      $data['impuestos'] = $catsatimpuestos_pdo->get_all_actives($emisor);

      $this->view = new View();
      $this->view->render('views/modules/administrar/prod_serv.php', $data, true);
    }
  }

  class ProcessProdServs{
    function __construct($hostname="", $sitename="", $dataurl=null){
      if ($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        if($sesion->validate_token($token)){
          if( empty($_POST['id_prodserv']) ){
            // INSERT PRODSERV
            $sku = $_POST['sku'];
            $nombre = $_POST['nombre'];
            $prodserv = $_POST['clave_prodserv'];
            $unidad = $_POST['clave_unidad'];
            $precio = $_POST['precio'];
            $impuesto = $_POST['impuesto'];

            $prodserv_pdo = new ProdServPDO();
            // Verifica que no exista otro producto con ese SKU
            if( $prodserv_pdo->get_prodserv_by_sku($emisor, $sku) ){
              $sesion->set_notification("ERROR", "Ocurrió un error al registrar el producto o servicio. ".
              "El SKU que ingresó ('". $sku ."') ya existe.");
            }else{
              if( $prodserv_pdo->insert_prodserv($emisor, $sku, $nombre, $prodserv, $unidad, $precio, $impuesto) ){
                $sesion->set_notification("OK", "Se ha agregado el nuevo producto o servicio.");
              }else{
                $sesion->set_notification("ERROR", "Ocurrió un error al agregar el producto o servicio. Intente de nuevo.");
              }
            }
          }else{
            // UPDATE PRODSERV
            $id = $_POST['id_prodserv'];
            $sku = $_POST['sku_edit'];
            $nombre = $_POST['nombre_edit'];
            $prodserv = $_POST['clave_prodserv_edit'];
            $unidad = $_POST['clave_unidad_edit'];
            $precio = $_POST['precio_edit'];
            $impuesto = $_POST['impuesto_edit'];

            $prodserv_pdo = new ProdServPDO();
            if( $prodserv_pdo->update_prodserv($id, $emisor, $sku, $nombre, $prodserv, $unidad, $precio, $impuesto) ){
              $sesion->set_notification("OK", "Los datos se actualizaron correctamente.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al actualizar los datos del Producto/Servicio. Inténtelo nuevamente.");
            }
          }
        }
      }else{
        write_log("ProcessProdServs | __contruct() | NO se recibieron datos por POST");
      }
      header("location: " . $hostname . "/administrar/prodserv");
    }
  }

  class SwitchActivoProdServ{
    function __construct($hostname="", $sitename="", $dataurl=null){
      // Valida la sesión del usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
        $prodserv_id = $dataurl[1];
        $status_actual = $dataurl[2];

        if($status_actual == 1){
          $nuevo_status = 0;
          $msg_status="Se ha desactivado el Producto o Servicio.";
        }else{
          $nuevo_status = 1;
          $msg_status="Se ha activado el Producto o Servicio.";
        }

        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        $prodserv_pdo = new ProdServPDO();
        if($prodserv_pdo->cambiar_activo($prodserv_id, $emisor, $nuevo_status)){
          $sesion->set_notification("OK", $msg_status);
        }else{
          $sesion->set_notification("ERROR", "Ocurrió un error al realizar el cambio de Estatus");
        }
        header("location: " . $hostname . "/administrar/prodserv");
      }else{
        header("Location: " . $hostname . "/login");
      }
    }
  }

  class ViewProdServ{
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
  /* ..:: CAT SAT ProdServ ::.. */
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
        write_log("ProcessProdServ | __contruct() | NO se recibieron datos por POST");
      }
    }
  }

  class SwitchActivoProdServSAT{
    function __construct($host_name="", $site_name="", $datos=null){
      // Valida la sesión del usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
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
      }else{
        header("Location: " . $hostname . "/login");
      }
    }
  }

  /* ..:: CAT SAT Unidades ::.. */
  class ViewUnidades{
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Catalogo Unidades";
      $data['host'] = $host_name;

      $sesion = new UserSession();
      $data_session = $sesion->get_session();
      $emisor = $data_session['Emisor'];

      $unidades_pdo = new CatSATUnidades();
      $data['cat_unidades'] = $unidades_pdo->get_all_catsat();
      $data['unidades'] = $unidades_pdo->get_all($emisor);

      $this->view = new View();
      $this->view->render('views/modules/catsat/unidades.php',$data, true);
    }
  }

  class ProcessUnidad{
    function __construct($host_name="", $site_name="", $datos=null){
      if($_POST){
        $clave = $_POST['unidad'];

        $unidad_pdo = new CatSATUnidades();
        $sesion = new UserSession();

        if($unidad_pdo->add_unidad($clave)){
          $sesion->set_notification("OK", "Se agregó la Unidad a su catálogo");
        }else{
          $sesion->set_notification("ERROR", "Ocurrió un error al agregar la Clave de Producto o Servicio. Intente de nuevo");
        }
        header("location: " . $host_name . "/catalogosSAT/unidades");
      }else{
        write_log("ProcessUnidad | construct() | NO se recibieron datos por POST");
      }
    }
  }

  class SwitchActivoUnidades{
    function __construct($host_name="", $site_name="", $dataurl=null){
      // Valida la sesión del usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
        // Obtiene el Emisor
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        $unidad_id = $dataurl[1];
        $catsatunidad_pdo = new CatSATUnidades($unidad_id, $nuevo_status);
        // Verifica que la Unidad pertenezca al usuario logueado
        if( $catsatunidad_pdo->get_unidad($unidad_id, $emisor) != false ){
          $status_actual = $dataurl[2];

          if($status_actual == 1){
            $nuevo_status = 0;
            $msg_status="Se ha desactivado la Unidad de su catálogo.";
          }else{
            $nuevo_status = 1;
            $msg_status="Se ha activado la Unidad seleccionada en el catálogo.";
          }

          if( $catsatunidad_pdo->cambiar_activo($unidad_id, $nuevo_status, $emisor) ){
            $sesion->set_notification("OK", $msg_status);
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error al realizar el cambio de Estatus de la Unidad.");
          }
        }else{
          $sesion->set_notification("ERROR", "No fue posible actualizar el Estatus de la Unidad. No se encontró la ".
          "Unidad o no tiene los permisos para poder editarla.");
        }
      }else{
        header("Location: " . $hostname . "/login");
      }
      header("location: " . $host_name . "/catalogosSAT/unidades");
    }
  }

  /* ..:: CAT SAT Formas de Pago ::.. */
  class ViewFormasPago{
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Catalogo Formas de Pago";
      $data['host'] = $host_name;

      $sesion = new UserSession();
      $data_session = $sesion->get_session();
      $emisor = $data_session['Emisor'];

      $formaspago_pdo = new CatSATFormaPago();
      $data['cat_formaspago'] = $formaspago_pdo->get_all_catsat();
      $data['formaspago'] = $formaspago_pdo->get_all($emisor);

      $this->view = new View();
      $this->view->render('views/modules/catsat/formaspago.php',$data, true);
    }
  }

  class ProcessFormasPago{
    function __construct($host_name="", $site_name="", $datos=null){
      if($_POST){
        $clave = $_POST['formapago'];

        $formapago_pdo = new CatSATFormaPago();
        $sesion = new UserSession();

        if($formapago_pdo->add_formapago($clave)){
          $sesion->set_notification("OK", "Se agregó la Clave de Producto o Servicio a su catálogo");
        }else{
          $sesion->set_notification("ERROR", "Ocurrió un error al agregar la Clave de Producto o Servicio. Intente de nuevo");
        }
        header("location: " . $host_name . "/catalogosSAT/formas_pago");
      }else{
        write_log("ProcessUnidad | construct() | NO se recibieron datos por POST");
      }
    }
  }

  class SwitchActivoFormasPago{
    function __construct($hostname="", $site_name="", $dataurl=null){
      // Valida la sesión del usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
        // Obtiene el Emisor
        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        $formapago_id = $dataurl[1];
        $formapago_pdo = new CatSATFormaPago($formapago_id, $nuevo_status);
        // Verifica que la Unidad pertenezca al usuario logueado
        if( $formapago_pdo->get_formapago($formapago_id, $emisor) != false ){
          $status_actual = $dataurl[2];

          if($status_actual == 1){
            $nuevo_status = 0;
            $msg_status="Se ha desactivado la Forma de pago de su catálogo.";
          }else{
            $nuevo_status = 1;
            $msg_status="Se ha activado la Forma de pago de su catálogo.";
          }

          if( $formapago_pdo->cambiar_activo($formapago_id, $nuevo_status, $emisor) ){
            $sesion->set_notification("OK", $msg_status);
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error al realizar el cambio de Estatus de la Forma de Pago.");
          }
        }else{
          $sesion->set_notification("ERROR", "No fue posible actualizar el Estatus de la Forma de Pago. No se encontró la ".
          "Forma de Pago o no tiene los permisos para poder editarla.");
        }
      }else{
        header("Location: " . $hostname . "/login");
      }
      header("location: " . $hostname . "/catalogosSAT/formas_pago");
    }
  }

  /* ..:: CAT SAT Monedas ::.. */
  class ViewMonedas{
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Catalogo Monedas";
      $data['host'] = $host_name;

      $sesion = new UserSession();
      $data_session = $sesion->get_session();
      $emisor = $data_session['Emisor'];

      $monedas_pdo = new CatSATMoneda();
      $data['cat_monedas'] = $monedas_pdo->get_all_catsat();
      $data['monedas'] = $monedas_pdo->get_all($emisor);

      $this->view = new View();
      $this->view->render('views/modules/catsat/monedas.php',$data, true);
    }
  }

  class ProcessMonedas{
    function __construct($hostname="", $site_name="", $datos=null){
      if($_POST){
        $moneda = $_POST['moneda'];

        $moneda_pdo = new CatSATMoneda();
        $sesion = new UserSession();

        if($moneda_pdo->add_moneda($moneda)){
          $sesion->set_notification("OK", "Se agregó la Clave de Producto o Servicio a su catálogo");
        }else{
          $sesion->set_notification("ERROR", "Ocurrió un error al agregar la Clave de Producto o Servicio. Intente de nuevo");
        }
        header("location: " . $hostname . "/catalogosSAT/monedas");
      }else{
        write_log("ProcessMonedas | construct() | NO se recibieron datos por POST");
      }
    }
  }

  class SwitchActivoMonedas{
    function __construct($hostname="", $site_name="", $dataurl=null){
      // Valida la sesión del usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
        // Obtiene el Emisor
        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        $moneda_id = $dataurl[1];
        $moneda_pdo = new CatSATMoneda();
        // Verifica que la Moneda pertenezca al usuario logueado
        if( $moneda_pdo->get_moneda($moneda_id, $emisor) != false ){
          $status_actual = $dataurl[2];

          if($status_actual == 1){
            $nuevo_status = 0;
            $msg_status="Se ha desactivado la Moneda de su catálogo.";
          }else{
            $nuevo_status = 1;
            $msg_status="Se ha activado la Moneda de su catálogo.";
          }

          if( $moneda_pdo->cambiar_activo($moneda_id, $nuevo_status, $emisor) ){
            $sesion->set_notification("OK", $msg_status);
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error al realizar el cambio de Estatus de la Moneda.");
          }
        }else{
          $sesion->set_notification("ERROR", "No fue posible actualizar el Estatus de la Moneda. No se encontró la ".
          "Moneda o no tiene los permisos para poder editarla.");
        }
      }else{
        header("Location: " . $hostname . "/login");
      }
      header("location: " . $hostname . "/catalogosSAT/monedas");
    }
  }

  /* ..:: CAT SAT Impuestos ::.. */
  class ViewImpuestos{
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Catalogo Impuestos";
      $data['host'] = $host_name;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();
      $data_session = $sesion->get_session();
      $emisor = $data_session['Emisor'];

      $impuestos_pdo = new CatSATImpuestos();
      $data['cat_impuestos'] = $impuestos_pdo->get_all_catsat();
      $data['impuestos'] = $impuestos_pdo->get_all($emisor);

      $this->view = new View();
      $this->view->render('views/modules/catsat/impuestos.php',$data, true);
    }
  }

  class ProcessImpuestos{
    function __construct($hostname="", $site_name="", $datos=null){
      if($_POST){
        $impuestos_pdo = new CatSATImpuestos();

        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        if( empty($_POST['id_impuesto']) ){
          // INSERT
          $impuestos = $_POST['impuesto'];
          $descripcion = $_POST['descripcion_impuesto'];
          $factor = $_POST['tipo_factor'];
          $tasa_cuota = $_POST['tasa_cuota'];

          if( $impuestos_pdo->insert_impuesto($emisor, $impuestos, $descripcion, $factor, $tasa_cuota) ){
            $sesion->set_notification("OK", "Se agregó el Nuevo Impuesto a su Catálogo");
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error al agregar el Impuesto a su catálogo. Intente de nuevo");
          }
          header("location: " . $hostname . "/catalogosSAT/impuestos");
        }else{
          // UPDATE
          $id_impuesto = $_POST['id_impuesto'];
          $strimpuesto = $_POST['impuesto_edit'];
          $descripcion = $_POST['descripcion_impuesto_edit'];
          $factor = $_POST['tipo_factor_edit'];
          $tasa_cuota = $_POST['tasa_cuota_edit'];

          if( $impuestos_pdo->update_impuesto($id_impuesto, $emisor, $strimpuesto, $descripcion, $factor, $tasa_cuota) ){
            $sesion->set_notification("OK", "Se actualizaron los datos del Impuesto de Forma correcta.");
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error al actualizar el Impuesto. Puede intentarlo de nuevo.");
          }
          header("location: ". $hostname ."/catalogosSAT/impuestos");
        }
      }else{
        write_log("ProcessImpuestos | construct() | NO se recibieron datos por POST");
      }
    }
  }

  class SwitchActivoImpuestos{
    function __construct($hostname="", $sitename="", $dataurl=null){
      // Valida la sesión del usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
        // Obtiene el Emisor
        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        $impuesto_id = $dataurl[1];
        $impuesto_pdo = new CatSATImpuestos();
        // Verifica que el Impuesto Pertenezca al Emisor
        if( $impuesto_pdo->get_impuesto($impuesto_id, $emisor) != false ){
          $status_actual = $dataurl[2];

          if($status_actual == 1){
            $nuevo_status = 0;
            $msg_status="Se ha desactivado el Impuesto de su catálogo.";
          }else{
            $nuevo_status = 1;
            $msg_status="Se ha activado el Impuesto de su catálogo.";
          }

          if( $impuesto_pdo->cambiar_activo($impuesto_id, $nuevo_status, $emisor) ){
            $sesion->set_notification("OK", $msg_status);
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error al realizar el cambio de Estatus del Impuesto.");
          }
        }else{
          $sesion->set_notification("ERROR", "No fue posible actualizar el Estatus del Impuesto. No se encontró la ".
          "Moneda o no tiene los permisos para poder editarla.");
        }
      }else{
        header("Location: " . $hostname . "/login");
      }
      header("location: " . $hostname . "/catalogosSAT/impuestos");
    }
  }

  /* ..:: Series & CSD ::.. */
  class ViewSeries{
    function __construct($host_name="", $site_name="", $variables=null){
      $data['title'] = "Facturación 3.3 | Series";
      $data['host'] = $host_name;

      $sesion = new UserSession();
      $data['token'] = $sesion->set_token();
      $data_session = $sesion->get_session();
      $emisor = $data_session['Emisor'];

      $serie_pdo = new SeriePDO();
      $data['series'] = $serie_pdo->get_all($emisor);
      $data['tipo_comprobantes'] = $serie_pdo->get_tpocomprobantes_catsat();

      $this->view = new View();
      $this->view->render('views/modules/administrar/series.php',$data, true);
    }
  }

  class ProcessSeries{
    function __construct($hostname="", $site_name="", $datos=null){
      if($_POST){
        $serie_pdo = new SeriePDO();

        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        if( empty($_POST['id_serie']) ){
          // INSERT
          $serie = $_POST['serie'];
          $descripcion = $_POST['descripcion'];
          $tipo_comprobante = $_POST['tipo_comprobante'];
          $consecutivo = $_POST['consecutivo'];

          if( $serie_pdo->get_serie_by_serie_emisor($emisor, $serie) != false ){
            $sesion->set_notification("ERROR", "No fue posible agregar la serie. La serie que desea agregar ya existe.");
          }else{
            if( $serie_pdo->insert_serie($emisor, $serie, $descripcion, $tipo_comprobante, $consecutivo) ){
              $sesion->set_notification("OK", "Se agregó correctamente la Nueva Serie.");
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al agregar la Serie. Intente de nuevo");
            }
          }
          header("location: " . $hostname . "/administrar/series");
        }else{
          // UPDATE
          $id_serie = $_POST['id_serie'];
          $serie = $_POST['serie_edit'];
          $descripcion = $_POST['descripcion_edit'];
          $tipo_comprobante = $_POST['tipo_comprobante_edit'];
          $consecutivo = $_POST['consecutivo_edit'];

          if( $serie_pdo->update_serie($id_serie, $serie, $descripcion, $tipo_comprobante, $consecutivo) ){
            $sesion->set_notification("OK", "Se actualizaron los datos de la Serie de Forma correcta.");
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error al actualizar la Serie. Intentelo nuevamente.");
          }
          header("location: ". $hostname ."/administrar/series");
        }
      }else{
        write_log("ProcessSeries | construct() | NO se recibieron datos por POST");
      }
    }
  }

  class SwitchActivoSeries{
    function __construct($hostname="", $sitename="", $dataurl=null){
      // Valida la sesión del usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
        // Obtiene el Emisor
        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        $serie_id = $dataurl[1];
        $serie_pdo = new SeriePDO();
        // Verifica que la Serie Pertenezca al Emisor
        if( $serie_pdo->get_serie($serie_id, $emisor) != false ){
          $status_actual = $dataurl[2];

          if($status_actual == 1){
            $nuevo_status = 0;
            $msg_status="Se ha desactivado la Serie seleccionada.";
          }else{
            $nuevo_status = 1;
            $msg_status="Se ha activado la Serie seleccionada.";
          }

          if( $serie_pdo->cambiar_activo($serie_id, $nuevo_status, $emisor) ){
            $sesion->set_notification("OK", $msg_status);
          }else{
            $sesion->set_notification("ERROR", "Ocurrió un error al realizar el cambio de Estatus del Impuesto.");
          }
        }else{
          $sesion->set_notification("ERROR", "No fue posible actualizar el Estatus del Impuesto. No se encontró la ".
          "Moneda o no tiene los permisos para poder editarla.");
        }
      }else{
        header("Location: " . $hostname . "/login");
      }
      header("location: " . $hostname . "/administrar/series");
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
      // Obtiene el uso_concepto del CFDI
      $usocfdi_pdo = new CatSATUsosCFDI();
      $data['uso_concepto'] = $usocfdi_pdo->get_uso_concepto($data['comprobante']['ClaveUsoCFDI']);
      // Crea una instancia ContactoPDO y obtiene los contactos
      $contacto_pdo = new ContactoPDO();
      $data['contactos'] = $contacto_pdo->get_contactos_cliente($data['comprobante']['IdReceptor']);
      // Token para el <Form>
      $data['token'] = $sesion->set_token();

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

      // Obtiene el Emisor para obtener toda su configuración de los catálogos del SAT
      $data_session = $sesion->get_session();
      $emisor = $data_session['Emisor'];

      // Obtiene los clientes del usuario (Emisor)
      $cliente = new ClientePDO();
      $data['clientes'] = $cliente->get_clientes($emisor);
      // Obtiene los metodos de pago
      $metodo = new CatSATMetodos();
      $data['metodos_pago'] = $metodo->get_all();
      // Obtiene las formas de pago
      $forma_pago = new CatSATFormaPago();
      $data['formas_pago'] = $forma_pago->get_all_actives($emisor);
      // // Obtiene los usos CFDI
      // $usos_cfdi = new CatSATUsosCFDI();
      // $data['usos_cfdi'] = $usos_cfdi->get_all();
      // Obtiene las monedas
      $moneda = new CatSATMoneda();
      $data['monedas'] = $moneda->get_all_actives($emisor);
      // Obtiene las series
      $serie = new SeriePDO();
      $data['series'] = $serie->get_all_actives($emisor);
      // Obtiene los productos
      $productos = new ProdServPDO();
      $data['productos'] = $productos->get_all($emisor);
      // Obtiene fecha y hora actual
      $data['fecha'] = date('Y-m-d');
      $data['hora'] = date("H:i:s");

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
      $csd_pdo = new CSD_PDO();
      $datos_csd = $csd_pdo->get_csd($emisor);
      $certificado = $datos_csd['Certificado'];
      $nocertificado = $datos_csd['NoCertificado'];
      // Crea una instancia de ComprobantePDO
      $comprobante_pdo = new ComprobantePDO();
      // Crea el XML y devulve la ruta y nombre del archivo creado
      $path_xml = $comprobante_pdo->create_xml($id_comprobante, $emisor, $certificado, $nocertificado);

      if( $path_xml != false ){
        $emisor_pdo = new EmisorPDO();
        $datos_emisor = $emisor_pdo->get_emisor($emisor);
        $pac_id = $datos_emisor['PAC'];
        // Obtiene la información del PAC
        $pac_pdo = new PacPDO();
        $pac_info = $pac_pdo->get_pac($pac_id);
        // Timbra el comprobante con los datos del PAC
        if($comprobante_pdo->timbrar($id_comprobante, $path_xml, $pac_info, $datos_emisor['Testing'])){
          if($comprobante_pdo->create_pdf($id_comprobante, $path_xml, $datos_emisor)){
            $sesion->set_notification("OK", "Se timbró la factura de forma correcta. ".
            "En un tiempo máximo de 72 horas podrá consultar su comprobante en el SAT.");
          }else{
            $sesion->set_notification("WARNING", "Se timbró la factura, pero ocurrió un error al crear el PDF.");
          }
        }else{
          $sesion->set_notification("ERROR", "Ocurrió un error al momento de timbrar. Verifique los datos e intente de nuevo. Si el problema persiste, contacte al administrador");
        }
      }else{
        $sesion->set_notification("ERROR", "Ocurrió un error al generar el XML. Intentelo de nuevo");
      }
      // Redirecciona a la página del comprobante
      header("Location: " . $hostname . "/CFDIs/facturas/detalles/" . $id_comprobante);
    }
  }

  class ProcessDownloadCFDI{
    function __construct($hostname='', $sitename='', $data_url=null){
      // Valida el Usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
        // Obtiene los datos de la URL
        $tipo_archivo = $data_url[1];
        $id_comprobante = $data_url[2];
        // Obtiene los datos de la sesión
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];
        // Obtiene los datos del comprobante
        $comprobante_pdo = new ComprobantePDO();
        $data_comprobante = $comprobante_pdo->get_comprobante($id_comprobante, $emisor);

        if($data_comprobante != false){
          $path_file = $data_comprobante['Path'. strtoupper($tipo_archivo)];
          write_log("Descarga del archivo: " . $path_file);
          if( file_exists($path_file) ){
            header("Content-disposition: attachment; filename=". $path_file);
            header("Content-type: application/". $tipo_archivo);
            readfile($path_file);
          }else{
            write_log("El archivo que se desea descargar no existe.");
            $sesion->set_notification("ERROR", "El archivo que se desea descargar no existe.");
            header('Location:' . getenv('HTTP_REFERER'));
          }
        }else{
          write_log("El comprobante no pertenece al usuario logueado o no existe.");
          $sesion->set_notification("ERROR", "El comprobante no existe o no tiene los permisos para poder descargarlo");
        }
      }else{
        header("Location: " . $hostname . "/login");
      }
    }
  }

  class ProcessVerifyCFDI{
    function __construct($hostname='', $site_name='', $dataurl=null){
      // Valida la sesión del usuario (Debe estar logueado)
      $sesion = new UserSession();
      if( $sesion->validate_session() ){
        // Obtiene los datos de la URL
        $id_comprobante = $dataurl[1];
        // Obtiene los datos de la sesión
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];
        // Obtiene los datos del comprobante
        $comprobante_pdo = new ComprobantePDO();
        $data_comprobante = $comprobante_pdo->get_comprobante($id_comprobante, $emisor);

        if($data_comprobante != false){
          $rfc_emisor = $data_comprobante['RFCEmisor'];
          $rfc_receptor = $data_comprobante['RFCReceptor'];
          $total = $data_comprobante['Total'];
          $uuid = $data_comprobante['UUID'];
          $data_cfdi = $comprobante_pdo->verify_sat($rfc_emisor, $rfc_receptor, $total, $uuid);
          write_log(serialize($data_cfdi));

          if($data_comprobante['EstatusSAT'] != NULL && $data_cfdi != false){
            // Compara el EstatusSAT del CFDI con el de la respuesta del servicio
            if($data_comprobante['EstatusSAT'] == $data_cfdi['Estado']){
              write_log("ProcessVerifyCFDI | | El Estatus del comprobante no ha recibido cambios ante el SAT");
              $sesion->set_notification("OK", "Se sincronizó correctamente con el SAT. El estatus del comprobante no ha recibido cambios.");
            }else{
              write_log("ProcessVerifyCFDI | | Hay cambios en el Estatus SAT del comprobante.");
              // Actualiza el estatus del comprobante
              if($comprobante_pdo->update_status_sat($id_comprobante, $data_cfdi['Estado'])){
                $sesion->set_notification("OK", "Se sincronizó correctamente con el SAT. Hubo cambios en el estatus de su comprobante, ya se encuentra actualizado.");
              }else{
                $sesion->set_notification("WARNING", "Se sincronizó correctamente con el SAT. ".
                "Hubo cambios en su comprobante pero no fue posible actualizarlo. Estatus: " .$data_cfdi['Estado']);
              }
            }
          }else{
            if( $data_cfdi == false ){
              write_log("El comprobante aún no se encuentra en el SAT");
              $sesion->set_notification("WARNING", "El comprobante aún no se encuentra en el SAT. " .
              "El tiempo de espera puede ser de hasta 72 horas después de timbrarse.Espere un momento y vuelva a intentarlo.");
            }else{
              // Hace el UPDATE con el Estatus que devolvió el SAT
              if($comprobante_pdo->update_status_sat($id_comprobante, $data_cfdi['Estado'])){
                // Actualiza el comprobante con el NUEVO Estatus
                if( $comprobante_pdo->update_to_cancel($id_comprobante, $data_cfdi['Estado']) ){
                  $sesion->set_notification("OK", "Se sincronizó con el SAT y se actualizó el Estatus del Comprobante.");
                }else{
                  $sesion->set_notification("WARNING", "Ocurrió un error al actualizar su comprobante con el nuevo Estatus. ".
                  "El Estatus de su comprobante es: Cancelado");
                }
              }else{
                $sesion->set_notification("ERROR", "Ocurrió un error al actualizar el EstatusSAT del comprobante.".
                "EstatusSAT: " . $data_cfdi['Estado']);
              }
            }
          }

        }else{
          write_log("El comprobante no pertenece al usuario logueado o no existe.");
          $sesion->set_notification("ERROR", "El comprobante no existe o no tiene los permisos para poder realizar esta operación con el comprobante");
        }
        header("Location: " . $hostname . "/CFDIs/facturas/detalles/". $id_comprobante);
      }else{
        header("Location: " . $hostname . "/login");
      }
    }
  }

  class ProcessSendCFDI{
    function __construct($hostname='', $sitename='', $dataurl=''){
      // Verifica que se reciban datos por POST
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id_comprobante = $_POST['cfdi'];
          // Obtiene los datos de la sesión
          $data_session = $sesion->get_session();
          $emisor = $data_session['Emisor'];
          // Obtiene los datos del comprobante
          $comprobante_pdo = new ComprobantePDO();
          $data_comprobante = $comprobante_pdo->get_comprobante($id_comprobante, $emisor);

          if($data_comprobante != false){
            $path_xml = $data_comprobante['PathXML'];
            $path_pdf = $data_comprobante['PathPDF'];

            if( file_exists($path_xml) && file_exists($path_pdf) ){
              // Obtiene las opciones de configuración del ConfMailGun
              $mailgun_pdo = new MailGunPDO();
              $config_mail = $mailgun_pdo->get_config();

              if( intval($config_mail['Testing']) == 0 ){
                $apikey=$config_mail['APIKey'];
                $apihost=$config_mail['APIHost'];
                $dominio=$config_mail['Dominio'];
                $from = "SistemaFacturacion <". str_replace(" ", "", $config_mail['Nombre']) . "@" . $dominio . ">";
                $subject = "ENVIO DE CFDI | Sistema Facturación";
              }else{
                $apikey=$config_mail['Test_APIKey'];
                $apihost=$config_mail['Test_APIHost'];
                $dominio=$config_mail['Test_Dominio'];
                $from = "pruebas_mailgun " . "<pruebasmailgun@" . $dominio . ">";
                $subject = "PRUEBA DE ENVÍO DE CFDI | Sistema Facturación";
              }

              $to = $_POST['email'];
              $msg = $_POST['msg_email'];

              require 'libs/mailgun.php';
              $mail_gun = new MailerGun($apikey, $apihost, $dominio);
              $enviado = $mail_gun->send_cfdi($from, $to, $subject, $msg, $path_xml, $path_pdf);

              if($enviado){
                $sesion->set_notification("OK", "Se ha enviado su CFDI de forma correcta al email indicado.");
                header("Location: ". $hostname ."/CFDIs/facturas/detalles/" . $id_comprobante);
              }else{
                $sesion->set_notification("ERROR", "Ocurrió un error al enviar su CFDI. Puede intentarlo de nuevo, ".
                "si el problema persiste contacte al administrador");
                header("Location: ". $hostname ."/CFDIs/facturas/detalles/" . $id_comprobante);
              }
            }else{
              write_log("ProcessSendCFDI | Construct() | No se encontró el PDF o XML \n".
              "No se encontró el archivo xml o pdf del CFDI con Id: " . $id_comprobante);

              $sesion->set_notification("ERROR", "Ocurrió un error al enviar el Email. ".
              "No se logró localizar algunos de los archivos (pdf o xml).");
              header('Location:' . getenv('HTTP_REFERER'));
            }
          }else{
            write_log("El comprobante no pertenece al usuario logueado o no existe.");
            $sesion->set_notification("ERROR", "El comprobante no existe o no tiene los permisos para poder realizar esta operación");
          }
        }else{
          write_log("ProcessSendCFDI | Construct() | Token NO válido");
          $sesion->set_notification("ERROR", "Ocurrió un error al validar el TOKEN para procesar su solicitud. Intentelo de nuevo.");
        }
      }else{
        write_log("ProcessSendCFDI | Construct() | NO se recibieron datos POST");
        $sesion->set_notification("ERROR", "Ocurrió un error al procesar la solicitud que desea realizar");
      }
    }
  }

  class ProcessCancelCFDI{
    function __construct($hostname='', $sitename='', $dataurl=''){
      // Verifica que se reciban datos por POST
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id_comprobante = $_POST['cfdi'];
          // Obtiene los datos de la sesión
          $data_session = $sesion->get_session();
          $emisor = $data_session['Emisor'];
          // Obtiene los datos del comprobante
          $comprobante_pdo = new ComprobantePDO();
          $data_comprobante = $comprobante_pdo->get_comprobante($id_comprobante, $emisor);

          if($data_comprobante != false){
            // Obtiene el Emisor para poder Obtener el PAC
            $emisor_pdo = new EmisorPDO();
            $datos_emisor = $emisor_pdo->get_emisor($emisor);
            $pac_id = $datos_emisor['PAC'];
            // Obtiene la información del PAC
            $pac_pdo = new PacPDO();
            $pac_info = $pac_pdo->get_pac($pac_id);

            if($pac_info != false){
              // Verifica si el comprobante ya fue timbrado o verificado
              $estatus_comprobante = intval($data_comprobante['EstatusCFDI']);
              if( $estatus_comprobante == 1 || $estatus_comprobante == 2 ){
                // Cancela el comprobante que ya fue Timbrado
                if( $comprobante_pdo->cancel_cfdi($data_comprobante, $pac_info, $datos_emisor['Testing']) ){
                  $sesion->set_notification("OK", "Su comprobante será cancelado. Su estatus será actualizado en el SAT ".
                  "en un tiempo no mayor a 72 horas.");
                }else{
                  $sesion->set_notification("ERROR", "Ocurrió un error al cancelar su comprobante.");
                }
              }elseif ( $estatus_comprobante == 0 ) {
                // Cancela el comprobante nuevo (SÓLO ACTUALIZA EL ESTATUS EN LA BD)
                if( $comprobante_pdo->update_to_cancel($data_comprobante['IdCFDI'], $data_comprobante['EstatusCFDI']) ){
                  $sesion->set_notification("OK", "Se canceló su comprobante de forma correcta.");
                }else{
                  $sesion->set_notification("ERROR", "Ocurrió un error al cancelar su comprobante. Inténtalo de nuevo.");
                }
              }else{
                $sesion->set_notification("ERROR", "No se puede cancelar el comprobante, se encuentra en un Estatus no permitido para cancelar.");
              }
            }else{
              $sesion->set_notification("ERROR", "Ocurrió un error al obtener la información del PAC.");
            }
          }else{
            write_log("ProcessCancelCFDI | Construct() | El comprobante no pertenece al usuario logueado o no existe.");
            $sesion->set_notification("ERROR", "El comprobante no existe o no tiene los permisos para poder realizar esta operación");
          }
        }else{
          write_log("ProcessCancelCFDI | Construct() | Token NO válido");
          $sesion->set_notification("ERROR", "Ocurrió un error al validar el TOKEN de su sesión para procesar su solicitud. Intentelo de nuevo.");
        }
      }else{
        write_log("ProcessCancelCFDI | Construct() | NO se recibieron datos POST");
        $sesion->set_notification("ERROR", "Ocurrió un error al procesar la solicitud que desea realizar.");
      }
      header("Location: " . $hostname . "/CFDIs/facturas/detalles/". $id_comprobante);
    }
  }

  class ViewReporteMensual{
    function __construct($hostname='', $sitename='', $dataurl=''){
      $data['title'] = "Facturación 3.3 | Reportes | Reporte Mensual";
      $data['host'] = $hostname;

      $sesion = new UserSession();
      $data_sesion = $sesion->get_session();
      $emisor = $data_sesion['Emisor'];

      $comprobante_pdo = new ComprobantePDO();
      $data['meses'] = $comprobante_pdo->get_meses_anios($emisor);

      if( $_POST ){
        $string_mes = $_POST['mes'];
        $data['mes'] = explode(" | ", $string_mes);
        $data['emisor'] = $emisor;
      }

      $this->view = new View();
      $this->view->render('views/modules/reportes/reporte_mensual.php', $data, true);
    }
  }

  class ViewReporteMensualGenerar{
    function __construct($hostname='', $sitename='', $dataurl=''){
      $data['title'] = "Facturación 3.3 | Reportes | Generar Reporte Mensual";
      $data['host'] = $hostname;

      if( $_GET ){
        $emisor_id = $_GET['emisor'];
        $mes_num = $_GET['mes'];
        $mes_nom = $_GET['mes_nom'];
        $anio = $_GET['anio'];
        // Obtiene los datos del emisor
        $emisor_pdo = new EmisorPDO();
        $data_emisor = $emisor_pdo->get_emisor($_GET['emisor']);
        // Obtiene los comprobantes y los totales
        $comprobante_pdo = new ComprobantePDO();
        $comprobantes = $comprobante_pdo->get_comprobantes_by_month($emisor_id, $mes_num, $anio);
        $totales = $comprobante_pdo->get_totales_by_month($emisor_id, $mes_num, $anio);
        // Obtiene la plantilla (HTML y CSS)
        $report = new RenderMPDF("ReporteMensual");
        $template = $report->render_template($data_emisor, $comprobantes, $mes_nom, $mes_num, $anio, $totales);

        require_once 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($template['css'],\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($template['html']);
        $mpdf->Output();
      }

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
