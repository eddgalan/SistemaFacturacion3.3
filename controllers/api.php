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

        if($sesion->validate_token($token)){
          $serie = $datos[1];
          $serie_pdo = new SeriePDO("", "", "", $serie);
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

?>
