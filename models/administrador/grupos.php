<?php
  require_once 'libs/conexion_db.php';

  Class GrupoPDO extends Connection_PDO{
    private $id;
    private $nombre;
    private $descripcion;

    function __construct() {
      parent::__construct();
    }

    public function get_count(){
      $this->connect();
      $sql = "SELECT COUNT(Id) AS NoGrupos FROM grupos";
      $stmt = $this->conn->prepare($sql);
      write_log("GrupoPDO | get_count() | SQL: ". $sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();
      write_log("GrupoPDO | get_count() | Result". serialize($result));
      if(count($result) != 0){
        return $result[0]['NoGrupos'];
      }else{
        write_log("GrupoPDO | get_count() | NO se han registrado Usuarios");
      }
    }

    public function get_all(){
      $this->connect();
      $sql = "SELECT * FROM grupos";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();
      write_log("GrupoPDO | get_all() | SQL: ". $sql);
      write_log("GrupoPDO | get_all() | Result: ". serialize($result));
      return $result;
    }

    public function insert_grupo($nom_grupo, $desc_grupo){
      $this->connect();
      try{
        $sql = "INSERT INTO grupos (Nombre, Descripcion)
        VALUES ('$nom_grupo', '$desc_grupo')";
        $this->conn->exec($sql);
        write_log("GrupoPDO | insert_grupo() | Se realizó el INSERT con Éxito.");
        $this->disconect();
        return true;
      }catch(PDOException $e) {
        write_log("GrupoPDO | insert_grupo() | Ocurrió un error al realizar el INSERT del Grupo\nError: ". $e->getMessage());
        $this->disconect();
        return false;
      }
    }

    public function get_grupo($grupo_id){
      $this->connect();
      try{
        $sql = "SELECT * FROM grupos
        WHERE  Id='$grupo_id'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("GrupoPDO | get_grupo() | SQL: " . $sql);
        write_log("GrupoPDO | get_grupo() | Result: " . serialize($result));
        $this->disconect();
        if( count($result) > 0 ){
          return $result[0];
        }else{
          return false;
        }
      }catch(PDOException $e) {
        write_log("GrupoPDO | get_grupo() | Error al ejecutar la consulta. ERROR: " . $e->getMessage());
        write_log("SQL: " . $sql);
        return false;
      }
    }

    public function update_grupo($id_grupo, $grupo, $descripcion){
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

    public function get_permisos($id_grupo){
      $this->connect();
      try{
        $sql = "SELECT permisos.Id, permisos.GrupoId, grupos.Nombre, permisos.Admin_usuario, permisos.Admin_grupos,
        permisos.Admin_perfiles, permisos.Admin_emisores, permisos.Admin_clientes, permisos.Admin_prodserv,
        permisos.Admin_series,
        permisos.Comprobantes_facturas, permisos.Reportes_reportemensual, permisos.CatSAT_claves_prodserv,
        permisos.CatSAT_unidades, permisos.CatSAT_formaspago, permisos.CatSAT_monedas, permisos.CatSAT_impuestos
        FROM permisos
        INNER JOIN grupos ON permisos.GrupoId = grupos.Id
        WHERE  permisos.GrupoId='$id_grupo'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("GrupoPDO | get_permisos() | SQL: ". $sql);
        write_log("GrupoPDO | get_permisos() | Result: ". serialize($result));
        $this->disconect();
        if( count($result) > 0 ){
          return $result[0];
        }else{
          return false;
        }
      }catch(PDOException $e) {
        write_log("GrupoPDO | get_permisos() | Error al ejecutar la consulta. ERROR: " . $e->getMessage());
        write_log("SQL: " . $sql);
        return false;
      }
    }

    public function update_permisos($id, $admin_usuario, $admin_grupos, $admin_perfiles, $admin_emisores, $admin_clientes, $admin_prodserv, $admin_series, $comprobantes_facturas, $report_reportemensual, $catsat_prodserv, $catsat_unidades, $catsat_formaspago, $catsat_monedas, $catsat_impuestos){
      $this->connect();
      try{
        $sql = "UPDATE permisos SET Admin_usuario='$admin_usuario', Admin_grupos='$admin_grupos', Admin_perfiles='$admin_perfiles',
        Admin_emisores='$admin_emisores', Admin_clientes='$admin_clientes', Admin_prodserv='$admin_prodserv', Admin_series='$admin_series',
        Comprobantes_facturas='$comprobantes_facturas', Reportes_reportemensual='$report_reportemensual',
        CatSAT_claves_prodserv='$catsat_prodserv', CatSAT_unidades='$catsat_unidades', CatSAT_formaspago='$catsat_formaspago',
        CatSAT_monedas='$catsat_monedas', CatSAT_impuestos='$catsat_impuestos'
        WHERE Id=$id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        write_log("GrupoPDO | update_permisos() | SQL: " . $sql);
        write_log("GrupoPDO | update_permisos() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
        $this->disconect();
        return true;
      }catch(PDOException $e) {
        write_log("GrupoPDO | update_permisos() | Ocurrió un error al realizar el UPDATE del Usuario\nError: ". $e->getMessage());
        write_log("SQL: ". $sql);
        $this->disconect();
        return false;
      }
    }

  }

?>
