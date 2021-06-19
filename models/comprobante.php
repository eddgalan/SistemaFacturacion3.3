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
      $tipo_comprobante='', $condiciones_pago='', $nocertificado='', $metodo_pago='', $forma_pago='', $uso_cfdi='', $lugar_exp='',
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
        $this->nocertificado = $nocertificado;
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

      public function get_count($emisor){
        $this->connect();
        $sql = "SELECT Estatus, COUNT(Id) AS NoCFDIs
        FROM cfdi WHERE Emisor=$emisor
        GROUP BY Estatus";
        write_log("ComprobantePDO | get_count() | SQL: ". $sql);
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->disconect();
        write_log("ComprobantePDO | get_count() | Result: ". serialize($result));
        $cfdis_nuevos = 0;
        $cfdis_timbrados = 0;
        $cfdis_verificados = 0;
        $cfdis_cancel_sintimbrar = 0;
        $cfdis_cancel_timbrados = 0;
        // Obtiene los CFDIs Nuevos (Estatus = 0)
        foreach( $result as $row ){
          if( $row['Estatus']== 0 ){
            $cfdis_nuevos = $row['NoCFDIs'];
          }
        }
        // Obtiene los CFDIs Timbrados-NoVerificados (Estatus = 1)
        foreach( $result as $row ){
          if( $row['Estatus']== 1 ){
            $cfdis_timbrados = $row['NoCFDIs'];
          }
        }
        // Obtiene los CFDIs Nuevos (Estatus = 0)
        foreach( $result as $row ){
          if( $row['Estatus']== 2 ){
            $cfdis_verificados = $row['NoCFDIs'];
          }
        }
        // Obtiene los CFDIs Cancelados-SinTimbrar (Estatus = 3)
        foreach( $result as $row ){
          if( $row['Estatus']== 3 ){
            $cfdis_cancel_sintimbrar = $row['NoCFDIs'];
          }
        }
        // Obtiene los CFDIs Cancelados-DespuesDeTimbrar (Estatus = 4)
        foreach( $result as $row ){
          if( $row['Estatus']== 4 ){
            $cfdis_cancel_timbrados = $row['NoCFDIs'];
          }
        }
        return array(
          "CFDIsTotal" => intval($cfdis_nuevos) + intval($cfdis_timbrados) + intval($cfdis_verificados) +
          intval($cfdis_cancel_timbrados) + intval($cfdis_cancel_sintimbrar),
          "CFDIsNuevos" => $cfdis_nuevos,
          "CFDIsSinVerificar" => $cfdis_timbrados,
          "CFDIsVerificados" => $cfdis_verificados,
          "CFDIsCancelados" => intval($cfdis_cancel_timbrados) + intval($cfdis_cancel_sintimbrar)
        );
      }

      public function insert_comprobante($detalles){
        if( $this->cliente_id != "" ){
          $this->connect();
          try {
            $this->conn->beginTransaction();
            // SQL INSERT Comprobante
            $sql_insert_comprobante = "INSERT INTO cfdi (Emisor, ClienteId, Serie, Folio, Fecha, Hora, Moneda, TipoCambio,
            TipoComprobante, CondicionesPago, NoCertificado, MetodoPago, FormaPago, UsoCFDI, LugarExpedicion, Regimen, Subtotal, IVA, IEPS, Descuento,
            Total, Observaciones)
            VALUES ('$this->emisor', '$this->cliente_id', '$this->serie', '$this->folio',' $this->fecha', '$this->hora',
              '$this->moneda', '$this->tipo_cambio', '$this->tipo_comprobante', '$this->condiciones_pago', '$this->nocertificado',
              '$this->metodo_pago', '$this->forma_pago', '$this->uso_cfdi', '$this->lugar_expedicion', '$this->regimen', '$this->subtotal', '$this->iva',
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
              $sku = $prod_serv['sku'];
              $descripcion = $prod_serv['descripcion'];
              $precio = round(floatval($prod_serv['precio']), 6);
              $cantidad = round(floatval($prod_serv['cantidad']), 6);
              $unidad = $prod_serv['unidad_clave']. " | " .$prod_serv['unidad_nombre'];
              $descuento = round(floatval($prod_serv['descuento']), 6);
              $importe = round(floatval($prod_serv['importe']), 6);
              $total_impuesto = round(floatval($prod_serv['impuesto_importe']), 6);
              $tipo_impuesto = $prod_serv['impuesto_nombre'];
              $total = round(floatval($prod_serv['total']), 6);
              $sql_insert_detalles = "INSERT INTO detallecomprobante (Comprobante, Producto, SKU, Descripcion, PrecioUnitario,
                Cantidad, Unidad, Descuento, Importe, Impuestos, TipoImpuesto, Total)
              VALUES ('$id_comprobante', '$id_prod_serv', '$sku', '$descripcion', '$precio', '$cantidad', '$unidad',
                '$descuento', '$importe', '$total_impuesto', '$tipo_impuesto', '$total')";
              write_log("SQL INSERT DETALLES: " . $sql_insert_detalles);
              $this->conn->exec($sql_insert_detalles);
              write_log("Se realizó un INSERT de Detalles");
            }
            // Obtiene los impuestos trasladados
            $sql_select_imp = "SELECT ROUND(SUM(detallecomprobante.Impuestos),4) Importe,
            detallecomprobante.TipoImpuesto, catsatimpuestos.ClaveImpuesto,
            catsatimpuestos.Tasa_Cuota, catsatimpuestos.Factor
            FROM detallecomprobante
            INNER JOIN productos ON detallecomprobante.Producto = productos.Id
            INNER JOIN catsatclavesprodserv ON productos.ClaveProdServ = catsatclavesprodserv.Id
            INNER JOIN catsatimpuestos ON productos.Impuesto = catsatimpuestos.Id
            WHERE Comprobante='$id_comprobante'
            GROUP BY catsatimpuestos.Id";

            $stmt = $this->conn->prepare($sql_select_imp);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $impuestos_trasladados = $result;

            // Calcula el total de los impuestos trasladados
            $total_trasladado = 0;
            foreach($impuestos_trasladados as $impuesto){
              $total_trasladado += floatval($impuesto['Importe']);
            }

            // Actualiza los Impuestos Trasladados
            $sql_update = "UPDATE cfdi SET TotalTraslado='$total_trasladado' WHERE Id='$id_comprobante'";
            write_log("SQL UPDATE CFDI (Inserta Impuestos Trasladados): " .$sql_update);
            $this->conn->exec($sql_update);

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
          $sql = "SELECT cfdi.Id, cfdi.Estatus, cfdi.Serie, cfdi.Folio, cfdi.ClienteId, clientes.Nombre as NombreCliente,
          cfdi.Creado, cfdi.UUID, cfdi.Total
          FROM cfdi
          INNER JOIN clientes ON cfdi.ClienteId = clientes.Id
          WHERE cfdi.Emisor='$emisor'
          ORDER BY Id DESC";
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

      public function get_comprobante($id_comprobante, $emisor){
        $this->connect();
        try{
          $sql = "SELECT cfdi.Id as IdCFDI, cfdi.Estatus as EstatusCFDI, cfdi.Emisor as IdEmisor, emisores.Nombre as NombreEmisor, emisores.RFC as RFCEmisor,
          cfdi.ClienteId as IdReceptor, clientes.RFC as RFCReceptor, clientes.Nombre as NombreReceptor,
          cfdi.Serie, cfdi.Folio, cfdi.Fecha, cfdi.Hora, cfdi.Moneda, cfdi.TipoCambio, cfdi.TipoComprobante,
          series.DescripcionTipoComp as DescTipo,
          cfdi.CondicionesPago, cfdi.NoCertificado, cfdi.MetodoPago as ClaveMetodoPago,
          catsatmetodos.Descripcion as DescripcionMetodoPago, cfdi.FormaPago as ClaveFormaPago,
          catsatformaspago.Descripcion as DescripcionFormaPago, cfdi.UsoCFDI as ClaveUsoCFDI,
          cfdi.LugarExpedicion, cfdi.Regimen, emisores.DescRegimen, cfdi.Subtotal, cfdi.IVA, cfdi.IEPS, cfdi.RetIva, cfdi.TotalRetenido, cfdi.TotalTraslado,
          cfdi.Descuento, cfdi.Total, cfdi.UUID, cfdi.FechaCertificado, cfdi.HoraCertificado, cfdi.EstatusSAT,
          cfdi.PathXML, cfdi.PathPDF, cfdi.Creado, cfdi.Observaciones
          FROM cfdi
          INNER JOIN emisores ON cfdi.Emisor = emisores.Id
          INNER JOIN clientes ON cfdi.ClienteId = clientes.Id
          INNER JOIN catsatmetodos ON cfdi.MetodoPago = catsatmetodos.ClaveMetodo
          INNER JOIN catsatformaspago ON cfdi.FormaPago = catsatformaspago.ClaveFormaPago
          INNER JOIN series ON cfdi.TipoComprobante = series.TipoComprobante
          WHERE cfdi.Id='$id_comprobante'
          AND emisores.Id='$emisor'
          AND clientes.Emisor='$emisor'
          AND catsatmetodos.Emisor='$emisor'
          AND catsatformaspago.Emisor='$emisor'";

          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $this->disconect();

          write_log("ComprobantePDO | get_comprobante() | SQL\n" . $sql);

          if(count($result) > 0){
            write_log("ComprobantePDO | get_comprobante() | Información del comprobante\n " . serialize($result[0]));
            return $result[0];
          }else{
            write_log("ComprobantePDO | get_comprobante() | La consulta no trajo resultados.");
            return false;
          }

        }catch(PDOException $e) {
          write_log("Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          $this->disconect();
          return false;
        }
      }

      function get_detalles($id_comprobante){
        $this->connect();
        try{
          $sql = "SELECT detallecomprobante.SKU, detallecomprobante.Descripcion, detallecomprobante.Cantidad,
          detallecomprobante.Unidad, detallecomprobante.PrecioUnitario, detallecomprobante.Importe,
          detallecomprobante.Descuento, detallecomprobante.Impuestos, detallecomprobante.TipoImpuesto,
          detallecomprobante.Total,
          catsatclavesprodserv.ClaveProdServ,
          catsatimpuestos.ClaveImpuesto, catsatimpuestos.Tasa_Cuota, catsatimpuestos.Factor
          FROM detallecomprobante
          INNER JOIN productos ON detallecomprobante.Producto = productos.Id
          INNER JOIN catsatclavesprodserv ON productos.ClaveProdServ = catsatclavesprodserv.Id
          INNER JOIN catsatimpuestos ON productos.Impuesto = catsatimpuestos.Id
          WHERE detallecomprobante.Comprobante='$id_comprobante' AND catsatimpuestos.Traslado = 1";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $this->disconect();
          write_log("ComprobantePDO | get_detalles | SQL\n". $sql);
          write_log("ComprobantePDO | get_detalles | Detalles del comprobante\n " . serialize($result));
          return $result;
        }catch(PDOException $e) {
          write_log("Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          $this->disconect();
          return false;
        }
      }

      function get_impuestos_trasladados($id_comprobante){
        $this->connect();
        try{
          $sql = "SELECT ROUND(SUM(detallecomprobante.Impuestos),4) Importe,
          detallecomprobante.TipoImpuesto, catsatimpuestos.ClaveImpuesto,
          catsatimpuestos.Tasa_Cuota, catsatimpuestos.Factor
          FROM detallecomprobante
          INNER JOIN productos ON detallecomprobante.Producto = productos.Id
          INNER JOIN catsatclavesprodserv ON productos.ClaveProdServ = catsatclavesprodserv.Id
          INNER JOIN catsatimpuestos ON productos.Impuesto = catsatimpuestos.Id
          WHERE Comprobante='$id_comprobante'
          GROUP BY catsatimpuestos.Id";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $this->disconect();
          write_log("ComprobantePDO | get_impuestos | SQL\n". $sql);
          write_log("ComprobantePDO | get_impuestos | Impuestos del comprobante\n " . serialize($result));
          return $result;
        }catch(PDOException $e){
          write_log("Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          $this->disconect();
          return false;
        }
      }

      function create_xml($id, $emisor, $certificado='', $nocertificado=''){
        try{
          // Obtiene la información del comprobante
          $comprobante = $this->get_comprobante($id, $emisor);
          // Obtiene los items (Productos/Servicios)
          $detalles = $this->get_detalles($id);
          // Obtiene los impuestos ( cfdi:Impuestos )
          $impuestos_trasladados = $this->get_impuestos_trasladados($id);

          /* ..:: Comienza a Escribir el XML ::.. */
          $xmlWriter = new XMLWriter();
      		$xmlWriter->openMemory();
      		$xmlWriter->startDocument('1.0', 'UTF-8');
      		// Nodo principal: Comprobante
      		$xmlWriter->startElement('cfdi:Comprobante');
      		// Encabezados del CFDI:
          $xmlWriter->startAttribute('xmlns:xsi');
      			$xmlWriter->text( "http://www.w3.org/2001/XMLSchema-instance" );
      		$xmlWriter->endAttribute();
      		$xmlWriter->startAttribute('xmlns:cfdi');
      			$xmlWriter->text( "http://www.sat.gob.mx/cfd/3" );
      		$xmlWriter->endAttribute();
      		$xmlWriter->startAttribute('xsi:schemaLocation');
      			$xmlWriter->text( "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd" );
      		$xmlWriter->endAttribute();
          // Lugar Expedición
          $xmlWriter->startAttribute('LugarExpedicion');
      			$xmlWriter->text( $comprobante['LugarExpedicion'] );
      		$xmlWriter->endAttribute();
          // Si es Traslado o Pago se omite el Metodo de Pago
          if($comprobante['TipoComprobante'] != 'T' && $comprobante['TipoComprobante'] != 'P'){
            $xmlWriter->startAttribute('MetodoPago');
      				$xmlWriter->text( $comprobante["ClaveMetodoPago"] );
      			$xmlWriter->endAttribute();
          }
          // Tipo Comprobante
          $xmlWriter->startAttribute('TipoDeComprobante');
      			$xmlWriter->text( $comprobante["TipoComprobante"] );
      		$xmlWriter->endAttribute();
          // Descuento
          if( $comprobante["Descuento"] > 0 ){
      			$xmlWriter->startAttribute('Descuento');
      				$xmlWriter->text( number_format( $comprobante["Descuento"],2,".","" ) );
      			$xmlWriter->endAttribute();
      		}
          // Subtotal
          if( $comprobante["Subtotal"] > 0 ){
        		$xmlWriter->startAttribute('SubTotal');
        			$xmlWriter->text( number_format( $comprobante["Subtotal"],2,".","" ) );
        		$xmlWriter->endAttribute();
        	}
          // Total
          $xmlWriter->startAttribute('Total');
      			$xmlWriter->text( number_format( $comprobante["Total"],2,".","" ) );
      		$xmlWriter->endAttribute();
      		// Moneda
      		$xmlWriter->startAttribute('Moneda');
      			$xmlWriter->text( $comprobante["Moneda"] );
      		$xmlWriter->endAttribute();
          // Tipo de Cambio
          if( floatval($comprobante['TipoCambio']) > 1 ){
      			$xmlWriter->startAttribute('TipoCambio');
      				$xmlWriter->text( $comprobante['TipoCambio'] );
      			$xmlWriter->endAttribute();
      		}
          // Certificado
          if( $certificado != "" ){
      			$xmlWriter->startAttribute('Certificado');
      				$xmlWriter->text( $certificado );
      			$xmlWriter->endAttribute();
      		}
          // Condiciones de Pago
          if( $comprobante["CondicionesPago"] != "" ){
      			$xmlWriter->startAttribute('CondicionesDePago');
      				$xmlWriter->text( $comprobante["CondicionesPago"] );
      			$xmlWriter->endAttribute();
      		}
          // NoCertificado
          $xmlWriter->startAttribute('NoCertificado');
      			$xmlWriter->text( $nocertificado );
      		$xmlWriter->endAttribute();
          // Forma de Pago | Si es Traslado / Pago se omite la forma Pago
          if( $comprobante['TipoComprobante'] != "T" && $comprobante['TipoComprobante'] != "P" ){
            $xmlWriter->startAttribute('FormaPago');
      				$xmlWriter->text( $comprobante['ClaveFormaPago'] );
      			$xmlWriter->endAttribute();
      		}
          // Fecha
          $xmlWriter->startAttribute('Fecha');
      			$xmlWriter->text( $comprobante['Fecha']. "T". $comprobante['Hora'] );
      		$xmlWriter->endAttribute();
          // Serie
      		$xmlWriter->startAttribute('Serie');
      			$xmlWriter->text($comprobante['Serie'] );
      		$xmlWriter->endAttribute();
          // Folio
      		$xmlWriter->startAttribute('Folio');
      			$xmlWriter->text( $comprobante['Folio'] );
      		$xmlWriter->endAttribute();
          // Version
      		$xmlWriter->startAttribute('Version');
      			$xmlWriter->text( "3.3" );
      		$xmlWriter->endAttribute();
          /* :: Poner CFDIs Relacionados :: */

          /* :: Emisor :: */
      		$xmlWriter->text( "\n\t" );
      		$xmlWriter->startElement('cfdi:Emisor');
      			// Atributos:
      			$xmlWriter->startAttribute('Rfc');
      				$xmlWriter->text( $comprobante['RFCEmisor'] );
      			$xmlWriter->endAttribute();
      			$xmlWriter->startAttribute('Nombre');
      				$xmlWriter->text( $comprobante['NombreEmisor'] );
      			$xmlWriter->endAttribute();
      			$xmlWriter->startAttribute('RegimenFiscal');
      				$xmlWriter->text( $comprobante['Regimen'] );
      			$xmlWriter->endAttribute();
      		$xmlWriter->endElement();
          /* :: Receptor :: */
          $xmlWriter->text( "\n\t" );
      		$xmlWriter->startElement('cfdi:Receptor');
      			// Atributos:
      			$xmlWriter->startAttribute('Rfc');
      				$xmlWriter->text( $comprobante['RFCReceptor'] );
      			$xmlWriter->endAttribute();
      			if( $comprobante['NombreReceptor'] != "" ){
      			$xmlWriter->startAttribute('Nombre');
      				$xmlWriter->text( $comprobante['NombreReceptor'] );
      			$xmlWriter->endAttribute();
      			}
      			$xmlWriter->startAttribute('UsoCFDI');
      				$xmlWriter->text( $comprobante['ClaveUsoCFDI'] );
      			$xmlWriter->endAttribute();
      		$xmlWriter->endElement();

          /* :: Conceptos :: */
          $xmlWriter->text( "\n\t" );
      		$xmlWriter->startElement('cfdi:Conceptos');
      		foreach( $detalles as $producto ){
      			if( empty($producto["Descripcion"]) ) continue; // Concepto vacio, saltar
      			$xmlWriter->text( "\n\t\t" );
      			$xmlWriter->startElement('cfdi:Concepto');
      				// Atributos:
      				$xmlWriter->startAttribute('ClaveProdServ');
      					$xmlWriter->text( $producto["ClaveProdServ"] );
      				$xmlWriter->endAttribute();

      				if( $comprobante['TipoComprobante'] == "P" ||  $comprobante['TipoComprobante'] == "N" ){
      					$producto["Cantidad"] = number_format( $producto["Cantidad"],0,".","" );
      				}else{
      					$xmlWriter->startAttribute('NoIdentificacion');
      						$xmlWriter->text( $producto["SKU"] );
      					$xmlWriter->endAttribute();
      				}

      				$xmlWriter->startAttribute('Cantidad');
      					$xmlWriter->text( $producto["Cantidad"] );
      				$xmlWriter->endAttribute();

      				$xmlWriter->startAttribute('ClaveUnidad');
      					$xmlWriter->text( substr($producto["Unidad"], 0, 3) );
      				$xmlWriter->endAttribute();

      				if( $comprobante['TipoComprobante'] != "P" &&  $comprobante['TipoComprobante'] != "N" ){
                $xmlWriter->startAttribute('Unidad');
                $xmlWriter->text( substr($producto["Unidad"], 6, strlen($producto["Unidad"])) );
                $xmlWriter->endAttribute();
      				}

      				$xmlWriter->startAttribute('Descripcion');
      					$xmlWriter->text( $producto["Descripcion"] );
      				$xmlWriter->endAttribute();

      				$xmlWriter->startAttribute('ValorUnitario');
      					if( $comprobante['TipoComprobante'] == "P" ){
      						$xmlWriter->text( "0" );
      					}else{
      						$xmlWriter->text( number_format( $producto["PrecioUnitario"],4,".","" ) );
      					}
      				$xmlWriter->endAttribute();

      				$xmlWriter->startAttribute('Importe');
      				if($comprobante['TipoComprobante'] == "P" ){
      					$xmlWriter->text( "0" );
      				}else{
      					$xmlWriter->text( number_format( $producto["Importe"],2,".","" ) );
      				}
      				$xmlWriter->endAttribute();

      				if( $producto["Descuento"] > 0 ){
      					$xmlWriter->startAttribute('Descuento');
      						$xmlWriter->text( number_format( $producto["Descuento"],2,".","" ) );
      					$xmlWriter->endAttribute();
      				}
      				// Impuestos:
      				if( $producto["ClaveImpuesto"] != "" ){
      					$xmlWriter->text( "\n\t\t\t" );
      					$xmlWriter->startElement('cfdi:Impuestos');
      					// Traslados:
      					if( $producto["ClaveImpuesto"] == "002" || $producto["ClaveImpuesto"] == "003"){
      						$xmlWriter->text( "\n\t\t\t\t" );
      						$xmlWriter->startElement('cfdi:Traslados');
      							// Detalle del Traslado:
      							$xmlWriter->text( "\n\t\t\t\t\t" );
      							$xmlWriter->startElement('cfdi:Traslado');
      								// Atributos:
      								$xmlWriter->startAttribute('Base');
      									$xmlWriter->text( number_format( $producto["Importe"],2,".","" ) );
      								$xmlWriter->endAttribute();

      								$xmlWriter->startAttribute('Impuesto');
      									$xmlWriter->text( $producto["ClaveImpuesto"] );
      								$xmlWriter->endAttribute();
      								$xmlWriter->startAttribute('TipoFactor');
      									$xmlWriter->text( $producto["Factor"] );
      								$xmlWriter->endAttribute();
      								$xmlWriter->startAttribute('TasaOCuota');
      									$xmlWriter->text( number_format( $producto["Tasa_Cuota"],6,".","") );
      								$xmlWriter->endAttribute();
      								$xmlWriter->startAttribute('Importe');
      									$xmlWriter->text( $producto["Impuestos"] );
      								$xmlWriter->endAttribute();
      							$xmlWriter->endElement();

      						$xmlWriter->text( "\n\t\t\t\t" );
      						$xmlWriter->endElement();
      					}
      					$xmlWriter->text( "\n\t\t\t" );
      					$xmlWriter->endElement();
      				}
      			$xmlWriter->text( "\n\t\t" );
      			$xmlWriter->endElement();
      		}
          $xmlWriter->text( "\n\t" );
          $xmlWriter->endElement();

          // Impuestos Totales:
      		if( $comprobante['TotalRetenido'] > 0 || $comprobante['TotalTraslado'] > 0 ){
      			$xmlWriter->text( "\n\t" );
      			$xmlWriter->startElement('cfdi:Impuestos');

      			// Atributos:
      			if( $comprobante['TotalTraslado'] > 0 ){
      			  $xmlWriter->startAttribute('TotalImpuestosTrasladados');
      				  $xmlWriter->text( number_format( $comprobante['TotalTraslado'],2,".","" ) );
      			  $xmlWriter->endAttribute();
      			}
      			if( $comprobante['TotalRetenido'] > 0 ){
      				$xmlWriter->startAttribute('TotalImpuestosRetenidos');
      					$xmlWriter->text( number_format( $comprobante['TotalRetenido'],2,".","" ) );
      				$xmlWriter->endAttribute();
      			}

      			// Retenciones:
      			// Traslados:
      			if( $comprobante["TotalTraslado"] > 0 || count( $impuestos_trasladados) > 0 ){
      				$xmlWriter->text( "\n\t\t" );
      				$xmlWriter->startElement('cfdi:Traslados');
      				foreach( $impuestos_trasladados as $indice => $valor ){
      					$xmlWriter->text( "\n\t\t\t" );
      					$xmlWriter->startElement('cfdi:Traslado');
      						// Atributos:
      						$xmlWriter->startAttribute('Impuesto');
      							$xmlWriter->text( $valor["ClaveImpuesto"] );
      						$xmlWriter->endAttribute();

      						$xmlWriter->startAttribute('TipoFactor');
      							$xmlWriter->text( $valor["Factor"] );
      						$xmlWriter->endAttribute();

      						$xmlWriter->startAttribute('TasaOCuota');
      							$xmlWriter->text( number_format($valor["Tasa_Cuota"], 6, ".", "") );
      						$xmlWriter->endAttribute();

      						$xmlWriter->startAttribute('Importe');
      							$xmlWriter->text( number_format( $valor["Importe"],2,".","" ) );
      						$xmlWriter->endAttribute();

      					$xmlWriter->endAttribute();
      					$xmlWriter->endElement();
      				}
      			  $xmlWriter->text( "\n\t\t" );
      			  $xmlWriter->endElement();
      			}

      			$xmlWriter->text( "\n\t" );
      			$xmlWriter->endElement();
      		}

      		$xmlWriter->text( "\n" );
      		$xmlWriter->endElement(); // Fin del elemento <cfdi:Comprobante
      		$xmlWriter->endDocument();

          // Path donde se guardará el XML
          $path_xml = "./comprobantes/" . $comprobante['RFCEmisor'] . "/". $comprobante['Serie'] . "/" . $comprobante['Folio'];
          // Valida si el directorio 'comprobantes'
          if(!is_dir("comprobantes")){
            mkdir("comprobantes", 0777); // or die('ERROR!');     // Crea el directorio 'Comprobantes' (si no existe)
          }
          if(!is_dir("comprobantes/". $comprobante['RFCEmisor'])) {
            mkdir("comprobantes/". $comprobante['RFCEmisor']); // or die("Error al crear directorio Emisor");
          }
          if(!is_dir("comprobantes/". $comprobante['RFCEmisor'] . "/" . $comprobante['Serie'])){
            mkdir("comprobantes/". $comprobante['RFCEmisor'] . "/" . $comprobante['Serie']); // or die("Error al crear directorio Serie");
          }
          if(!is_dir("comprobantes/". $comprobante['RFCEmisor'] . "/" . $comprobante['Serie'] . "/" . $comprobante['Folio'])){
            mkdir("comprobantes/". $comprobante['RFCEmisor'] . "/" . $comprobante['Serie'] . "/" . $comprobante['Folio']); // or die("Error al crear directorio Serie");
          }
          $file =  $path_xml . "/" . $id . ".xml";
          // Si ya existe el archivo lo elimina
          if(file_exists($file)){
            unlink($file);
          }
          file_put_contents( $file, $xmlWriter->flush(true), FILE_APPEND );
          return $file;
        }catch(Exception $e){
          write_log("ComprobantePDO | create_xml() | Error al crear XML\n " . $e->getMessage());
          return false;
        }
      }

      public function timbrar($id_comprobante, $file, $pac, $test){
        // Verifica si está en modo TEST
        if($test == 1){
          $pac_url = $pac['EndPoint_Pruebas'];
        }else{
          $pac_url = $pac['EndPoint'];
        }
      	$pac_nomcor = $pac['NombreCorto'];
        $pac_usr = $pac['UsrPAC'];
        $pac_pass = $pac['PassPAC'];

        $file_str = file_get_contents( $file );
        write_log("File String: ".$file_str);
        // Encripta la cadena
      	$base64Comprobante = base64_encode($file_str);
      	$response = '';
      	try {
      		$params = array();
      		$params['xmlComprobanteBase64'] = $base64Comprobante;
      		$params['usuarioIntegrador'] = $pac_usr;
      		$params['idComprobante'] = $id_comprobante;
      		$context = stream_context_create(array(
      			'ssl' => array(
      				'verify_peer' => false,
      				'verify_peer_name' => false,
      				'allow_self_signed' => true
      			),
      			'http' => array(
      				'user_agent' => 'PHPSoapClient'
      			)
      		));
      		$options = array();
      		$options['stream_context'] = $context;
      		$options['cache_wsdl'] = WSDL_CACHE_MEMORY;
      		$options['trace'] = true;
      		libxml_disable_entity_loader(false);
      		$client = new \SoapClient($pac_url, $options);
      		$response = $client->__soapCall('TimbraCFDI', array('parameters' => $params));
      	}catch (SoapFault $fault) {
          write_log("ComprobantePDO | timbrar() | Ocurrió un error al Timbrar el comprobante\nError: ". $fault->faultcode . " - " . $fault->faultstring);
      	}
      	if($response->TimbraCFDIResult->anyType[4] == NULL){
      		write_log("ComprobantePDO | timbrar() | Ocurrió un error al Timbrar el comprobante\nError: ". trim( $response->TimbraCFDIResult->anyType[2] ) );
      		write_log("ComprobantePDO | timbrar() | Response: \n". print_r($response));
          return false;
      	}
      	// Obtenemos resultado del response
      	$tipoExcepcion = $response->TimbraCFDIResult->anyType[0];
      	$numeroExcepcion = $response->TimbraCFDIResult->anyType[1];
      	$descripcionResultado = $response->TimbraCFDIResult->anyType[2];
      	$xmlTimbrado = $response->TimbraCFDIResult->anyType[3];
      	$codigoQr = $response->TimbraCFDIResult->anyType[4];
      	$cadenaOriginal = $response->TimbraCFDIResult->anyType[5];
      	$errorInterno = $response->TimbraCFDIResult->anyType[6];
      	$mensajeInterno = $response->TimbraCFDIResult->anyType[7];
      	$m_uuid = $response->TimbraCFDIResult->anyType[8];
      	$m_uuid2 = json_decode( $m_uuid );

      	if($xmlTimbrado != ''){
          // El comprobante fue timbrado correctamente
      		if( !file_put_contents( $file, $xmlTimbrado) ){
            write_log("Error al crear el archivo XML (". $file .")");
      		}
      	}else{
      		echo "<p> Error: [".$tipoExcepcion."  ".$numeroExcepcion." ".$descripcionResultado."  ei=".$errorInterno." mi=".$mensajeInterno."] </p>";
          write_log("ComprobantePDO | timbrar() | Error al timbrar el comprobante\n: ".
          "Tipo Excepcion: ". $tipoExcepcion . "\n".
          "Numero Excepcion: ". $numeroExcepcion ."\n".
          "Descripción Resultado: ". $descripcionResultado . "\n".
          "Error Interno: ". $errorInterno ."\n".
          "Mensaje Interno: ". $mensajeInterno);
      	}
      	// Terminó de Certificar (Timbrar)
      	// Leer el XML y actualizar la tabla cfdi:
      	$archivo_xml = trim(file_get_contents( $file ));
      	// Convertir a Matriz:
      	$p = xml_parser_create();
      	xml_parse_into_struct($p, $archivo_xml, $vals, $index);
      	xml_parser_free($p);
      	error_reporting( 1 );
      	$cfdiuuid = "";
      	$cfditimbver = "";
      	$cfditimbfecha = "";
      	$cfdicerfec = "0001-01-01";
      	$cfdicerhor = "00:00:00";
      	$factimbnocer = "";
      	$factimbsello = "";
      	$cfdisatsta = "Vigente";
      	$facsello = "";
      	$facsatrfc = "";
      	$cfdixml = $file;
      	foreach( $vals as $valor ){
      		$tag = 	trim( $valor[ "tag" ] );
      		if( $tag == 'TFD:TIMBREFISCALDIGITAL' ){
      			$cfdiuuid 		= trim( $valor[ "attributes" ][ "UUID" ] );
      			$cfditimbfecha 	= trim( $valor[ "attributes" ][ "FECHATIMBRADO" ] );
      			$cfditimbver		= trim( $valor[ "attributes" ][ "VERSION" ] );
      			$cfditimbnocer 	= trim( $valor[ "attributes" ][ "NOCERTIFICADOSAT" ] );
      			$cfdisello 		= trim( $valor[ "attributes" ][ "SELLOCFD" ] );
      			$cfditimbsello 	= trim( $valor[ "attributes" ][ "SELLOSAT" ] );
      			$cfdisatrfc 		= trim( $valor[ "attributes" ][ "RFCPROVCERTIF" ] );
      		}
      	}
      	// Obtiene los datos para actualizar el CFDI
      	if( strlen($cfditimbfecha) == 19 ){
      		$m_factimbfecha = explode( "T",$cfditimbfecha );
      		$cfdicerfec = $m_factimbfecha[ 0 ];
      		$cfdicerhor = $m_factimbfecha[ 1 ];
      	}

        $path_pdf = str_replace(".xml", ".pdf", $file);
        /* Hace el UPDATE del CFDI */
        $this->connect();       // Conecta a la base de datos
        $sql = "UPDATE cfdi SET UUID='$cfdiuuid', FechaCertificado='$cfdicerfec', HoraCertificado='$cfdicerhor',
                  PathXML='$file', PathPDF='$path_pdf', Estatus=1
                  WHERE Id = '$id_comprobante'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa en la Tabla CFDI.");
        $this->disconect();
        return true;
      }

      public function create_pdf($id_comprobante, $file, $emisor){
        // Obtiene la información del comprobante
        $comprobante = $this->get_comprobante($id_comprobante, $emisor['Id']);
        // Obtiene los items (Productos/Servicios)
        $detalles = $this->get_detalles($id_comprobante);
        // Crear PDF ()
        require './libs/tcpdf.php';
        $pdf = new MYPDF( 'P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(5 , 5, 5);
        $pdf->SetHeaderMargin( PDF_MARGIN_HEADER );
        $pdf->SetFooterMargin( PDF_MARGIN_FOOTER );
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('helvetica', 'BI', 12);
        // Escribe el documento PDF
        if( $pdf->imprimir($comprobante, $detalles, $emisor['PathLogo'], $file) ){
          $file_pdf = str_replace(".xml", ".pdf", $file);
          if( file_exists( $file_pdf ) ){   // Si existe el archivo PDF
        		unlink( $file_pdf );            // Lo Elimina para crear otro
        	}
          $pdf->Output( $file_pdf, 'F');    // Crea(Guarda) el archivo .PDF
          write_log("ComprobantePDO | create_pdf() | Se creó el archivo PDF correctamente");
          return true;
        }else{
          write_log("ComprobantePDO | create_pdf() | Ocurrió un error al escribir el Archivo PDF.");
          return false;
        }
      }

      public function verify_sat($rfc_emisor, $rfc_receptor, $total, $uuid){
        $soap = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/"><soapenv:Header/><soapenv:Body><tem:Consulta><tem:expresionImpresa>?re='.$rfc_emisor.'&amp;rr='.$rfc_receptor.'&amp;tt='.$total.'&amp;id='.$uuid.'</tem:expresionImpresa></tem:Consulta></soapenv:Body></soapenv:Envelope>';
        $headers = [
           'Content-Type: text/xml;charset=utf-8',
           'SOAPAction: http://tempuri.org/IConsultaCFDIService/Consulta',
           'Content-length: '.strlen($soap)
        ];
        $url = 'https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $soap);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $res = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($res);
        $data_status = $xml->children('s', true)->children('', true)->children('', true);
        $data_status = json_encode($data_status->children('a', true), JSON_UNESCAPED_UNICODE);
        $data = array();

        foreach( json_decode($data_status) as $item ){
          array_push($data, $item);
        }

        if( $data[2] == "No Encontrado" ){
          echo "No encontrado";
          return false;
        }else{
          echo "Encontrado";
          return array(
            "CodigoEstatus" => $data[0],
            "EsCancelable" => $data[1],
            "Estado" => $data[2],
            "EstatusCancelacion" => $data[3],
            "ValidacionEFOS" => $data[4]
          );
        }
      }

      public function update_status_sat($id, $estatus){
        $this->connect();
        try{
          $sql = "UPDATE cfdi SET EstatusSAT='$estatus'
                  WHERE Id = '$id'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          write_log("ComprobantePDO | update_status_sat() | Se actualizaron: " . $stmt->rowCount() .
          " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("ComprobantePDO | update_status_sat() | Ocurrió un error al realizar el UPDATE del CFDI\nError: ".
          $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
          return false;
        }
      }

      public function cancel_cfdi($comprobante, $pac, $test){
        if($test == 1){
          $pacurl = $pac['EndPoint_Pruebas'];
        }else{
          $pacurl = $pac['EndPoint'];
        }
        $pacusu = $pac['UsrPAC'];
        $rfcEmisor = $comprobante['RFCEmisor'];
        $uuid = $comprobante['UUID'];
        try{
        	$params = [
        		"usuarioIntegrador" => $pacusu,
        		"rfcEmisor" => $rfcEmisor,
        		"folioUUID" => $uuid,
        	];
        	$context = stream_context_create(
        		array(
        			'ssl' => array(
        				// set some SSL/TLS specific options
        				'verify_peer' => false,
        				'verify_peer_name' => false,
        				'allow_self_signed' => true  //--> solamente true en ambiente de pruebas
        			),
        			'http' => array(
        				'user_agent' => 'PHPSoapClient'
        			)
        		)
        	);
        	$options =array();
        	$options['stream_context'] = $context;
        	$options['trace']= true;
        	$client = new SoapClient($pacurl,$options);
        	$response = $client->__soapCall('CancelaCFDI', array('parameters' => $params));
          write_log(serialize($response));
          if( strpos(serialize($response), "El comprobante será cancelado") ){
            /* Actualiza el estatus del CFDI en la BD*/
            if( $this->update_to_cancel($comprobante['IdCFDI'], $comprobante['EstatusCFDI']) ){
              return true;
            }else{
              return false;
            }
          }else{
            write_log("ComprobantePDO | cancel_cfdi() | No fue posible cancelar el comprobante");
            return false;
          }
          return true;
        }catch (SoapFault $fault){
        	echo "SOAPFault: ".$fault->faultcode."-".$fault->faultstring."\n";
          write_log("ComprobantePDO | cancel_cfdi() | Ocurrió un error al cancelar el CFDI\n".
          "Error: ". $fault->faultcode."-".$fault->faultstring);
        	return false;
        }
        echo "<br> Respuesta: <pre>"; print_r( $response ); echo "</pre><hr>"; exit;
      }

      public function update_to_cancel( $id_comprobante, $estatus ){
        if($estatus == 0){
          // Comprobante Nuevo | Debe actualizar a 4
          $nuevo_status = 3;
          write_log("Actualizar a Cancelado (4) el comprobante Nuevo (0)");
        }elseif($estatus == 1 || $estatus == 2) {
          // El comprobante está Timbrado o Verificado | Debe actualizar a 3
          $nuevo_status = 4;
          write_log("Actualizar a Cancelado (3) el comprobante Timbrado (1 o 2)");
        }

        try{
          $this->connect();
          $sql = "UPDATE cfdi SET Estatus=$nuevo_status
                  WHERE Id = '$id_comprobante'";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();

          write_log("ComprobantePDO | update_to_cancel() | Se actualizaron: " . $stmt->rowCount() .
          " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("ComprobantePDO | update_to_cancel() | Ocurrió un error al realizar el UPDATE del CFDI\nError: ".
          $e->getMessage());
          write_log("SQL: ". $sql);
          $this->disconect();
          return false;
        }
      }

      public function number_to_monthname($number){
        $mes = "";
        switch($number) {
          case '1':
            $mes = "Enero"; break;
          case '2':
            $mes = "Febrero"; break;
          case '3':
            $mes = "Marzo"; break;
          case '4':
            $mes = "Abril"; break;
          case '5':
            $mes = "Mayo"; break;
          case '6':
            $mes = "Junio"; break;
          case '7':
            $mes = "Julio"; break;
          case '8':
            $mes = "Agosto"; break;
          case '9':
            $mes = "Septiembre"; break;
          case '10':
            $mes = "Octubre"; break;
          case '11':
            $mes = "Noviembre"; break;
          case '12':
            $mes = "Diciembre"; break;
        }
        return $mes;
      }

      public function get_comprobantes_by_month($emisor){
        $this->connect();
        try{
          // Comprobantes Por Mes
          $sql = "SELECT MONTH(Fecha) AS Mes, COUNT(Id) AS NoCFDIs
          FROM cfdi
          WHERE YEAR(Fecha) = YEAR(CURDATE()) AND Emisor=$emisor AND Estatus IN(0,1,2)
          GROUP BY Mes";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $this->disconect();
          write_log("ComprobantePDO | get_comprobantes_by_month() | SQL: ". $sql);
          write_log("ComprobantePDO | get_comprobantes_by_month() | Result\n". serialize($result));
          $meses = []; $no_cfdis=[];
          foreach($result as $row){
            array_push($meses, $this->number_to_monthname($row['Mes']));
            array_push($no_cfdis, $row['NoCFDIs']);
          }
          return array($meses, $no_cfdis);
        }catch(PDOException $e){
          write_log("ComprobantePDO | get_data_to_dashboard() | Ocurrió un error.\nError: " .$e->getMessage());
          write_log("SQL: " .$sql);
        }
      }
    }
?>
