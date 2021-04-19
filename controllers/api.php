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

?>
