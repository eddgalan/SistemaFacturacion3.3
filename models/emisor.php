<?php
    Class EmisorPDO extends Connection_PDO{
      private $id;
      private $estatus;
      private $nombre;
      private $rfc;
      private $domicilio;
      private $cp;
      private $persona;
      private $regimen;
      private $pathlogo;
      private $pac;

      function __construct($id=''){
        $this->id=$id;
        parent::__construct();

      }

      public function get_emisor(){
        $this->connect();
        $sql = "SELECT * FROM emisores WHERE Id='$this->id'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("EmisorPDO | get_emisor\n" . serialize($result[0]));
        return $result[0];
      }
    }
?>
