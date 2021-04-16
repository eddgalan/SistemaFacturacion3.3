<?php
    Class CatSATMoneda extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $clave;
      private $nombre;
      private $nodecimales;
      private $variacion;
      private $fechainicio;
      private $fechafin;

      function __construct() {
        parent::__construct();
        $this->connect();
      }

      public function get_all(){
        $sql = "SELECT * FROM catsatmoneda WHERE emisor='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATMoneda \n " . serialize($result));
        return $result;
      }
    }
?>
