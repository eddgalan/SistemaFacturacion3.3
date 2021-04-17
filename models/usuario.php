<?php
  require_once 'libs/conexion_db.php';

  Class UsuarioPDO extends Connection_PDO{
    private $id;
    private $activo;
    private $usrname;
    private $userpass;
    private $email;
    private $created;
    private $changepass;
    private $lastsession;

    function __construct($id="", $activo="", $usrname="", $pass="", $email="", $created="", $changepass="", $lastsession="") {
      parent::__construct();
      $this->id=$id;
      $this->activo= $activo;
      $this->usrname= $usrname;
      $this->userpass= $pass;
      $this->email= $email;
      $this->created= $created;
      $this->changepass= $changepass;
      $this->lastsession= $lastsession;
    }

    public function insert_usuario(){
      $this->connect();       // Conecta a la base de datos
      try{
        $sql = "INSERT INTO usuario (Username, Password, Email)
        VALUES ('$this->usrname', '$this->userpass', '$this->email')";
        $this->conn->exec($sql);
        write_log("Se realizó el INSERT del Usuario con Éxito");
        $this->disconect();   // Cierra la conexión a la BD
        return true;
      }catch(PDOException $e) {
        write_log("Ocurrió un error al realizar el INSERT del Usuario\nError: ". $e->getMessage());
        $this->disconect();   // Cierra la conexión a la BD
        return false;
      }
    }

    public function actualizar_usuario(){
      $this->connect();       // Conecta a la base de datos
      try{
        if($this->user_pass != ""){
          // Actualiza contraseña
          $sql = "UPDATE usuario SET Activo='$this->activo',
          Nombre='$this->nombre',
          Apellidos='$this->apellidos',
          User_name='$this->user_name',
          Password='$this->user_pass'
          WHERE Id_usuario = $this->id_usuario";
          write_log("Actualiza contraseña");
        }else{
          // NO Actualiza contraseña
          $sql = "UPDATE usuario SET Activo='$this->activo',
          Nombre='$this->nombre',
          Apellidos='$this->apellidos',
          User_name='$this->user_name'
          WHERE Id_usuario = $this->id_usuario";
          write_log("NO Actualiza contraseña");
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
        $this->disconect();
        return true;
      }catch(PDOException $e) {
        write_log("Ocurrió un error al realizar el INSERT del Usuario\nError: ". $e->getMessage());
        write_log("SQL: ". $sql);
        $this->disconect();
        return false;
      }
    }

    public function get_userdata($username=''){
      if(empty($this->id_usuario)){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE Username='$username'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconect();

        if(count($result) != 0){
          return $result[0];
          // $this->id_usuario = $result[0]['Id'];
          // $this->user_name = $result[0]['User_name'];
        }
      }
      // return array("id"=>$this->id_usuario, "username"=>$this->user_name);
    }

    public function validate_user($username, $password){
      $this->connect();
      $stmt = $this->conn->prepare("SELECT Password FROM usuario WHERE Username='$username'");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();

      if(count($result) != 0){
        $pass = $result[0]['Password'];
        if(password_verify($password, $pass)){
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
