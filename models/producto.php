<?php
    Class ProductoPDO extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $sku;
      private $nombre;
      private $clave_prodserv;
      private $clave_unidad;
      private $precio;
      private $impuesto;

      function __construct($id='', $estatus='', $emisor='', $sku='', $nombre='', $clave_prodserv='', $clave_unidad='', $precio='', $impuesto='') {
        parent::__construct();
        $this->id = $id;
        $this->estatus = $estatus;
        $this->emisor = $emisor;
        $this->sku = $sku;
        $this->nombre = $nombre;
        $this->clave_prodserv = $clave_prodserv;
        $this->clave_unidad = $clave_unidad;
        $this->precio = $precio;
        $this->impuesto = $impuesto;
      }

      public function get_all(){
        $sesion = new UserSession();
        $data_session = $sesion->get_session();

        $emisor = $data_session['Emisor'];

        $this->connect();
        $sql = "SELECT * FROM productos WHERE Emisor='$emisor' AND Estatus='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("ProductoPDO\n " . serialize($result));
        return $result;
      }

      public function get_producto(){
        $this->connect();
        try{
          $sql = "SELECT productos.Id as ProductoID, productos.SKU, productos.Nombre as ProductoNombre,
          productos.Precio as ProductoPrecio,
          catsatclavesprodserv.ClaveProdServ as ProductoClaveSAT,
          catsatunidades.ClaveUnidad as UnidadClave, catsatunidades.NombreUnidad as UnidadNombre,
          catsatimpuestos.ClaveImpuesto as ImpuestoClave, catsatimpuestos.Descripcion as ImpuestoDesc, catsatimpuestos.Tasa_Cuota as ImpuestoTasa
          FROM productos
          INNER JOIN catsatclavesprodserv ON productos.ClaveProdServ = catsatclavesprodserv.Id
          INNER JOIN catsatunidades ON productos.ClaveUnidad = catsatunidades.Id
          INNER JOIN catsatimpuestos ON productos.Impuesto = catsatimpuestos.Id
          WHERE productos.Id='$this->id'";

          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("ProductoPDO\n " . serialize($result));
          return $result[0];
        }catch(PDOException $e) {
          write_log("Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;
        }
      }

    }
?>
