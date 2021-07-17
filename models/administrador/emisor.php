<?php
    Class EmisorPDO extends Connection_PDO{
      private $id;
      private $estatus;
      private $nombre;
      private $rfc;
      private $domicilio;
      private $cp;
      private $persona;
      private $regimen;
      private $pathlogo;
      private $pac;

      function __construct($id=''){
        $this->id=$id;
        parent::__construct();
      }

      public function get_count(){
        $this->connect();
        $sql = "SELECT COUNT(Id) AS NoEmisores FROM emisores";
        $stmt = $this->conn->prepare($sql);
        write_log("EmisorPDO | get_count() | SQL: ". $sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconect();
        write_log("EmisorPDO | get_count() | Result: ". serialize($result));
        if(count($result) != 0){
          return $result[0]['NoEmisores'];
        }else{
          write_log("EmisorPDO | get_count() | NO se han registrado Usuarios");
        }
      }

      public function get_all(){
        $this->connect();
        try{
          $sql = "SELECT * FROM emisores";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("EmisorPDO | get_all() | SQL: " . $sql);
          write_log("EmisorPDO | get_all() | Result: ". serialize($result));
          return $result;
        }catch(PDOException $e) {
          write_log("EmisorPDO | get_all() | Ocurrió un error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;
        }
      }

      public function insert_emisor($nombre, $rfc, $pac, $tpo_persona){
        $this->connect();
        try{
          $sql = "INSERT INTO emisores (Nombre, RFC, Persona, PAC)
          VALUES ('$nombre', '$rfc', '$tpo_persona', '$pac')";
          $this->conn->exec($sql);
          write_log("EmisorPDO | insert_emisor() | Se realizó el INSERT con Éxito.");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("EmisorPDO | insert_emisor() | Ocurrió un error al realizar el INSERT del Emisor\nError: ". $e->getMessage());
          $this->disconect();
          return false;
        }
      }

      public function get_emisor($id){
        $this->connect();
        try{
          $sql = "SELECT * FROM emisores WHERE Id='$id'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("EmisorPDO | get_emisor() | SQL: " . $sql);
          write_log("EmisorPDO | get_emisor() | Result: ". serialize($result));

          if( count($result) == 1 ){
            return $result[0];
          }else{
            return false;
          }
        }catch(PDOException $e) {
          write_log("EmisorPDO | get_emisor() | Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;
        }
      }

      public function update_emisor($id_emisor, $emisor, $rfc_edit, $domicilio, $codigo_postal, $tipo_persona,
      $regimen, $desc_regimen, $path_logo, $pac, $modo){
        try{
          $this->connect();
          $sql = "UPDATE emisores SET Nombre = '$emisor', RFC = '$rfc_edit', Domicilio = '$domicilio', CP = '$codigo_postal',
          Persona = '$tipo_persona', Regimen = '$regimen', DescRegimen = '$desc_regimen', PathLogo = '$path_logo',
          PAC = '$pac', Testing = '$modo'
          WHERE Id = '$id_emisor'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          write_log("EmisorPDO | update_emisor() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("EmisorPDO | update_emisor() | Ocurrió un error al realizar el UPDATE del Emisor\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
          return false;
        }
      }

      public function update_miempresa($id_emisor, $nombre, $direccion, $codigo_postal, $tipo_persona, $regimen, $desc_regimen){
        try{
          $this->connect();
          $sql = "UPDATE emisores SET Nombre = '$nombre', Domicilio = '$direccion', CP = '$codigo_postal',
          Persona = '$tipo_persona', Regimen = '$regimen', DescRegimen = '$desc_regimen'
          WHERE Id = '$id_emisor'";
          write_log("EmisorPDO | update_miempresa() | SQL: ". $sql);
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          write_log("EmisorPDO | update_miempresa() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("EmisorPDO | update_miempresa() | Ocurrió un error al realizar el UPDATE del Emisor\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
          return false;
        }
      }

      public function update_logo($id_emisor, $new_path){
        try{
          $this->connect();
          $sql = "UPDATE emisores SET PathLogo = '$new_path'
          WHERE Id = '$id_emisor'";
          write_log("EmisorPDO | update_logo() | SQL: ". $sql);
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          write_log("EmisorPDO | update_logo() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("EmisorPDO | update_logo() | Ocurrió un error al realizar el UPDATE del Emisor\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
          return false;
        }
      }

      public function cambiar_activo($id_emisor, $nuevo_status){
        try{
          $this->connect();
          $sql = "UPDATE emisores
          SET Estatus='$nuevo_status'
          WHERE Id = $id_emisor";
          write_log("EmisorPDO | cambiar_activo() | SQL: " . $sql);
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          if( $stmt->rowCount() == 1){
            write_log("EmisorPDO | cambiar_activo() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
            $this->disconect();
            return true;
          }else{
            write_log("EmisorPDO | cambiar_activo() | Se actualizaron mas de un registro");
            return false;
          }
        }catch(PDOException $e){
          write_log("EmisorPDO | cambiar_activo() | Ocurrió un error al activar/desactivar la Moneda.\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
        }
      }

    }
?>
