<?php
    Class CatSATImpuestos extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $clave;
      private $descripcion;
      private $retencion;
      private $traslado;
      private $factor;
      private $tasa_cuota;

      function __construct() {
        parent::__construct();
        $this->connect();
      }

      public function get_all_catsat(){
        $file_json = fopen('models/anexo20/c_Impuesto.json','r');
        $array_monedas = json_decode(fread($file_json, filesize('models/anexo20/c_Impuesto.json')),true);
        // var_dump($array_monedas);
        return $array_monedas;
      }

      public function get_all($emisor){
        $sql = "SELECT * FROM catsatimpuestos WHERE emisor='$emisor'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATImpuestos \n " . serialize($result));
        return $result;
      }

      public function get_all_actives($emisor){
        $sql = "SELECT * FROM catsatimpuestos WHERE Emisor='$emisor' AND Estatus=1 ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATImpuestos \n " . serialize($result));
        return $result;
      }

      public function insert_impuesto($emisor, $strimpuesto, $descripcion, $factor, $tasa_cuota){
        $array_impuesto = explode(" | ", $strimpuesto);
        $clave_impuesto = $array_impuesto[0];
        $retencion = $array_impuesto[1];
        $traslado = $array_impuesto[2];

        if($retencion == "Si"){
          $retencion = 1;
        }else{
          $retencion = 0;
        }

        if($traslado == "Si"){
          $traslado = 1;
        }else{
          $traslado = 0;
        }

        try{
          $sql = "INSERT INTO catsatimpuestos (Emisor, ClaveImpuesto, Descripcion, Retencion, Traslado, Factor, Tasa_Cuota)
          VALUES ('$emisor', '$clave_impuesto', '$descripcion', $retencion, $traslado, '$factor', '$tasa_cuota')";
          $this->conn->exec($sql);
          write_log("CatSATImpuestos | add_impuesto() | SQL: ". $sql);
          write_log("CatSATImpuestos | add_impuesto() | Se realizó el INSERT del Impuesto con Éxito");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("CatSATImpuestos | add_impuesto() | Ocurrió un error al realizar el INSERT del Impuesto\nError: ". $e->getMessage());
          write_log("SQL: \n" . $sql);
          $this->disconect();   // Cierra la conexión a la BD
          return false;
        }
      }

      public function update_impuesto($id, $emisor, $strimpuesto, $descripcion, $factor, $tasa_cuota){
        $array_impuesto = explode(" | ", $strimpuesto);
        $clave_impuesto = $array_impuesto[0];
        $retencion = $array_impuesto[1];
        $traslado = $array_impuesto[2];

        if($retencion = "Si"){
          $retencion = 1;
        }else{
          $retencion = 0;
        }

        if($traslado = "Si"){
          $traslado = 1;
        }else{
          $traslado = 0;
        }

        try{
          $sql = "UPDATE catsatimpuestos SET  ClaveImpuesto = '$clave_impuesto', Descripcion = '$descripcion',
          Retencion = $retencion, Traslado = $traslado, Factor = '$factor', Tasa_Cuota = '$tasa_cuota'
          WHERE Id = '$id'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          write_log("CatSATImpuestos | update_impuesto() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("CatSATImpuestos | update_impuesto() | Ocurrió un error al realizar el UPDATE del Impuesto\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
          return false;
        }
      }

      public function get_impuesto($id_impuesto, $emisor){
        $sql = "SELECT * FROM catsatimpuestos WHERE Id='$id_impuesto' AND Emisor='$emisor'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATImpuestos | get_impuesto() | SQL: " . $sql);
        write_log("CatSATImpuestos | get_impuesto() | Result: " . serialize($result));
        if( count($result) > 0 ){
          return $result[0];
        }else{
          return false;
        }
      }

      public function cambiar_activo($impuesto_id, $nuevo_status, $emisor){
        try{
          $this->connect();
          $sql = "UPDATE catsatimpuestos
          SET Estatus='$nuevo_status'
          WHERE Id = $impuesto_id AND Emisor = $emisor";
          write_log("CatSATImpuestos | cambiar_activo() | SQL: " . $sql);
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          if( $stmt->rowCount() == 1){
            write_log("CatSATImpuestos | cambiar_activo() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
            $this->disconect();
            return true;
          }else{
            write_log("CatSATImpuestos | cambiar_activo() | Se actualizaron mas de un registro");
            return false;
          }
        }catch(PDOException $e){
          write_log("CatSATImpuestos | cambiar_activo() | Ocurrió un error al activar/desactivar la Moneda.\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
        }
      }

    }
?>
