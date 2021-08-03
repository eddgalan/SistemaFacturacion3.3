<?php
  require_once 'libs/conexion_db.php';

  Class PacPDO extends Connection_PDO{
    private $id;
    private $activo;
    private $nombre;
    private $nombre_corto;
    private $endpoint;
    private $endpoint_pruebas;
    private $usrpac;
    private $passpac;
    private $observaciones;

    function __construct($id="", $activo="", $nombre="", $nombre_corto="", $endpoint="", $usrpac="", $passpac="", $observa="") {
      parent::__construct();
      $this->id = $id;
      $this->activo = $activo;
      $this->nombre = $nombre;
      $this->nombre_corto = $nombre_corto;
      $this->endpoint = $endpoint;
      $this->usrpac = $usrpac;
      $this->passpac = $passpac;
      $this->observaciones = $observa;
    }

    public function insert($nombre_pac, $nombre_corto, $endpoint, $endpoint_pruebas, $usuario, $pass, $observaciones){
      $this->connect();
      try{
        $sql = "INSERT INTO pac (Nombre, NombreCorto, EndPoint, EndPoint_Pruebas, UsrPAC, PassPAC, Observaciones)
        VALUES ('$nombre_pac', '$nombre_corto', '$endpoint', '$endpoint_pruebas', '$usuario', '$pass', '$observaciones')";
        write_log("PacPDO | insert() | SQL: ". $sql);
        $this->conn->exec($sql);
        write_log("PacPDO | insert() | Se realizó el INSERT del PAC con Éxito");
        $this->disconect();
        return true;
      }catch(PDOException $e) {
        write_log("PacPDO | insert() | Ocurrió un error al realizar el INSERT del PAC\nError: ". $e->getMessage());
        $this->disconect();
        return false;
      }
    }

    public function update($id, $nombre_pac, $nombre_corto, $endpoint, $endpoint_pruebas, $usuario, $pass, $observaciones){
      $this->connect();
      try{
        $sql = "UPDATE pac SET Nombre='$nombre_pac', NombreCorto='$nombre_corto', EndPoint='$endpoint',
        EndPoint_Pruebas='$endpoint_pruebas', UsrPAC='$usuario', PassPAC='$pass', Observaciones='$observaciones'
        WHERE Id = '$id'";
        write_log("PacPDO | update() | SQL: ". $sql);
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $this->disconect();
        return true;
      }catch(PDOException $e) {
        write_log("PacPDO | update() | Ocurrió un error al realizar el UPDATE del Perfil\nError: ". $e->getMessage());
        write_log("SQL: ". $sql);
        $this->disconect();
        return false;
      }
    }

    public function get_pac($id){
      $this->connect();
      $sql = "SELECT * FROM pac WHERE Id='$id'";
      write_log("PacPDO | get_pac() | SQL: ". $sql);
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();
      if(count($result) > 0){
        write_log("PacPDO | get_pac() | Result: " . serialize($result[0]));
        return $result[0];
      }else{
        write_log("PacPDO | get_pac() | El Query no trajo resultados.");
        return false;
      }
    }

    public function get_active_pac(){
      $this->connect();
      $sql = "SELECT * FROM pac WHERE Estatus='1'";
      $stmt = $this->conn->prepare($sql);
      write_log("PacPDO | get_active_pac() | SQL: ". $sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();
      if(count($result) != 0){
        write_log("PacPDO | get_active_pac() | Result: ". serialize($result));
        return $result;
      }else{
        write_log("PacPDO | get_active_pac() | No se encuentran PACs ACTIVOS");
        return false;
      }
    }
  }

?>
