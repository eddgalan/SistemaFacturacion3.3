<?php
    Class ClientePDO extends Connection_PDO{
      private $id;
      private $emisor;
      private $estatus;
      private $nombre;
      private $rfc;
      private $direccion;
      private $telefono;
      private $correo;

      function __construct() {
        parent::__construct();
        $this->connect();
      }

      public function get_clientes(){
        $sql = "SELECT * FROM clientes WHERE emisor='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log(serialize($result));
        return $result;
      }
    }
?>
