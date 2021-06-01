<?php
    Class SeriePDO extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $serie;
      private $tipo_comprobante;
      private $desc_tipo_comprobante;
      private $consecutivo;
      private $csd;

      function __construct($id='', $estatus='', $emisor='', $serie='', $tipo_comprobante='', $desc_tipo_comprobante='', $consecutivo='', $csd='') {
        parent::__construct();
        $this->id = $id;
        $this->estatus = $estatus;
        $this->emisor = $emisor;
        $this->serie = $serie;
        $this->tipo_comprobante = $tipo_comprobante;
        $this->desc_tipo_comprobante = $desc_tipo_comprobante;
        $this->consecutivo = $consecutivo;
        $this->csd = $csd;
      }

      public function get_tpocomprobantes_catsat(){
        $file_json = fopen('models/anexo20/c_TipoDeComprobante.json','r');
        $array_tpocomprobantes = json_decode(fread($file_json, filesize('models/anexo20/c_TipoDeComprobante.json')),true);
        // var_dump($array_monedas);
        return $array_tpocomprobantes;
      }

      public function get_all($emisor){
        $this->connect();
        $sql = "SELECT * FROM series WHERE Emisor='$emisor'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("SeriePDO | get_all() | SQL: " . $sql);
        write_log("SeriePDO | get_all() | Result: " . serialize($result));
        return $result;
      }

      public function get_all_actives($emisor){
        $this->connect();
        $sql = "SELECT * FROM series WHERE Emisor='$emisor' AND Estatus=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("SeriePDO | get_all_actives() | SQL: " . $sql);
        write_log("SeriePDO | get_all_actives() | Result: " . serialize($result));
        return $result;
      }

      public function get_serie($id_serie, $emisor){
        $this->connect();
        try{
          $sql = "SELECT * FROM series
          WHERE  Id='$id_serie' AND Emisor='$emisor'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("SeriePDO | get_serie() | SQL: " . $sql);
          write_log("SeriePDO | get_serie() | Result: " . serialize($result));
          $this->disconect();
          if( count($result) >0 ){
            return $result[0];
          }else{
            return false;
          }
        }catch(PDOException $e) {
          write_log("SeriePDO | get_serie() | Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;
        }
      }

      public function get_serie_by_serie_emisor($emisor, $serie){
        $this->connect();
        try{
          $sql = "SELECT * FROM series
          WHERE Emisor='$emisor' AND Serie='$serie'";

          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("SeriePDO | get_serie_by_serie_emisor() | SQL: " . $sql);
          write_log("SeriePDO | get_serie_by_serie_emisor() | Result: " . serialize($result));
          $this->disconect();
          if( count($result) >0 ){
            return $result[0];
          }else{
            return false;
          }
        }catch(PDOException $e) {
          write_log("Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;
        }
      }

      public function insert_serie($emisor, $serie, $descripcion, $strtpo_comprobante, $consecutivo, $csd){
        $array_tpocomprobante = explode(" | ", $strtpo_comprobante);
        $tipo_comprobante = $array_tpocomprobante[0];
        $desc_tpo_comp = $array_tpocomprobante[1];

        try{
          $this->connect();
          $sql = "INSERT INTO series (Emisor, Serie, Descripcion, TipoComprobante, DescripcionTipoComp, Consecutivo, CSD)
          VALUES ('$emisor', '$serie', '$descripcion', '$tipo_comprobante', '$desc_tpo_comp', '$consecutivo', '$csd')";
          $this->conn->exec($sql);
          write_log("SeriePDO | insert_serie() | SQL: ". $sql);
          write_log("SeriePDO | insert_serie() | Se realizó el INSERT de la Serie con Éxito");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("SeriePDO | insert_serie() | Ocurrió un error al realizar el INSERT de la Serie\nError: ". $e->getMessage());
          write_log("SQL: " . $sql);
          $this->disconect();
          return false;
        }
      }

      public function update_serie($id, $serie, $descripcion, $strtpo_comprobante, $consecutivo){
        $array_tpocomprobante = explode(" | ", $strtpo_comprobante);
        $tipo_comprobante = $array_tpocomprobante[0];
        $desc_tpo_comp = $array_tpocomprobante[1];

        try{
          $this->connect();
          $sql = "UPDATE series SET  Serie = '$serie', Descripcion = '$descripcion',
          TipoComprobante = '$tipo_comprobante', DescripcionTipoComp = '$desc_tpo_comp', Consecutivo = '$consecutivo'
          WHERE Id = '$id'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          write_log("SeriePDO | update_serie() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("SeriePDO | update_serie() | Ocurrió un error al realizar el UPDATE de la Serie\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
          return false;
        }
      }

      public function update_consecutivo($id, $nuevo_consecutivo){
        $this->connect();
        try{
          $sql_update = "UPDATE series SET Consecutivo='$nuevo_consecutivo' WHERE Id='$id'";
          $stmt = $this->conn->prepare($sql_update);
          $stmt->execute();

          write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e){
          write_log("Ocurrió un error al actualizar la serie. ERROR: " .$e->getMessage());
          write_log("SQL: " .$sql_update);
          $this->disconect();
          return false;
        }


        write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
        $this->disconect();
      }

    }
?>
