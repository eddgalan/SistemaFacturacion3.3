<?php
    Class CatSATUsosCFDI extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $clave;
      private $concepto;
      private $fisica;
      private $moral;
      private $fecha_inicio;
      private $fecha_fin;

      function __construct() {
        parent::__construct();
        $this->connect();
      }

      public function get_all(){
        $sql = "SELECT * FROM catsatusocfdi WHERE emisor='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATUsoCFDI \n " . serialize($result));
        return $result;
      }
    }
?>
