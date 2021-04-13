<?php
  require_once 'libs/conexion_db.php';

  Class Usuario extends Connection_PDO{
    private $id_usuario;
    private $user_name;

    function __construct() {
      parent::__construct();
    }

    public function get_userdata($username=''){
      if(empty($this->id_usuario)){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE User_name='$username'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconect();

        if(count($result) != 0){
          $this->id_usuario = $result[0]['Id'];
          $this->user_name = $result[0]['User_name'];
        }
      }
      return array("id"=>$this->id_usuario, "username"=>$this->user_name);
    }

    public function validate_user($username, $password){
      $this->connect();
      $stmt = $this->conn->prepare("SELECT Password FROM usuario WHERE User_name='$username'");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();

      if(count($result) != 0){
        $pass = $result[0]['Password'];
        if($pass == $password){
          return true;
        }else{
          return false;
        }
      }else{
        write_log("Usuario NO Existe");
        return false;
      }
    }
  }

?>
