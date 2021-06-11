<?php
    Class ContactoPDO extends Connection_PDO{
      private $id;
      private $cliente;
      private $nombre;
      private $apellido_paterno;
      private $apellido_materno;
      private $puesto;
      private $email;
      private $tel1;
      private $tel2;

      function __construct($id=''){
        $this->id=$id;
        parent::__construct();
      }

      public function insert_contacto($id_cliente, $alias, $nombre, $apellido_pat, $apellido_mat, $puesto, $email, $tel_1, $tel_2){
        $this->connect();
        try{
          $sql = "INSERT INTO contactos (Cliente, Alias, Nombre, ApellidoPaterno, ApellidoMaterno, Puesto, Email, Num1, Num2)
          VALUES ('$id_cliente', '$alias', '$nombre', '$apellido_pat', '$apellido_mat', '$puesto', '$email', '$tel_1', '$tel_2')";
          write_log("ContactoPDO | insert_contacto() | SQL: ". $sql);
          $this->conn->exec($sql);
          $this->disconect();
          write_log("ContactoPDO | insert_contacto() | Se realizó el INSERT del contacto ");
          return true;
        }catch(PDOException $e) {
          write_log("ContactoPDO | insert_contacto() | Ocurrió un error al hacer el INSERT del contacto\nError: ". $e->getMessage());
          $this->disconect();
          return false;
        }
      }

      public function update_contacto($id_contacto, $id_cliente, $alias, $nombre, $apellido_pat, $apellido_mat, $puesto, $email, $tel1, $tel2){
        $this->connect();
        try{
          $sql = "UPDATE contactos SET Alias ='$alias', Nombre='$nombre', ApellidoPaterno='$apellido_pat', ApellidoMaterno='$apellido_mat',
          Puesto='$puesto', Email='$email', Num1='$tel1', Num2='$tel2'
          WHERE Id='$id_contacto' AND Cliente='$id_cliente'";
          write_log("ContactoPDO | update_contacto() | SQL: " .$sql);
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          write_log("ContactoPDO | update_contacto() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e){
          write_log("ContactoPDO | update_contacto() |  Ocurrió un error al realizar el UPDATE del Cliente\nError: ". $e->getMessage());
          write_log("ContactoPDO | update_contacto() |  SQL: ". $sql);
          $this->disconect();
          return false;
        }
      }

      public function delete_contacto($id_contacto, $cliente_id){
        $this->connect();
        try{
          $sql = "DELETE FROM contactos WHERE Id=$id_contacto AND Cliente=$cliente_id";
          write_log("ContactoPDO | delete_contacto() | SQL: ". $sql);
          $this->conn->query($sql);
          write_log("ContactoPDO | delete_contacto() | Se eliminó el contacto de forma correcta");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("ContactoPDO | delete_contacto() | Ocurrió un error al hacer el DELETE del contacto\nError: ". $e->getMessage());
          $this->disconect();
          return false;
        }

        try{
          $sql = "INSERT INTO contactos (Cliente, Alias, Nombre, ApellidoPaterno, ApellidoMaterno, Puesto, Email, Num1, Num2)
          VALUES ('$id_cliente', '$alias', '$nombre', '$apellido_pat', '$apellido_mat', '$puesto', '$email', '$tel_1', '$tel_2')";
          write_log("ContactoPDO | insert_contacto() | SQL: ". $sql);
          $this->conn->exec($sql);
          $this->disconect();
          write_log("ContactoPDO | insert_contacto() | Se realizó el INSERT del contacto ");
          return true;
        }catch(PDOException $e) {
          write_log("ContactoPDO | insert_contacto() | Ocurrió un error al hacer el INSERT del contacto\nError: ". $e->getMessage());
          $this->disconect();
          return false;
        }
      }

      public function get_contactos_cliente($cliente_id){
        $this->connect();
        $sql = "SELECT * FROM contactos WHERE Cliente='$cliente_id'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("ContactoPDO | get_contactos_cliente() | SQL: " . $sql);
        write_log("ContactoPDO | get_contactos_cliente() | Contactos cliente\n" . serialize($result));
        return $result;
      }
    }
?>
