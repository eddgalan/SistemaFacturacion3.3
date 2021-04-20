<?php

  Class UserSession{
      private $id_user;
      private $user;
      private $user_name;
      private $user_lastname;
      private $groups;
      private $status;
      private $token;

      public function __construct(){
        // Inicia la sesión si no está iniciada
        if(session_status() == 1){
          session_start();
        }
      }

      public function validate_session(){
        if(isset($_SESSION['Id'])){
          write_log("validate_session");
          return true;
        }else{
          return false;
        }
      }

      public function set_session($datos_usuario){
        write_log(serialize($datos_usuario));
        // $_SESSION['id_user'] = $token;
        $_SESSION['Id'] = $datos_usuario['Id'];
        $_SESSION['Estatus'] = $datos_usuario['Estatus'];
        $_SESSION['Username'] = $datos_usuario['Username'];
        $_SESSION['Email'] = $datos_usuario['Email'];
        $_SESSION['Created'] = $datos_usuario['Created'];
        $_SESSION['ChangePass'] = $datos_usuario['ChangePass'];
        $_SESSION['LastSession'] = $datos_usuario['LastSession'];
        $_SESSION['Emisor'] = 1;
        write_log("Sesión Colocada");
      }

      public function get_session(){
        if(isset($_SESSION['Username'])){
          return array("Id"=>$_SESSION['Id'],
          "Username"=>$_SESSION['Username'],
          "Email"=>$_SESSION['Email'],
          "Created"=>$_SESSION['Created'],
          "LastSession"=>$_SESSION['LastSession'],
          "Emisor"=>$_SESSION['Emisor']
          );
        }else{
          return false;
        }
      }

      public function set_token(){
        $token = bin2hex(random_bytes(8));
        $this->token = $token;
        $_SESSION['token'] = $token;
        return $this->token;
      }

      public function get_token(){
        if(isset($_SESSION['token'])){
          return $_SESSION['token'];
        }else{
          write_log("ERROR | El token no existe");
        }
      }

      public function validate_token($token_form){
        if(isset($_SESSION['token'])){
          $token = $_SESSION['token'];
          if ($token == $token_form){
            return true;
          }else{
            return false;
          }
        }else{
          write_log("ERROR | Token does not exist");
          return false;
        }
      }

      public function set_notification($status, $msg){
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
      }

      public function get_notification(){
        if(isset($_SESSION['status']) && isset($_SESSION['msg'])){
          $data = array('status'=>$_SESSION['status'], 'msg'=>$_SESSION['msg']);
          unset($_SESSION['status']);
          unset($_SESSION['msg']);
          return $data;
        }else{
          return false;
        }
      }

      public function close_sesion(){
        session_unset();  // Limpia
        session_destroy();  // Elimina
      }
  }
?>
