<?php
  require_once 'libs/conexion_db.php';

  Class PacPDO extends Connection_PDO{
    private $id;
    private $activo;
    private $nombre;
    private $nombre_corto;
    private $endpoint;
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

    public function insert_pac(){
      $this->connect();       // Conecta a la base de datos
      try{
        $sql = "INSERT INTO pac (Nombre, NombreCorto, EndPoint, UsrPAC, PassPAC, Observaciones)
        VALUES ('$this->usrname', '$this->userpass', '$this->email')";
        $this->conn->exec($sql);
        write_log("Se realizó el INSERT del PAC con Éxito");
        $this->disconect();   // Cierra la conexión a la BD
        return true;
      }catch(PDOException $e) {
        write_log("Ocurrió un error al realizar el INSERT del PAC\nError: ". $e->getMessage());
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

    public function get_active_pac(){
      $this->connect();
      $stmt = $this->conn->prepare("SELECT * FROM pac WHERE Estatus='1'");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $this->disconect();

      if(count($result) != 0){
        return $result;
      }else{
        write_log("No se encuentran PACs ACTIVOS");
      }
    }
  }

?>
