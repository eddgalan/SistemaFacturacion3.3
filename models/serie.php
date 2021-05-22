<?php
    Class SeriePDO extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $serie;
      private $tipo_comprobante;
      private $desc_tipo_comprobante;
      private $consecutivo;
      private $csd;

      function __construct($id='', $estatus='', $emisor='', $serie='', $tipo_comprobante='', $desc_tipo_comprobante='', $consecutivo='', $csd='') {
        parent::__construct();
        $this->id = $id;
        $this->estatus = $estatus;
        $this->emisor = $emisor;
        $this->serie = $serie;
        $this->tipo_comprobante = $tipo_comprobante;
        $this->desc_tipo_comprobante = $desc_tipo_comprobante;
        $this->consecutivo = $consecutivo;
        $this->csd = $csd;
      }

      public function get_all(){
        $sesion = new UserSession();
        $data_session = $sesion->get_session();

        $emisor = $data_session['Emisor'];

        $this->connect();
        $sql = "SELECT * FROM productos WHERE Emisor='$emisor' AND Estatus='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("ProductoPDO\n " . serialize($result));
        return $result;
      }

      public function get_serie(){
        $this->connect();
        try{
          $sql = "SELECT * FROM series
          WHERE Emisor='$this->emisor' AND Serie='$this->serie'";

          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("SeriePDO | get_serie() | " . serialize($result[0]));
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
