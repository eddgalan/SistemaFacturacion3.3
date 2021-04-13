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

  class ClienteAPI extends API{
    public function get_clientes(){

      $cliente = new ClientePDO();
      $clientes = $cliente->get_clientes();
      $this -> return_data("Mostrando Clientes", 200, $clientes);

    }
  }

?>
