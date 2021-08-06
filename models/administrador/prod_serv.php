<?php
    Class ProdServPDO extends Connection_PDO{

      function __construct(){
        parent::__construct();
      }

      public function get_count($emisor){
        $this->connect();
        $sql = "SELECT COUNT(Id) AS NoProdServs FROM productos WHERE Emisor='$emisor'";
        $stmt = $this->conn->prepare($sql);
        write_log("ProdServPDO | get_count() | SQL: ". $sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconect();
        write_log("ProdServPDO | get_count() | Result: ". serialize($result));
        if(count($result) != 0){
          return $result[0]['NoProdServs'];
        }
      }

      public function get_all($emisor){
        $this->connect();
        try{
          $sql = "SELECT productos.Id, productos.Estatus, productos.SKU, productos.Nombre, productos.Precio,
          catsatclavesprodserv.Id as IdProdServ, catsatclavesprodserv.ClaveProdServ as ClaveProdServ, catsatclavesprodserv.Descripcion as DescClave,
          catsatunidades.Id as IdUnidad, catsatunidades.ClaveUnidad as ClaveUnidad, catsatunidades.NombreUnidad as NombreUnidad,
          catsatimpuestos.Id as IdImpuesto, catsatimpuestos.ClaveImpuesto, catsatimpuestos.Descripcion as DescImpuesto, catsatimpuestos.Tasa_Cuota
          FROM productos
          INNER JOIN catsatclavesprodserv ON productos.ClaveProdServ = catsatclavesprodserv.Id
          INNER JOIN catsatunidades ON productos.ClaveUnidad = catsatunidades.Id
          INNER JOIN catsatimpuestos ON productos.Impuesto = catsatimpuestos.Id
          WHERE productos.Emisor=$emisor";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("ProdServPDO | get_all() | SQL: " . $sql);
          write_log("ProdServPDO | get_all() | Result: ". serialize($result));
          return $result;
        }catch(PDOException $e) {
          write_log("ProdServPDO | get_all() | Ocurrió un error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;

        }
      }

      public function get_actives($emisor){
        $this->connect();
        try{
          $sql = "SELECT productos.Id, productos.Estatus, productos.SKU, productos.Nombre, productos.Precio,
          catsatclavesprodserv.Id as IdProdServ, catsatclavesprodserv.ClaveProdServ as ClaveProdServ, catsatclavesprodserv.Descripcion as DescClave,
          catsatunidades.Id as IdUnidad, catsatunidades.ClaveUnidad as ClaveUnidad, catsatunidades.NombreUnidad as NombreUnidad,
          catsatimpuestos.Id as IdImpuesto, catsatimpuestos.ClaveImpuesto, catsatimpuestos.Descripcion as DescImpuesto, catsatimpuestos.Tasa_Cuota
          FROM productos
          INNER JOIN catsatclavesprodserv ON productos.ClaveProdServ = catsatclavesprodserv.Id
          INNER JOIN catsatunidades ON productos.ClaveUnidad = catsatunidades.Id
          INNER JOIN catsatimpuestos ON productos.Impuesto = catsatimpuestos.Id
          WHERE productos.Emisor=$emisor AND productos.Estatus=1";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("ProdServPDO | get_all() | SQL: " . $sql);
          write_log("ProdServPDO | get_all() | Result: ". serialize($result));
          return $result;
        }catch(PDOException $e) {
          write_log("ProdServPDO | get_all() | Ocurrió un error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;

        }
      }

      public function insert_prodserv($emisor, $sku, $nombre, $prodserv, $unidad, $precio, $impuesto){
        $this->connect();
        try{
          $sql = "INSERT INTO productos(Emisor, SKU, Nombre, ClaveProdServ, ClaveUnidad, Precio, Impuesto)
          VALUES ('$emisor', '$sku', '$nombre', '$prodserv', '$unidad', '$precio', '$impuesto')";
          $this->conn->exec($sql);
          write_log("ProdServPDO | insert_prodserv() | Se realizó el INSERT con Éxito.");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("ProdServPDO | insert_prodserv() | Ocurrió un error al realizar el INSERT del Producto/Servicio\nError: ". $e->getMessage());
          write_log("ProdServPDO | insert_prodserv() | SQL: ". $sql);
          $this->disconect();
          return false;
        }
      }

      public function get_prodserv_by_sku($emisor, $sku){
        $this->connect();
        try{
          $sql = "SELECT productos.Id, productos.Estatus, productos.SKU, productos.Nombre, producto.Precio,
          catsatclavesprodserv.ClaveProdServ as ClaveProdServ, catsatclavesprodserv.Descripcion as DescClave,
          catsatunidades.ClaveUnidad as ClaveUnidad, catsatunidades.NombreUnidad as NombreUnidad,
          catsatimpuestos.ClaveImpuesto, catsatimpuestos.Descripcion as DescImpuesto, catsatimpuestos.Tasa_Cuota,
          FROM productos
          INNER JOIN catsatclavesprodserv ON productos.ClaveProdServ = catsatclavesprodserv.Id
          INNER JOIN catsatunidades ON productos.ClaveUnidad = catsatunidades.Id
          INNER JOIN catsatimpuestos ON productos.Impuesto = catsatimpuestos.Id
          WHERE productos.SKU='$sku' AND productos.Emisor=$emisor";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("ProdServPDO | get_prodserv_by_sku() | SQL: " . $sql);
          write_log("ProdServPDO | get_prodserv_by_sku() | Result: ". serialize($result));

          if( count($result) == 1 ){
            return $result[0];
          }else{
            return false;
          }
        }catch(PDOException $e) {
          write_log("EmisorPDO | get_prod_serv() | Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;
        }
      }

      public function get_prodserv($emisor, $id){
        $this->connect();
        try{
          $sql = "SELECT productos.Id, productos.Estatus, productos.SKU, productos.Nombre, productos.Precio,
          catsatclavesprodserv.Id as IdProdServ, catsatclavesprodserv.ClaveProdServ as ClaveProdServ, catsatclavesprodserv.Descripcion as DescClave,
          catsatunidades.Id as IdUnidad, catsatunidades.ClaveUnidad as ClaveUnidad, catsatunidades.NombreUnidad as NombreUnidad,
          catsatimpuestos.Id as IdImpuesto, catsatimpuestos.ClaveImpuesto, catsatimpuestos.Descripcion as DescImpuesto, catsatimpuestos.Tasa_Cuota
          FROM productos
          INNER JOIN catsatclavesprodserv ON productos.ClaveProdServ = catsatclavesprodserv.Id
          INNER JOIN catsatunidades ON productos.ClaveUnidad = catsatunidades.Id
          INNER JOIN catsatimpuestos ON productos.Impuesto = catsatimpuestos.Id
          WHERE productos.Id=$id AND productos.Emisor=$emisor";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("ProdServPDO | get_prod_serv() | SQL: " . $sql);
          write_log("ProdServPDO | get_prod_serv() | Result: ". serialize($result));

          if( count($result) == 1 ){
            return $result[0];
          }else{
            return false;
          }
        }catch(PDOException $e) {
          write_log("EmisorPDO | get_prod_serv() | Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;
        }
      }

      public function update_prodserv($id, $emisor, $sku, $nombre, $prodserv, $unidad, $precio, $impuesto){
        try{
          $this->connect();
          $sql = "UPDATE productos SET SKU = '$sku', Nombre = '$nombre', ClaveProdServ = '$prodserv',
          ClaveUnidad = '$unidad', Precio = '$precio', Impuesto = '$impuesto'
          WHERE Id = '$id' AND Emisor='$emisor'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          write_log("ProdServPDO | update_prodserv() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("ProdServPDO | update_prodserv() | Ocurrió un error al realizar el UPDATE del ProdServ\nError: ". $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
          return false;
        }
      }

      public function cambiar_activo($id, $emisor, $nuevo_status){
        try{
          $this->connect();
          $sql = "UPDATE productos
          SET Estatus='$nuevo_status'
          WHERE Id = $id AND Emisor=$emisor";
          write_log("ProdServPDO | cambiar_activo() | SQL: " . $sql);
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          if( $stmt->rowCount() == 1){
            write_log("ProdServPDO | cambiar_activo() | Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
            $this->disconect();
            return true;
          }else{
            write_log("ProdServPDO | cambiar_activo() | Se actualizaron mas de un registro");
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
