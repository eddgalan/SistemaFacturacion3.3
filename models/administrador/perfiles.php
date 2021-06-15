<?php
  require_once 'libs/conexion_db.php';

  Class PerfilPDO extends Connection_PDO{
    function __construct() {
      parent::__construct();
    }

    public function get_all(){
      $this->connect();
      $sql = "SELECT perfiles.Id, perfiles.UsuarioId, usuario.Username as Username, perfiles.Nombre, perfiles.ApellidoPaterno, perfiles.ApellidoMaterno,
      CONCAT(perfiles.Nombre, ' ', perfiles.ApellidoPaterno, ' ', perfiles.ApellidoMaterno) AS FullName,
      perfiles.Emisor AS IdEmisor, emisores.Nombre as NombreEmisor, emisores.RFC as RFCEmisor, perfiles.Puesto
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

    public function insert_perfil($nom_grupo, $desc_grupo){
      $this->connect();
      try{
        $sql = "INSERT INTO grupos (Nombre, Descripcion)
        VALUES ('$nom_grupo', '$desc_grupo')";
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

    public function get_perfil($grupo_id){
      $this->connect();
      try{
        $sql = "SELECT * FROM grupos
        WHERE  Id='$grupo_id'";
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

    public function update_perfil($id_grupo, $grupo, $descripcion){
      $this->connect();
      try{
        $sql = "UPDATE grupos SET Nombre='$grupo', Descripcion='$descripcion' WHERE Id = '$id_grupo'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        write_log("GrupoPDO | update_grupo() | SQL: " . $sql);
        write_log("GrupoPDO | update_grupo() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
        $this->disconect();
        return true;
      }catch(PDOException $e) {
        write_log("GrupoPDO | update_grupo() | Ocurrió un error al realizar el UPDATE del Usuario\nError: ". $e->getMessage());
        write_log("SQL: ". $sql);
        $this->disconect();
        return false;
      }
    }
  }

?>
