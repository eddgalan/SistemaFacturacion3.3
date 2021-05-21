<?php
    Class ContactoPDO extends Connection_PDO{
      private $id;
      private $cliente;
      private $nombre;
      private $apellido_paterno;
      private $apellido_materno;
      private $puesto;
      private $email;
      private $tel1;
      private $tel2;

      function __construct($id=''){
        $this->id=$id;
        parent::__construct();
      }

      public function get_contactos_cliente($cliente_id){
        $this->connect();
        $sql = "SELECT * FROM contactos WHERE Cliente='$cliente_id'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("ContactoPDO | get_contactos_cliente() | SQL: " . $sql);
        write_log("ContactoPDO | get_contactos_cliente() | Contactos cliente\n" . serialize($result[0]));
        return $result;
      }
    }
?>
