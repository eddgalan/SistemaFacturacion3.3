<?php
    Class ClientePDO extends Connection_PDO{
      function __construct() {
        parent::__construct();
      }

      public function insert_cliente($emisor, $nombre, $rfc, $tipo_persona, $direccion, $telefono, $correo){
        $this->connect();
        try{
          $sql = "INSERT INTO clientes (Emisor, Nombre, RFC, TipoPersona, Direccion, Telefono, Correo)
          VALUES ('$emisor', '$nombre', '$rfc', '$tipo_persona', '$direccion', '$telefono', '$correo')";
          write_log("ClientePDO | insert_cliente() | SQL: ". $sql);
          $this->conn->exec($sql);
          $this->disconect();
          write_log("ClientePDO | insert_cliente() | Se realizó el INSERT del cliente ");
          return true;
        }catch(PDOException $e) {
          write_log("ClientePDO | insert_cliente() | Ocurrió un error al hacer el INSERT del Cliente\nError: ". $e->getMessage());
          $this->disconect();
          return false;
        }
      }

      public function update_cliente($id, $emisor, $nombre, $rfc, $tipo_persona, $direccion, $telefono, $correo){
        $this->connect();
        try{
          $sql = "UPDATE clientes SET Nombre ='$nombre', RFC='$rfc', TipoPersona='$tipo_persona',
          Direccion='$direccion', Telefono='$telefono', Correo='$correo'
          WHERE Id='$id' AND Emisor='$emisor'";
          write_log("ClientePDO | update_cliente() | SQL: " .$sql);
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          write_log("ClientePDO | update_cliente() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("ClientePDO | update_cliente() |  Ocurrió un error al realizar el UPDATE del Cliente\nError: ". $e->getMessage());
          write_log("ClientePDO | update_cliente() |  SQL: ". $sql);
          $this->disconect();
          return false;
        }
      }

      public function get_clientes($emisor){
        $this->connect();
        $sql = "SELECT * FROM clientes WHERE emisor='$emisor'";
        write_log("ClientePDO | get_clientes() | SQL: ". $sql);
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("ClientePDO | get_clientes() | Result: ". serialize($result));
        return $result;
      }

      public function get_cliente($id, $emisor){
        $this->connect();
        $sql = "SELECT * FROM clientes WHERE Id='$id' AND Emisor='$emisor'";
        write_log("ClientePDO | get_cliente() | SQL: " . $sql);
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("ClientePDO | get_cliente() | Result: " . serialize($result));
        if( count($result) > 0 ){
          return $result[0];
        }else{
          return false;
        }
      }

      public function cambiar_activo($id, $emisor, $nuevo_status){
        try{
          $this->connect();
          $sql = "UPDATE clientes
          SET Estatus='$nuevo_status'
          WHERE Id = $id AND Emisor=$emisor";
          write_log("ClientePDO | cambiar_activo() | SQL: " . $sql);
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          if( $stmt->rowCount() == 1){
            write_log("ClientePDO | cambiar_activo() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
            $this->disconect();
            return true;
          }else{
            write_log("ClientePDO | cambiar_activo() | Se actualizaron mas de un registro");
            return false;
          }
        }catch(PDOException $e){
          write_log("ProdServPDO | cambiar_activo() | Ocurrió un error al activar/desactivar la Moneda.\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
        }
      }

    }
?>
