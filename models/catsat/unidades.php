<?php
    Class CatSATUnidades extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $clave;
      private $nombre;
      private $descripcion;
      private $simbolo;

      function __construct() {
        parent::__construct();
        $this->connect();
      }

      public function get_all_catsat(){
        $file_json = fopen('models/anexo20/c_ClaveUnidad.json','r');
        $array_unidades = json_decode(fread($file_json, filesize('models/anexo20/c_ClaveUnidad.json')),true);
        // var_dump($array_unidades);
        return $array_unidades;
      }

      public function get_all(){
        $sql = "SELECT * FROM catsatunidades WHERE emisor='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATMoneda \n " . serialize($result));
        return $result;
      }
    }
?>
