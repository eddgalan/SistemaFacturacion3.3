<?php
  require_once 'libs/conexion_db.php';

  Class PerfilPDO extends Connection_PDO{
    function __construct() {
      parent::__construct();
    }

    public function get_count(){
      $this->connect();
      $sql = "SELECT COUNT(Id) AS NoPerfiles FROM perfiles";
      $stmt = $this->conn->prepare($sql);
      write_log("PerfilPDO | get_count() | SQL: ". $sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();
      write_log("PerfilPDO | get_count() | Result: ". serialize($result));
      if(count($result) != 0){
        return $result[0]['NoPerfiles'];
      }else{
        write_log("NO se han registrado Usuarios");
      }
    }

    public function get_all(){
      $this->connect();
      $sql = "SELECT perfiles.Id, perfiles.UsuarioId, usuario.Username as Username, perfiles.Nombre, perfiles.ApellidoPaterno, perfiles.ApellidoMaterno,
      CONCAT(perfiles.Nombre, ' ', perfiles.ApellidoPaterno, ' ', perfiles.ApellidoMaterno) AS FullName,
      perfiles.Emisor AS IdEmisor, emisores.Nombre as NombreEmisor, emisores.RFC as RFCEmisor, perfiles.Puesto,
      usuario.Email as Email
      FROM perfiles
      INNER JOIN usuario ON perfiles.UsuarioId = usuario.Id
      INNER JOIN emisores ON perfiles.Emisor = emisores.Id
      ";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();
      write_log("PerfilPDO | get_all() | SQL: ". $sql);
      write_log("PerfilPDO | get_all() | Result: ". serialize($result));
      return $result;
    }

    public function insert_perfil($usuario, $nombre, $apellido_pat, $apellido_mat, $emisor, $puesto){
      $this->connect();
      try{
        $sql = "INSERT INTO perfiles (UsuarioId, Nombre, ApellidoPaterno, ApellidoMaterno, Emisor, Puesto)
        VALUES ('$usuario', '$nombre', '$apellido_pat', '$apellido_mat', '$emisor', '$puesto')";
        $this->conn->exec($sql);
        write_log("PerfilPDO | insert_perfil() | Se realizó el INSERT con Éxito.");
        $this->disconect();
        return true;
      }catch(PDOException $e) {
        write_log("PerfilPDO | insert_perfil() | Ocurrió un error al realizar el INSERT del Grupo\nError: ". $e->getMessage());
        $this->disconect();
        return false;
      }
    }

    public function get_perfil($id){
      $this->connect();
      try{
        $sql = "SELECT * FROM perfiles
        WHERE  Id='$id'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("PerfilPDO | get_perfil() | SQL: " . $sql);
        write_log("PerfilPDO | get_perfil() | Result: " . serialize($result));
        $this->disconect();
        if( count($result) > 0 ){
          return $result[0];
        }else{
          return false;
        }
      }catch(PDOException $e) {
        write_log("PerfilPDO | get_perfil() | Error al ejecutar la consulta. ERROR: " . $e->getMessage());
        write_log("SQL: " . $sql);
        return false;
      }
    }

    public function get_perfil_by_user($id_usuario){
      $this->connect();
      try{
        $sql = "SELECT * FROM perfiles
        WHERE  UsuarioId = '$id_usuario'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("PerfilPDO | get_perfil_by_user() | SQL: " . $sql);
        write_log("PerfilPDO | get_perfil_by_user() | Result: " . serialize($result));
        $this->disconect();
        if( count($result) > 0 ){
          return $result[0];
        }else{
          return false;
        }
      }catch(PDOException $e) {
        write_log("PerfilPDO | get_perfil() | Error al ejecutar la consulta. ERROR: " . $e->getMessage());
        write_log("SQL: " . $sql);
        return false;
      }
    }

    public function update_perfil($id_perfil, $usuario, $nombre, $apellido_pat, $apellido_mat, $emisor, $puesto){
      $this->connect();
      try{
        $sql = "UPDATE perfiles SET UsuarioId='$usuario', Nombre='$nombre', ApellidoPaterno='$apellido_pat',
        ApellidoMaterno='$apellido_mat', Emisor='$emisor', Puesto='$puesto'
        WHERE Id = '$id_perfil'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        write_log("PerfilPDO | update_perfil() | SQL: " . $sql);
        write_log("PerfilPDO | update_perfil() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
        $this->disconect();
        return true;
      }catch(PDOException $e) {
        write_log("PerfilPDO | update_perfil() | Ocurrió un error al realizar el UPDATE del Perfil\nError: ". $e->getMessage());
        write_log("SQL: ". $sql);
        $this->disconect();
        return false;
      }
    }
  }

?>
