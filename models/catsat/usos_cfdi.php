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

      public function get_all_catsat(){
        $file_json = fopen('models/anexo20/c_UsoCFDI.json','r');
        $array_usos_cfdi = json_decode(fread($file_json, filesize('models/anexo20/c_UsoCFDI.json')),true);
        // var_dump($array_monedas);
        return $array_usos_cfdi;
      }

      public function get_uso_concepto($clave_uso){
        $usos_cfdi = $this->get_all_catsat();
        foreach($usos_cfdi as $uso){
          if($uso['uso_clave'] == $clave_uso){
            return $uso['uso_concepto'];
          }
        }
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
