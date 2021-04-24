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
          $sesion = new UserSession();
          $data_session = $sesion->get_session();

          $emisor = $data_session['Emisor'];

          $sql = "SELECT * FROM series
          WHERE Emisor='$emisor' AND Serie='$this->serie'";

          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("SeriePDO\n" . serialize($result));
          return $result[0];
        }catch(PDOException $e) {
          write_log("Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;
        }
      }

    }
?>
