<?php
    Class CatSATMoneda extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $clave;
      private $nombre;
      private $nodecimales;
      private $variacion;
      private $fechainicio;
      private $fechafin;

      function __construct() {
        parent::__construct();
        $this->connect();
      }

      public function get_all_catsat(){
        $file_json = fopen('models/anexo20/c_Moneda.json','r');
        $array_monedas = json_decode(fread($file_json, filesize('models/anexo20/c_Moneda.json')),true);
        // var_dump($array_monedas);
        return $array_monedas;
      }

      public function get_all($emisor){
        $sql = "SELECT * FROM catsatmoneda WHERE emisor='$emisor'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATMoneda \n " . serialize($result));
        return $result;
      }

      public function get_all_actives($emisor){
        $sql = "SELECT * FROM catsatmoneda WHERE Emisor='$emisor' AND Estatus=1 ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATMoneda \n " . serialize($result));
        return $result;
      }

      public function add_moneda($strmoneda){
        $moneda_array = explode(" | ", $strmoneda);
        $clave_moneda = $moneda_array[0];
        $nombre_moneda = $moneda_array[1];
        $no_decimales = $moneda_array[2];
        $variacion = $moneda_array[3];
        $fecha_inicio = $moneda_array[4];
        $fecha_fin = $moneda_array[5];

        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        $this->connect();
        // Verifica que NO exista la clave de la Moneda (Evitar Duplicado)
        try{
          $sql = "SELECT Id FROM catsatmoneda WHERE Emisor='$emisor' AND ClaveMoneda='$clave_moneda'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("CatSATMoneda | add_moneda() | Verificar duplicados\nSQL: " . $sql);
          write_log("CatSATMoneda | add_moneda() | Result: " .serialize($result));
          if(count($result) != 0){
            $this->disconect();
            $sesion = new UserSession();
            $sesion->set_notification("ERROR", "La Clave de la Moneda que desea agregar ya fue agregada anteriormente.");
            header("location: ../../catalogosSAT/monedas");
          }
        }catch(PDOException $e){
          write_log("CatSATMoneda | add_moneda() | Ocurrió un error al realizar el SELECT\nError: ". $e->getMessage());
          write_log("SQL: \n" . $sql);
        }
        // Hace el INSERT de la Clave de la Unidad
        try{
          $sql = "INSERT INTO catsatmoneda (Emisor, ClaveMoneda, Nombre, NoDecimales, Variacion, FechaInicio, FechaFin)
          VALUES ('$emisor', '$clave_moneda', '$nombre_moneda', '$no_decimales', '$variacion', '$fecha_inicio', '$fecha_fin')";
          $this->conn->exec($sql);
          write_log("CatSATMoneda | add_moneda() | SQL: ". $sql);
          write_log("CatSATMoneda | add_moneda() | Se realizó el INSERT de la Moneda con Éxito");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("CatSATMoneda | add_moneda() | Ocurrió un error al realizar el INSERT de la Forma de Pago.\nError: ". $e->getMessage());
          write_log("SQL: \n" . $sql);
          $this->disconect();   // Cierra la conexión a la BD
          return false;
        }
      }

      public function get_moneda($id_moneda, $emisor){
        $sql = "SELECT * FROM catsatmoneda WHERE Id='$id_moneda' AND Emisor='$emisor'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATMoneda | get_moneda() | SQL: " . $sql);
        write_log("CatSATMoneda | get_moneda() | Result: " . serialize($result));
        if( count($result) > 0 ){
          return $result[0];
        }else{
          return false;
        }
      }

      public function cambiar_activo($moneda_id, $nuevo_status, $emisor){
        try{
          $this->connect();
          $sql = "UPDATE catsatmoneda
          SET Estatus='$nuevo_status'
          WHERE Id = $moneda_id AND Emisor = $emisor";
          write_log("CatSATMoneda | cambiar_activo() | SQL: " . $sql);
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
          write_log("CatSATMoneda | cambiar_activo() | Ocurrió un error al activar/desactivar la Moneda.\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
        }
      }

    }
?>
