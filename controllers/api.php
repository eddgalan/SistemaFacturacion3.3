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
          $usuario = new UsuarioPDO($id);
          $data_usuario = $usuario->get_userdata();
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

  class ProductoAPI extends API{
    public function get_producto($datos){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();

        if($sesion->validate_token($token)){
          $id = $datos[1];
          $producto = new ProductoPDO($id);
          $data_producto = $producto->get_producto();
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
    public function get_serie($datos){
      if($_POST){
        $token = $_POST['token'];
        $sesion = new UserSession();
        // Obtiene el emisor
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        if($sesion->validate_token($token)){
          $serie = $datos[1];
          $serie_pdo = new SeriePDO("", "", $emisor, $serie);
          $data_serie = $serie_pdo->get_serie();
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
          $uso_cfdi = $_POST['data']['uso_cfdi'];
          $subtotal = $_POST['data']['subtotal'];
          $iva = $_POST['data']['iva'];
          $ieps = $_POST['data']['ieps'];
          $descuento = $_POST['data']['descuento'];
          $total = $_POST['data']['total'];
          $productos_servicios = $_POST['data']['prodservs'];
          $observaciones = $_POST['data']['observaciones'];
          // Obtiene el consecutivo de la serie
          $serie_pdo = new SeriePDO("", "", $emisor, $serie);
          $data_serie = $serie_pdo->get_serie();
          $consecutivo = intval($data_serie['Consecutivo']);
          $folio = $consecutivo + 1;
          // Obtiene el lugar de expedición de la información del Emisor
          $emisor_pdo = new EmisorPDO($emisor);
          $data_emisor = $emisor_pdo->get_emisor();
          $lugar_exp = $data_emisor['CP'];
          $regimen = $data_emisor['Regimen'];
          // Crea la instancia ComprobantePDO
          $comprobante = new ComprobantePDO($emisor, $cliente_id, $serie, $folio, $fecha, $hora, $moneda, $tipo_cambio, $tipo_comprobante,
          $condiciones_pago, $metodo_pago, $forma_pago, $uso_cfdi, $lugar_exp, $regimen, $subtotal, $iva, $ieps,
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
            write_log("Token NO válido | ComprobanteAPI");
            $this->return_data("Ocurrió un error... No es posible procesar su solicitud", 400);
        }
      }else{
        write_log("NO se recibieron datos POST | ComprobanteAPI");
        $this->return_data("No es posible procesar su solicitud", 400);
      }
    }
  }

?>
