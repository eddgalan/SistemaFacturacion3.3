<?php
    Class CatSATFormaPago extends Connection_PDO{
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
        $file_json = fopen('models/anexo20/c_FormaPago.json','r');
        $array_formaspago = json_decode(fread($file_json, filesize('models/anexo20/c_FormaPago.json')),true);
        // var_dump($array_formaspago);
        return $array_formaspago;
      }

      public function get_all_actives($emisor){
        $sql = "SELECT * FROM catsatformaspago WHERE Emisor='$emisor' AND Estatus=1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATFormaPago | get_all() | SQL: " . $sql);
        write_log("CatSATFormaPago | get_all() | Result:  " . serialize($result));
        return $result;
      }

      public function get_all($emisor){
        $sql = "SELECT * FROM catsatformaspago WHERE Emisor='$emisor'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATFormaPago | get_all() | SQL: " . $sql);
        write_log("CatSATFormaPago | get_all() | Result:  " . serialize($result));
        return $result;
      }

      public function get_formapago($id_formapago, $emisor){
        $sql = "SELECT * FROM catsatformaspago WHERE Id='$id_formapago' AND Emisor='$emisor'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATFormaPago | get_formapago() | SQL: " . $sql);
        write_log("CatSATFormaPago | get_formapago() | Result: " . serialize($result));
        if( count($result) > 0 ){
          return $result[0];
        }else{
          return false;
        }
      }

      public function add_formapago($strformapago){
        $forma_array = explode(" | ", $strformapago);
        $clave_formapago = $forma_array[0];
        $desc_formapago = $forma_array[1];

        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        $this->connect();
        // Verifica que NO exista la clave de la unidad (Evitar Duplicado)
        try{
          $sql = "SELECT Id FROM catsatformaspago WHERE Emisor='$emisor' AND ClaveFormaPago='$clave_formapago'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("CatSATFormaPago | add_metodopago() | Verificar duplicados\nSQL: " . $sql);
          write_log("CatSATFormaPago | add_metodopago() | Result: " .serialize($result));
          if(count($result) != 0){
            $this->disconect();
            $sesion = new UserSession();
            $sesion->set_notification("ERROR", "La Clave de la Forma de Pago que desea agregar ya fue agregada anteriormente.");
            header("location: ../../catalogosSAT/formas_pago");
          }
        }catch(PDOException $e){
          write_log("CatSATFormaPago | add_metodopago() | Ocurrió un error al realizar el SELECT\nError: ". $e->getMessage());
          write_log("SQL: \n" . $sql);
        }
        // Hace el INSERT de la Clave de la Unidad
        try{
          $sql = "INSERT INTO catsatformaspago (Emisor, ClaveFormaPago, Descripcion)
          VALUES ('$emisor', '$clave_formapago', '$desc_formapago')";
          $this->conn->exec($sql);
          write_log("CatSATFormaPago | add_metodopago() | Se realizó el INSERT de la Forma de Pago con Éxito");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("CatSATFormaPago | add_metodopago() | Ocurrió un error al realizar el INSERT de la Forma de Pago.\nError: ". $e->getMessage());
          write_log("SQL: \n" . $sql);
          $this->disconect();   // Cierra la conexión a la BD
          return false;
        }
      }

      public function cambiar_activo($formapago_id, $nuevo_status, $emisor){
        try{
          $this->connect();
          $sql = "UPDATE catsatformaspago
          SET Estatus='$nuevo_status'
          WHERE Id = $formapago_id AND Emisor = $emisor";
          write_log("CatSATFormaPago | cambiar_activo() | SQL: " . $sql);
          write_log($sql);
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          if( $stmt->rowCount() == 1){
            write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
            $this->disconect();
            return true;
          }else{
            write_log("Se actualizaron mas de un registro");
            return false;
          }
        }catch(PDOException $e){
          write_log("CatSATFormaPago | cambiar_activo() | Ocurrió un error al activar/desactivar la forma de pago.\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
        }
      }

    }
?>
