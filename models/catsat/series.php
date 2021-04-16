<?php
    Class SeriesPDO extends Connection_PDO{
      private $id;
      private $emisor;
      private $estatus;
      private $serie;
      private $descripcion;
      private $tipo_comprobante;
      private $descrip_tipo_comprobante;
      private $consecutivo;
      private $csd;

      function __construct() {
        parent::__construct();
        $this->connect();
      }

      public function get_all(){
        $sql = "SELECT * FROM series WHERE emisor='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("Series \n " . serialize($result));
        return $result;
      }
    }
?>
