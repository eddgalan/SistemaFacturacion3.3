<?php
    Class ComprobantePDO extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $cliente_id;
      private $serie;
      private $folio;
      private $fecha;
      private $hora;
      private $moneda;
      private $tipo_cambio;
      private $tipo_comprobante;
      private $condiciones_pago;
      private $metodo_pago;
      private $forma_pago;
      private $uso_cfdi;
      private $lugar_expedicion;
      private $regimen;
      private $subtotal;
      private $iva;
      private $ieps;
      private $ret_iva;
      private $total_retenido;
      private $total_traslado;
      private $descuento;
      private $total;
      private $uuid;
      private $fecha_certificado;
      private $hora_certificado;
      private $estatus_sat;
      private $path_xml;
      private $path_pdf;
      private $observaciones;

      function __construct($emisor='', $cliente_id='', $serie='', $folio='', $fecha='', $hora='', $moneda='', $tipo_cambio='',
      $tipo_comprobante='', $condiciones_pago='', $metodo_pago='', $forma_pago='', $uso_cfdi='', $lugar_exp='',
      $regimen='', $subtotal='', $iva='', $ieps='', $descuento='', $total='', $prodservs='', $observaciones=''){
        parent::__construct();
        $this->emisor = $emisor;
        $this->cliente_id = $cliente_id;
        $this->serie = $serie;
        $this->folio = $folio;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->moneda = $moneda;
        $this->tipo_cambio = $tipo_cambio;
        $this->tipo_comprobante = $tipo_comprobante;
        $this->condiciones_pago = $condiciones_pago;
        $this->metodo_pago = $metodo_pago;
        $this->forma_pago = $forma_pago;
        $this->uso_cfdi = $uso_cfdi;
        $this->lugar_expedicion = $lugar_exp;
        $this->regimen = $regimen;
        $this->subtotal = $subtotal;
        $this->iva = $iva;
        $this->ieps = $ieps;
        $this->descuento = $descuento;
        $this->total = $total;
        $this->prodservs = $prodservs;
        $this->observaciones = $observaciones;
      }

      public function insert_comprobante($detalles){
        if( $this->cliente_id != "" ){
          $this->connect();
          try {
            $this->conn->beginTransaction();
            // SQL INSERT Comprobante
            $sql_insert_comprobante = "INSERT INTO cfdi (Emisor, ClienteId, Serie, Folio, Fecha, Hora, Moneda, TipoCambio,
            TipoComprobante, CondicionesPago, MetodoPago, FormaPago, UsoCFDI, LugarExpedicion, Subtotal, IVA, IEPS, Descuento,
            Total, Observaciones)
            VALUES ('$this->emisor', '$this->cliente_id', '$this->serie', '$this->folio',' $this->fecha', '$this->hora',
              '$this->moneda', '$this->tipo_cambio', '$this->tipo_comprobante', '$this->condiciones_pago',
              '$this->metodo_pago', '$this->forma_pago', '$this->uso_cfdi', '$this->lugar_expedicion', '$this->subtotal', '$this->iva',
              '$this->ieps', '$this->descuento', '$this->total', '$this->observaciones')";
            write_log("SQL INSERT CFDI: " . $sql_insert_comprobante);
            $this->conn->exec($sql_insert_comprobante);

            // Obtiene el Id del Nuevo Comprobante
            $sql_select_comprobante = "SELECT Id FROM cfdi WHERE Emisor='$this->emisor' ORDER BY Id DESC LIMIT 1";
            $stmt = $this->conn->prepare($sql_select_comprobante);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $id_comprobante = $result[0]['Id'];
            write_log("Id Nuevo CFDI: ". $id_comprobante);
            // Hace el INSERT de los Detalles
            foreach ($detalles as $prod_serv) {
              $id_prod_serv = $prod_serv['id'];
              $precio = round(floatval($prod_serv['precio']), 6);
              $cantidad = round(floatval($prod_serv['cantidad']), 6);
              $descuento = round(floatval($prod_serv['descuento']), 6);
              $importe = round(floatval($prod_serv['importe']), 6);
              $total_impuesto = round(floatval($prod_serv['impuesto_importe']), 6);
              $total = round(floatval($prod_serv['total']), 6);
              $sql_insert_detalles = "INSERT INTO detallecomprobante (Comprobante, Producto, PrecioUnitario, Cantidad, Descuento,
              Importe, Impuestos, Total)
              VALUES ('$id_comprobante', '$id_prod_serv', '$precio', '$cantidad', '$descuento', '$importe', '$total_impuesto', '$total')";
              write_log("SQL INSERT DETALLES: " . $sql_insert_detalles);
              $this->conn->exec($sql_insert_detalles);
              write_log("Se realizó un INSERT de Detalles");
            }
            // Actualiza el consecutivo de la serie

            $this->conn->commit();
            return true;
          } catch (Exception $e) {
              $this->conn->rollback();
              write_log("Ocurrió un ERROR: ". $e->getMessage());
              return false;
          }
        }
      }

      public function get_comprobantes(){
        // Obtiene el emisor
        $sesion = new UserSession();
        $data_session = $sesion->get_session();
        $emisor = $data_session['Emisor'];

        $this->connect();
        try{
          $sql = "SELECT cfdi.Id, cfdi.Estatus, cfdi.Serie, cfdi.Folio, cfdi.ClienteId, clientes.Nombre as NombreCliente, cfdi.UUID, cfdi.Total
          FROM cfdi
          INNER JOIN clientes ON cfdi.ClienteId = clientes.Id
          WHERE cfdi.Emisor='$emisor'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $this->disconect();
          write_log("ComprobantePDO | get_comprobantes() | CFDIs\n". serialize($result));
          write_log("SQL Comprobantes: ". $sql);
          return $result;
        }catch(PDOException $e){
          write_log("ComprobantePDO | get_comprobantes() | Ocurrió un error.\nError: " .$e->getMessage());
          write_log("SQL: " .$sql);
        }
      }

      public function get_comprobante(){
        $this->connect();
        try{
          $sql = "SELECT productos.Id as ProductoID, productos.SKU, productos.Nombre as ProductoNombre,
          productos.Precio as ProductoPrecio,
          catsatclavesprodserv.ClaveProdServ as ProductoClaveSAT,
          catsatunidades.ClaveUnidad as UnidadClave, catsatunidades.NombreUnidad as UnidadNombre,
          catsatimpuestos.ClaveImpuesto as ImpuestoClave, catsatimpuestos.Descripcion as ImpuestoDesc, catsatimpuestos.Tasa as ImpuestoTasa
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
