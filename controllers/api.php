<?php

  class API{
    private $datos;
    private $response;

    public function return_data($msg, $code, $data=null){
      $this->response['code'] = $code;
      $this->response['msg'] = $msg;
      $this->response['data'] = $data;
      print_r(json_encode($this->response));
    }
  }

  class UsuarioAPI extends API{
    public function get_usuario($datos){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id = $datos[1];
          $usuario = new UsuarioPDO();
          $data_usuario = $usuario->get_userdata($id);
          $this -> return_data("Mostrando Usuarios API", 200, $data_usuario);
        }else{
          write_log("Token NO válido | UsuarioAPI");
          $this->return_data("Ocurrió un error... No es posible procesar su solicitud", 400);
        }
      }else{
        write_log("NO se recibieron datos POST");
        $this->return_data("No es posible procesar su solicitud", 400);
      }
    }
  }

  class PACAPI extends API{
    public function get_pac($data_url){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id = $data_url[1];
          $pac_pdo = new PacPDO();
          $data_pac = $pac_pdo->get_pac($id);
          $this -> return_data("Mostrando Datos PAC | API", 200, $data_pac);
        }else{
          write_log("PACAPI | get_pac | Token NO válido");
          $this->return_data("Ocurrió un error... No es posible procesar su solicitud", 400);
        }
      }else{
        write_log("PACAPI | get_pac | NO se recibieron datos POST");
        $this->return_data("No es posible procesar su solicitud", 400);
      }
    }
  }

  class GrupoAPI extends API{
    public function get_grupo(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id_grupo = $_POST['id_grupo'];
          $grupo_pdo = new GrupoPDO();
          $data_grupo = $grupo_pdo->get_grupo($id_grupo);
          if( $data_grupo != false ){
            $this-> return_data("GrupoAPI | get_grupo() | Información del grupo", 200, $data_grupo);
          }else{
            $this-> return_data("GrupoAPI | get_grupo() | NO fue posible obtener la información solicitada", 400);
          }
        }else{
          write_log("GrupoAPI | get_grupo() | Token no válido");
          $this->return_data("No fue posible procesar su solicitud", 400);
        }
      }else{
        write_log("GrupoAPI | get_grupo() | NO se recibieron datos POST");
        $this->return_data("No fue posible procesar su solicitud", 400);
      }
    }

    public function add_grupo(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id_grupo = $_POST['id_grupo'];
          $id_usuario = $_POST['id_usuario'];

          $usuario_pdo = new UsuarioPDO();
          if( $usuario_pdo->user_in_group($id_grupo, $id_usuario) ){
            $this->return_data("GrupoAPI | add_grupo() | El usuario ya se encuentra en el grupo", 200);
          }else{
            if( $usuario_pdo->add_group($id_grupo, $id_usuario) ){
              $this->return_data("GrupoAPI | add_grupo() | Se agreó el usuario al grupo indicado", 201);
            }else{
              $this->return_data("GrupoAPI | add_grupo() | Ocurrió un error al agregar el usuario", 500);
            }
          }
        }else{
          write_log("GrupoAPI | get_grupo() | Token no válido");
          $this->return_data("No fue posible procesar su solicitud", 400);
        }
      }else{
        write_log("GrupoAPI | get_grupo() | NO se recibieron datos POST");
        $this->return_data("No fue posible procesar su solicitud", 400);
      }
    }

    public function remove_grupo(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id = $_POST['id'];

          $usuario_pdo = new UsuarioPDO();
          if( $usuario_pdo->remove_grupo($id) ){
            $this->return_data("GrupoAPI | remove_grupo() | OK", 200);
          }else{
            $this->return_data("GrupoAPI | remove_grupo() | Error", 500);
          }
        }else{
          write_log("GrupoAPI | remove_grupo() | Token no válido");
          $this->return_data("No fue posible procesar su solicitud", 400);
        }
      }else{
        write_log("GrupoAPI | remove_grupo() | NO se recibieron datos POST");
        $this->return_data("No fue posible procesar su solicitud", 400);
      }
    }

    public function get_grupos_usuario(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id_usuario = $_POST['id_usuario'];

          $usuario_pdo = new UsuarioPDO();
          $grupos_usuario = $usuario_pdo->get_grupos_usuario($id_usuario);
          $this->return_data("GrupoAPI | get_grupos_usuario() | Grupos del usuario", 200, $grupos_usuario);
        }else{
          write_log("GrupoAPI | get_grupos_usuario() | Token no válido");
          $this->return_data("No fue posible procesar su solicitud", 400);
        }
      }else{
        write_log("GrupoAPI | get_grupos_usuario() | NO se recibieron datos POST");
        $this->return_data("No fue posible procesar su solicitud", 400);
      }
    }

    public function get_permisos(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if( $sesion->validate_token($token) ){
          $id_grupo = $_POST['id_grupo'];

          $grupo_pdo = new GrupoPDO();
          $permisos = $grupo_pdo->get_permisos($id_grupo);
          if( $permisos ){
            $this->return_data("GrupoAPI | get_permisos() | Permisos del Grupo", 200, $permisos);
          }else{
            $this->return_data("GrupoAPI | get_permisos() | NO fue posible obtener los permisos del grupo con Id: ". $id_grupo, 400);
          }
        }else{
          write_log("GrupoAPI | get_permisos() | Token NO valido");
          $this->return_data("No fue posible procesar su solicitud", 400);
        }

      }else{
        write_log("GrupoAPI | get_permisos() | NO se recibieron datos POST");
        $this->return_data("No fue posible procesar su solicitud", 400);
      }
    }
  }

  class PerfilAPI extends API{
    public function get_perfil(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if( $sesion->validate_token($token) ){
          $id_perfil = $_POST['id_perfil'];
          $perfil_pdo = new PerfilPDO();
          $data_perfil = $perfil_pdo->get_perfil($id_perfil);
          if( $data_perfil != false ){
            $this-> return_data("PerfilAPI | get_perfil() | Información del Perfil", 200, $data_perfil);
          }else{
            $this-> return_data("PerfilAPI | get_perfil() | NO fue posible obtener la información solicitada", 400);
          }
        }else{
          write_log("PerfilAPI | get_perfil() | Token no válido");
          $this->return_data("No fue posible procesar su solicitud", 400);
        }
      }else{
        write_log("PerfilAPI | get_perfil() | NO se recibieron datos POST");
        $this->return_data("No fue posible procesar su solicitud", 400);
      }
    }
  }

  class EmisorAPI extends API{
    public function get_emisor(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if( $sesion->validate_token($token) ){
          $id_emisor = $_POST['id_emisor'];
          $emisor_pdo = new EmisorPDO();
          $data_emisor = $emisor_pdo->get_emisor($id_emisor);
          if( $data_emisor != false ){
            $this-> return_data("EmisorAPI | get_emisor() | Información del grupo", 200, $data_emisor);
          }else{
            $this-> return_data("EmisorAPI | get_emisor() | NO fue posible obtener la información solicitada", 400);
          }
        }else{
          write_log("EmisorAPI | get_emisor() | Token no válido");
          $this->return_data("No fue posible procesar su solicitud", 400);
        }
      }else{
        write_log("EmisorAPI | get_emisor() | NO se recibieron datos POST");
        $this->return_data("No fue posible procesar su solicitud", 400);
      }
    }
  }

  class CatSATAPI extends API{
    public function get_usos_cfdi(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $sesion = new UserSession();
          // Obtiene el Emisor para obtener toda su configuración de los catálogos del SAT
          $data_session = $sesion->get_session();
          $emisor = $data_session['Emisor'];
          // Obtiene la información del cliente para saber si es Persona Moral o Física
          $id_cliente = $_POST['id_cliente'];
          $cliente_pdo = new ClientePDO();
          $data_cliente = $cliente_pdo->get_cliente($id_cliente, $emisor);
          $tipo_persona = $data_cliente['TipoPersona'];
          // Obtiene todos los usos CFDI del Catálogo del SAT
          $usos_cfdi_pdo = new CatSATUsosCFDI();
          $array_usos = $usos_cfdi_pdo->get_all_catsat();
          $usos = array();

          if($tipo_persona == 'F'){
            foreach($array_usos as $uso_cfdi){
              if($uso_cfdi['uso_fisica']=='Sí'){
                array_push($usos, array(
                  'uso_clave'=>$uso_cfdi['uso_clave'],
                  'uso_concepto'=>$uso_cfdi['uso_concepto'],
                  'uso_fisica'=>$uso_cfdi['uso_fisica']
                ));
              }
            }
          }elseif($tipo_persona == 'M'){
            foreach($array_usos as $uso_cfdi){
              if($uso_cfdi['uso_moral']=='Sí'){
                array_push($usos, array(
                  'uso_clave'=>$uso_cfdi['uso_clave'],
                  'uso_concepto'=>$uso_cfdi['uso_concepto'],
                  'uso_moral'=>$uso_cfdi['uso_moral']
                ));
              }
            }
          }
          $this -> return_data("CatSATAPI | get_usos_cfdi() | Mostrando Usos CFDI API", 200, $usos);
        }else{
          write_log("Token NO válido | CatSATAPI");
          $this->return_data("Ocurrió un error... No es posible procesar su solicitud", 400);
        }
      }else{
        write_log("NO se recibieron datos POST");
        $this->return_data("No es posible procesar su solicitud", 400);
      }
    }

    public function get_impuesto(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id_impuesto = $_POST['id_impuesto'];
          $impuesto_pdo = new CatSATImpuestos();

          $data_session = $sesion->get_session();
          $emisor = $data_session['Emisor'];

          $data_impuesto = $impuesto_pdo->get_impuesto($id_impuesto, $emisor);
          $this -> return_data("CatSATAPI | get_impuestos() | Mostrando Impuestos API", 200, $data_impuesto);
        }else{
          write_log("CatSATAPI | get_impuesto() | Token NO válido");
          $this->return_data("Ocurrió un error... No es posible procesar su solicitud", 400);
        }
      }else{
        write_log("NO se recibieron datos POST");
        $this->return_data("No es posible procesar su solicitud", 400);
      }
    }

    public function get_regimenes(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $tpo_persona = $_POST['tpo_persona'];
          $regimen_pdo = new CatSATRegimenesPDO();

          $data_regimen = $regimen_pdo->get_regimenes_persona($tpo_persona);
          $this -> return_data("CatSATAPI | get_regimenes() | Mostrando Regimenes API", 200, $data_regimen);
        }else{
          write_log("CatSATAPI | get_regimenes() | Token NO válido");
          $this->return_data("Ocurrió un error... No es posible procesar su solicitud", 400);
        }
      }else{
        write_log("NO se recibieron datos POST");
        $this->return_data("No es posible procesar su solicitud", 400);
      }
    }
  }

  class ProdServAPI extends API{
    public function get_producto(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();
        $data_sesion = $sesion->get_session();
        $emisor = $data_sesion['Emisor'];

        if($sesion->validate_token($token)){
          $id = $_POST['id_producto'];
          $prodserv_pdo = new ProdServPDO();
          $data_producto = $prodserv_pdo->get_prodserv($emisor, $id);
          if($data_producto){
            $this->return_data("Mostrando Productos API", 200, $data_producto);
          }else{
            $this->return_data("Ocurrió un error.", 500);
          }
        }else{
          write_log("Token NO válido | ProductoAPI");
          $this->return_data("Ocurrió un error... No es posible procesar su solicitud", 400);
        }
      }else{
        write_log("NO se recibieron datos POST | ProductoAPI");
        $this->return_data("No es posible procesar su solicitud", 400);
      }
    }
  }

  class SerieAPI extends API{
    public function get_serie(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();
        // Obtiene el emisor
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        if($sesion->validate_token($token)){
          $serie_id = $_POST['serie_id'];
          $serie_pdo = new SeriePDO();
          $data_serie = $serie_pdo->get_serie($serie_id, $emisor);
          if($data_serie){
            $this->return_data("SerieAPI | get_serie() | Mostrando datos de la Serie", 200, $data_serie);
          }else{
            $this->return_data("SerieAPI | get_serie() | Ocurrió un error.", 500);
          }
        }else{
          write_log("SerieAPI | get_serie() | Token NO válido");
          $this->return_data("Ocurrió un error... No es posible procesar su solicitud", 400);
        }
      }else{
        write_log("NO se recibieron datos POST | SerieAPI");
        $this->return_data("No es posible procesar su solicitud", 400);
      }
    }

    public function get_serie_by_nom_serie(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();
        // Obtiene el emisor
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        if($sesion->validate_token($token)){
          $serie = $_POST['nom_serie'];
          $serie_pdo = new SeriePDO();
          $data_serie = $serie_pdo->get_serie_by_serie_emisor($emisor, $serie);
          if($data_serie){
            $this->return_data("Mostrando Productos API", 200, $data_serie);
          }else{
            $this->return_data("Ocurrió un error.", 500);
          }
        }else{
          write_log("Token NO válido | SerieAPI");
          $this->return_data("Ocurrió un error... No es posible procesar su solicitud", 400);
        }
      }else{
        write_log("NO se recibieron datos POST | SerieAPI");
        $this->return_data("No es posible procesar su solicitud", 400);
      }
    }

  }

  class ComprobanteAPI extends API{
    public function insert_cfdi(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          // Obtiene el emisor
          $data_session = $sesion->get_session();
          $emisor = $data_session['Emisor'];
          // Obtiene el NoCertificado
          $csd_pdo = new CSD_PDO();
          $datos_csd = $csd_pdo->get_csd($emisor);
          $nocertificado = $datos_csd['NoCertificado'];
          if($nocertificado != false){
            // Obtiene los datos POST
            $cliente_id = $_POST['data']['cliente_id'];
            $serie = $_POST['data']['serie'];
            $fecha = $_POST['data']['fecha'];
            $hora = $_POST['data']['hora'];
            $moneda = $_POST['data']['moneda'];
            $tipo_cambio = $_POST['data']['tipo_cambio'];
            $tipo_comprobante = $_POST['data']['tipo_comprobante'];
            $condiciones_pago = $_POST['data']['condiciones_pago'];
            $metodo_pago = $_POST['data']['metodo_pago'];
            $forma_pago = $_POST['data']['forma_pago'];
            $array_uso_cfdi = explode(" | ", $_POST['data']['uso_cfdi']);
            $uso_cfdi = $array_uso_cfdi[0];
            $desc_uso_cfdi = $array_uso_cfdi[1];
            $subtotal = $_POST['data']['subtotal'];
            $iva = $_POST['data']['iva'];
            $ieps = $_POST['data']['ieps'];
            $descuento = $_POST['data']['descuento'];
            $total = $_POST['data']['total'];
            $productos_servicios = $_POST['data']['prodservs'];
            $observaciones = $_POST['data']['observaciones'];
            // Obtiene el consecutivo de la serie
            $serie_pdo = new SeriePDO();
            $data_serie = $serie_pdo->get_serie_by_serie_emisor($emisor, $serie);
            if($data_serie != false){
              $consecutivo = intval($data_serie['Consecutivo']);
              $folio = $consecutivo + 1;
              // Obtiene el lugar de expedición de la información del Emisor
              $emisor_pdo = new EmisorPDO();
              $data_emisor = $emisor_pdo->get_emisor($emisor);
              if($data_emisor != false){
                $lugar_exp = $data_emisor['CP'];
                $regimen = $data_emisor['Regimen'];
                // Crea la instancia ComprobantePDO
                $comprobante = new ComprobantePDO($emisor, $cliente_id, $serie, $folio, $fecha, $hora, $moneda, $tipo_cambio, $tipo_comprobante,
                $condiciones_pago, $nocertificado, $metodo_pago, $forma_pago, $uso_cfdi, $desc_uso_cfdi, $lugar_exp, $regimen, $subtotal, $iva, $ieps,
                $descuento, $total, $productos_servicios, $observaciones);

                if($comprobante->insert_comprobante($productos_servicios)){
                  // Actualiza el consecutivo de la serie
                  if($serie_pdo->update_consecutivo($data_serie['Id'], $folio)){
                    $sesion->set_notification("OK", "Se creó un nuevo comprobante (CFDI)");
                    $this->return_data("Se creó el nuevo comprobante con éxito!", 201);
                  }else{
                    $sesion->set_notification("WARNING", "Se creó el nuevo comprobante pero ocurrió un error al actualizar el consecutivo de la serie.");
                    $this->return_data("Se creó el comprobante pero no se actualizó la serie", 200);
                  }
                }else{
                  $sesion->set_notification("ERROR", "Ocurrió un error al crear el comprobante (CFDI). Verifique los datos e intente de nuevo");
                  $this->return_data("Ocurrió un error al crear el comprobante", 500);
                }
              }else{
                $sesion->set_notification("ERROR", "Ocurrió un error al crear su comprobante. No se encontró información del emisor");
                $this->return_data("No fue posible crear el comprobante. No hay datos Emisor", 400);
              }
            }else{
              $sesion->set_notification("ERROR", "No fue posible obtener la serie. Verifique que tenga una serie configurada y reintente.");
              $this->return_data("Ocurrió un error al crear su comprobante. No se obtuvo la serie", 400);
            }
          }else{
            write_log("ComprobanteAPI | insert_cfdi() | NO se logró obtener el NoCertificado.");
            $sesion->set_notification("ERROR", "No fue posible obtener el NoCertificado.");
            $this->return_data("Ocurrió un error al crear su comprobante. No fue posible obtener el NoCertificado", 400);
          }
        }else{
            write_log("Token NO válido | ComprobanteAPI");
            $this->return_data("Ocurrió un error... No es posible procesar su solicitud", 400);
        }
      }else{
        write_log("NO se recibieron datos POST | ComprobanteAPI");
        $this->return_data("No es posible procesar su solicitud", 400);
      }
    }
  }

  class ChartJSAPI extends API{
    public function get_comp_by_month(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();
        if($sesion->validate_token($token)){
          $comprobante_pdo = new ComprobantePDO();
          $data = array(
            "CFDIsMeses" => $comprobante_pdo->get_num_comprobantes_by_month($_SESSION['Emisor'])
          );
          $this -> return_data("ChartJSAPI | get_dashboard_data() | Operación exitosa", 200, $data);
        }else{
          write_log("ChartJS | get_dashboard_data | Token no válido");
          $this->return_data("ChartJSAPI | get_dashboard_data() | No fue posible procesar su solicitud", 400);
        }
      }else{
        write_log("ChartJS | get_dashboard_data | No se recibieron datos POST");
        $this->return_data("ChartJS | get_dashboard_data | No es posible procesar su solicitud", 400);
      }
    }

    public function get_top_comp_by_client(){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();
        if($sesion->validate_token($token)){
          $comprobante_pdo = new ComprobantePDO();
          $data = array(
            "CFDIsClientes" => $comprobante_pdo->get_top_5_comprobantes_by_cliente($_SESSION['Emisor'])
          );
          $this -> return_data("ChartJSAPI | get_top_comp_by_client() | Operación exitosa", 200, $data);
        }else{
          write_log("ChartJS | get_top_comp_by_client | Token no válido");
          $this->return_data("ChartJSAPI | get_top_comp_by_client() | No fue posible procesar su solicitud", 400);
        }
      }else{
        write_log("ChartJS | get_top_comp_by_client | No se recibieron datos POST");
        $this->return_data("ChartJS | get_top_comp_by_client | No es posible procesar su solicitud", 400);
      }
    }
  }

?>
