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

      public function get_all($emisor){
        $sql = "SELECT * FROM catsatunidades WHERE emisor='$emisor'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATUnidades | get_all() | Unidades: " . serialize($result));
        return $result;
      }

      public function get_unidad($id_unidad, $emisor){
        $sql = "SELECT * FROM catsatunidades WHERE Id='$id_unidad' AND emisor='$emisor'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATUnidades | get_unidad() | SQL: " . $sql);
        write_log("CatSATUnidades | get_unidad() | Result: " . serialize($result));
        if( count($result) > 0 ){
          return $result[0];
        }else{
          return false;
        }
      }

      public function add_unidad($strunidad){
        $unidad = explode(" | ", $strunidad);
        $clave_unidad = $unidad[0];
        $nombre_unidad = $unidad[1];
        $simbolo = $unidad[2];
        $descripcion = "";

        $catalogo = $this->get_all_catsat();
        foreach($catalogo as $uni){
          if( $uni['unidad_clave']== $clave_unidad ){
            $descipcion = $uni['unidad_descripcion'];
          }
        }

        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        $this->connect();
        // Verifica que NO exista la clave de la unidad (Evitar Duplicado)
        try{
          $sql = "SELECT Id FROM catsatunidades WHERE Emisor='$emisor' AND ClaveUnidad='$clave_unidad'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("CatSATUnidades | add_unidad() | Verificar duplicados\nSQL: " . $sql);
          write_log("CatSATUnidades | add_unidad() | Result: " .serialize($result));
          if(count($result) != 0){
            $this->disconect();
            $sesion = new UserSession();
            $sesion->set_notification("ERROR", "La Clave de la Unidad que desea agregar ya fue agregada anteriormente");
            header("location: ../../catalogosSAT/unidades");
          }
        }catch(PDOException $e){
          write_log("CatSATUnidades | add_unidad() | Ocurrió un error al realizar el SELECT\nError: ". $e->getMessage());
          write_log("SQL: \n" . $sql);
        }
        // Hace el INSERT de la Clave de la Unidad
        try{
          $sql = "INSERT INTO catsatunidades (Emisor, ClaveUnidad, NombreUnidad, Descripcion, Simbolo)
          VALUES ('$emisor', '$clave_unidad', '$nombre_unidad', '$descipcion', '$simbolo')";
          $this->conn->exec($sql);
          write_log("CatSATUnidades | add_unidad() | Se realizó el INSERT de la Clave de Unidad con Éxito");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("CatSATUnidades | add_unidad() | Ocurrió un error al realizar el INSERT de la Clave de Unidad\nError: ". $e->getMessage());
          write_log("SQL: \n" . $sql);
          $this->disconect();   // Cierra la conexión a la BD
          return false;
        }
      }

      public function cambiar_activo($id_unidad, $nuevo_status, $emisor){
        try{
          $this->connect();
          $sql = "UPDATE catsatunidades
          SET Estatus='$nuevo_status'
          WHERE Id = $id_unidad AND Emisor = $emisor";
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
          write_log("Ocurrió un error al actualizar el campo Activo del Usuario\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
        }
      }

    }
?>
