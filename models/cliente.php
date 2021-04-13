<?php
    Class ClientePDO extends Connection_PDO{
      private $id_cliente;
      private $nombre;

      function __construct() {
        parent::__construct();
        $this->connect();
      }

      public function get_clientes(){
        $stmt = $this->conn->prepare("SELECT * FROM cliente LIMIT 3");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log(serialize($result));
        return $result;
      }
    }
?>
