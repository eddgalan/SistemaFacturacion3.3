<?php
    Class CSD_PDO extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $nocertificado;
      private $certificado;
      private $pathcertificado;
      private $pathkey;
      private $passcer;
      private $vigencia_inicio;
      private $vigencia_fin;
      private $pathpem;

      function __construct($id='', $estatus='', $emisor='', $nocertificado='', $certificado='', $pathcertificado='',
      $pathkey='', $passcer='', $vigencia_inicio='', $vigencia_fin='', $pathpem='') {
        parent::__construct();
        $this->id = $id;
        $this->estatus = $estatus;
        $this->emisor = $emisor;
        $this->nocertificado = $nocertificado;
        $this->certificado = $certificado;
        $this->pathcertificado = $pathcertificado;
        $this->pathkey = $pathkey;
        $this->passcer = $passcer;
        $this->vigencia_inicio = $vigencia_inicio;
        $this->vigencia_fin = $vigencia_fin;
        $this->pathpem = $pathpem;
      }

      public function get_csd(){
        $this->connect();
        try{
          $sql = "SELECT * FROM csd
          WHERE Emisor='$this->emisor'";

          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("SQL CSD: " . $sql);
          write_log("CSD_PDO | get_csd()\n" . serialize($result[0]));
          $this->disconect();
          return $result[0];
        }catch(PDOException $e) {
          write_log("Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;
        }
      }

      public function update_consecutivo($id, $nuevo_consecutivo){
        $this->connect();
        try{
          $sql_update = "UPDATE series SET Consecutivo='$nuevo_consecutivo' WHERE Id='$id'";
          $stmt = $this->conn->prepare($sql_update);
          $stmt->execute();

          write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e){
          write_log("Ocurrió un error al actualizar la serie. ERROR: " .$e->getMessage());
          write_log("SQL: " .$sql_update);
          $this->disconect();
          return false;
        }


        write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
        $this->disconect();
      }

    }
?>
