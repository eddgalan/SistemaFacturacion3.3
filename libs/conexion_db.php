<?php
  class Connection_PDO{
    Protected $servername;
    Protected $username;
    Protected $password;
    Protected $dbname;
    Protected $conn;

    function __construct() {
      $this->servername = "";   // Colocar aquí el nombre del servidor
      $this->username = "";     // Colocar aquí el nombre del usuario (De la base de datos)
      $this->password = "";     // Colocar aquí la contraseña del usuario (De la base de datos)
      $this->sqldatabase = "";  // Nombre de la base de datos
    }

    function connect(){
      try {
        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->sqldatabase", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        write_log("¡Conexión a BD Exitosa!");
      } catch(PDOException $e) {
        write_log("Ocurrió un error al conectar a la BD: \nError: " . $e->getMessage());
      }
    }

    function disconect(){
      write_log("Desconectado de la BD");
    }
  }


  class MySQL_Object{
    /* ...:: PROPIEDADES ::... */
    Protected $servername;
    Protected $username;
    Protected $password;
    Protected $sqldatabase;
    Protected $conn;

    /* ...:: MÉTODOS ::... */
    // Constructor
    function __construct() {
      $this->servername = "";   // Colocar aquí el nombre del servidor
      $this->username = "";     // Colocar aquí el nombre del usuario (De la base de datos)
      $this->password = "";     // Colocar aquí la contraseña del usuario (De la base de datos)
      $this->sqldatabase = "";  // Nombre de la base de datos
    }
    // Conectar a la BD
    function conectar() {
      $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->sqldatabase);
      // Check connection
      if ($this->conn->connect_error) {
        write_log("ERROR al conectar a la BD: '" . $this->conn->connect_error ."'");
        die("Connection failed: " . $this->conn->connect_error);
      }
    }
    // Desconectar de la BD
    function desconectar(){
      $this->conn->close();
    }
  }
?>
