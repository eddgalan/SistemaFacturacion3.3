<?php
    Class CatSATProdServ extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $clave;
      private $descripcion;

      function __construct() {
        parent::__construct();
        $this->connect();
      }

      public function get_all_catsat(){
        $file_json = fopen('models/anexo20/c_ClaveProdServ.json','r');
        $array_unidades = json_decode(fread($file_json, filesize('models/anexo20/c_ClaveProdServ.json')),true);
        // var_dump($array_unidades[0]);
        return $array_unidades[0];
      }

      public function get_all(){
        $sql = "SELECT * FROM catsatclavesprodserv WHERE emisor='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATMoneda \n " . serialize($result));
        return $result;
      }
    }
?>
