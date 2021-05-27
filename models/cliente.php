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

      public function get_cliente($id, $emisor){
        $sql = "SELECT * FROM clientes WHERE Id='$id' AND Emisor='$emisor'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("ClientePDO | get_cliente() | SQL: " . $sql);
        write_log("ClientePDO | get_cliente() | Result: " . serialize($result));
        if( count($result) > 0 ){
          return $result[0];
        }else{
          return false;
        }
      }

    }
?>
