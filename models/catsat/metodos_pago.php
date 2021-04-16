<?php
    Class CatSATMetodos extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $clave;
      private $descripcion;

      function __construct() {
        parent::__construct();
        $this->connect();
      }

      public function get_all(){
        $sql = "SELECT * FROM catsatmetodos WHERE emisor='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATMetodos \n " . serialize($result));
        return $result;
      }
    }
?>
