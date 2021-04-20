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

      public function add_prodserv($prodserv){
        $clave = substr($prodserv, 0, strpos($prodserv, " | "));
        $desc = substr($prodserv, 11, strlen($prodserv));

        $sesion = new UserSession();
        $data_session = $sesion->get_session();

        write_log(serialize($data_session));
        $emisor = $data_session['Emisor'];

        $this->connect();
        // Verifica que no exista la clave de producto o servicio (Evita duplicados)
        try{
          $sql = "SELECT Id FROM catsatclavesprodserv WHERE Emisor='$emisor' AND ClaveProdServ='$clave'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if(count($result) != 0){
            $this->disconect();
            $sesion = new UserSession();
            $sesion->set_notification("ERROR", "La Clave de Producto o Servicio que desea agregar ya fue agregada anteriormente");
            header("location: ../../catalogosSAT/prod_serv");
          }
        }catch(PDOException $e){
          write_log("Ocurrió un error al realizar el SELECT\nError: ". $e->getMessage());
          write_log("SQL: \n" . $sql);
        }
        // Hace el INSERT de la Clave de Producto o Servicio
        try{
          $sql = "INSERT INTO catsatclavesprodserv (Emisor, ClaveProdServ, Descripcion)
          VALUES ('$emisor', '$clave', '$desc')";
          $this->conn->exec($sql);
          write_log("Se realizó el INSERT de la Clave de Producto/Servicio con Éxito");
          $this->disconect();   // Cierra la conexión a la BD
          return true;
        }catch(PDOException $e) {
          write_log("Ocurrió un error al realizar el INSERT de la Clave de Producto/Servicio\nError: ". $e->getMessage());
          write_log("SQL: \n" . $sql);
          $this->disconect();   // Cierra la conexión a la BD
          return false;
        }
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
