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
        if($this->userpass != ""){
          // Actualiza contraseña
          $sql = "UPDATE usuario SET Estatus='$this->activo',
          Username='$this->usrname',
          Email='$this->email',
          Password='$this->userpass'
          WHERE Id = $this->id";
          write_log("Actualiza contraseña");
        }else{
          // NO Actualiza contraseña
          $sql = "UPDATE usuario SET Estatus='$this->activo',
          Username='$this->usrname',
          Email='$this->email'
          WHERE Id = '$this->id'";
          write_log("NO Actualiza contraseña");
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
        $this->disconect();
        return true;
      }catch(PDOException $e) {
        write_log("Ocurrió un error al realizar el UPDATE del Usuario\nError: ". $e->getMessage());
        write_log("SQL: ". $sql);
        $this->disconect();
        return false;
      }
    }

    public function get_users($username=''){
      $this->connect();
      $stmt = $this->conn->prepare("SELECT * FROM usuario");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();

      if(count($result) != 0){
        return $result;
      }else{
        write_log("NO se han registrado Usuarios");
      }
    }

    public function cambiar_activo(){
      try{
        $this->connect();
        $sql = "UPDATE usuario SET Estatus='$this->activo'
        WHERE Id = $this->id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
        $this->disconect();
        return true;
      }catch(PDOException $e){
        write_log("Ocurrió un error al actualizar el campo Activo del Usuario\nError: ". $e->getMessage());
        write_log("SQL: ". $sql);
        $this->disconect();
      }
    }

    public function get_userdata_by_id($id=''){
      if(empty($this->id)){
        $this->connect();
        $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE Id='$id'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconect();

        if(count($result) != 0){
          return $result[0];
        }
      }
    }

    public function get_userdata($username=''){
      $this->connect();

      if(empty($this->id)){
        $sql = "SELECT * FROM usuario WHERE Username='$username'";
      }else{
        $sql = "SELECT * FROM usuario WHERE Id='$this->id'";
      }

      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();

      if(count($result) != 0){
        return $result[0];
      }
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

    public function user_in_group($id_grupo, $id_usuario){
      $this->connect();
      $sql = "SELECT * FROM grupos_usuario WHERE IdGrupo='$id_grupo' AND IdUsuario='$id_usuario'";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();
      if(count($result) > 0){
        return true;
      }else{
        return false;
      }
    }

    public function add_group($id_grupo, $id_usuario){
      $this->connect();
      try{
        $sql = "INSERT INTO grupos_usuario (IdGrupo, IdUsuario) VALUES ('$id_grupo', '$id_usuario')";
        $this->conn->exec($sql);
        write_log("UsuarioPDO | add_group() | Se realizó el INSERT del Usuario al Grupo con éxito");
        write_log("UsuarioPDO | add_group() | SQL: ". $sql);
        $this->disconect();
        return true;
      }catch(PDOException $e){
        write_log("UsuarioPDO | add_group() | Ocurrió un error al realizar el INSERT del Usuario al Grupo.\nError: ". $e->getMessage());
        write_log("UsuarioPDO | add_group() | SQL: ". $sql);
        $this->disconect();
        return false;
      }
    }

    public function remove_grupo($id){
      $this->connect();
      $sql = "DELETE FROM grupos_usuario WHERE Id=$id";
      write_log("UsuarioPDO | remove_grupo() | SQL: ". $sql);
      if ($this->conn->query($sql) === TRUE) {
        write_log("UsuarioPDO | remove_grupo() | Se eliminó el usuario del grupo");
        return true;
      } else {
        write_log("UsuarioPDO | remove_grupo() | Ocurrió un error al eliminar el usuario del grupo");
        return false;
      }
    }

    public function get_grupos_usuario($id_usuario){
      $this->connect();
      $sql = "SELECT grupos_usuario.Id, grupos_usuario.IdGrupo, grupos.Nombre, grupos_usuario.IdUsuario, usuario.Username
      FROM grupos_usuario
      INNER JOIN grupos ON grupos_usuario.IdGrupo = grupos.Id
      INNER JOIN usuario ON grupos_usuario.IdUsuario = usuario.Id
      WHERE IdUsuario='$id_usuario'";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();
      if(count($result) > 0){
        return $result;
      }else{
        return false;
      }
    }
  }

?>
