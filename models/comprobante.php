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
            TipoComprobante, CondicionesPago, MetodoPago, FormaPago, UsoCFDI, LugarExpedicion, Regimen, Subtotal, IVA, IEPS, Descuento,
            Total, Observaciones)
            VALUES ('$this->emisor', '$this->cliente_id', '$this->serie', '$this->folio',' $this->fecha', '$this->hora',
              '$this->moneda', '$this->tipo_cambio', '$this->tipo_comprobante', '$this->condiciones_pago',
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

      public function get_comprobante($id_comprobante, $emisor){
        $this->connect();
        try{
          $sql = "SELECT cfdi.Id as IdCFDI, cfdi.Estatus as EstatusCFDI, cfdi.Emisor as IdEmisor, emisores.Nombre as NombreEmisor, emisores.RFC as RFCEmisor,
          cfdi.ClienteId as IdReceptor, clientes.RFC as RFCReceptor, clientes.Nombre as NombreReceptor,
          cfdi.Serie, cfdi.Folio, cfdi.Fecha, cfdi.Hora, cfdi.Moneda, cfdi.TipoCambio, cfdi.TipoComprobante,
          cfdi.CondicionesPago, cfdi.NoCertificado, cfdi.MetodoPago as ClaveMetodoPago,
          catsatmetodos.Descripcion as DescripcionMetodoPago, cfdi.FormaPago as ClaveFormaPago,
          catsatformaspago.Descripcion as DescripcionFormaPago, cfdi.UsoCFDI as ClaveUsoCFDI, catsatusocfdi.Concepto as ConceptoUsoCFDI,
          cfdi.LugarExpedicion, cfdi.Regimen, cfdi.Subtotal, cfdi.IVA, cfdi.IEPS, cfdi.RetIva, cfdi.TotalRetenido, cfdi.TotalTraslado,
          cfdi.Descuento, cfdi.Total, cfdi.UUID, cfdi.FechaCertificado, cfdi.FechaCertificado, cfdi.HoraCertificado, cfdi.EstatusSAT,
          cfdi.PathXML, cfdi.PathPDF, cfdi.Observaciones
          FROM cfdi
          INNER JOIN emisores ON cfdi.Emisor = emisores.Id
          INNER JOIN clientes ON cfdi.ClienteId = clientes.Id
          INNER JOIN catsatmetodos ON cfdi.MetodoPago = catsatmetodos.ClaveMetodo
          INNER JOIN catsatformaspago ON cfdi.FormaPago = catsatformaspago.ClaveFormaPago
          INNER JOIN catsatusocfdi ON cfdi.UsoCFDI = catsatusocfdi.ClaveUso
          WHERE cfdi.Id='$id_comprobante'
          AND emisores.Id='$emisor'
          AND clientes.Emisor='$emisor'
          AND catsatmetodos.Emisor='$emisor'
          AND catsatformaspago.Emisor='$emisor'
          AND catsatusocfdi.Emisor='$emisor'";

          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $this->disconect();

          write_log($sql);
          write_log("ComprobantePDO | get_comprobante | Información del comprobante\n " . serialize($result[0]));
          return $result[0];
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
    			$xmlWriter->startAttribute('TipoCambio');
    				$xmlWriter->text( $comprobante["TipoCambio"] );
    			$xmlWriter->endAttribute();
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
      					$xmlWriter->text( number_format( $producto["Cantidad"],4,".","" ));
      				$xmlWriter->endAttribute();

      				$xmlWriter->startAttribute('ClaveUnidad');
      					$xmlWriter->text( substr($producto["Unidad"], 0, 2) );
      				$xmlWriter->endAttribute();

      				if( $comprobante['TipoComprobante'] != "P" || $comprobante['TipoComprobante'] != "N" ){
                $xmlWriter->startAttribute('Unidad');
      						$xmlWriter->text( substr($producto['Unidad'], 6, strlen($producto['Unidad'])) );
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
      				if( $comprobante['TipoComprobante'] == "P" ){
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
      					if( $producto["ClaveImpuesto"] == "002" ){
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
      									$xmlWriter->text( number_format($producto["Tasa_Cuota"],6,".","") );
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
      		if( floatval($comprobante['TotalRetenido']) > 0 || floatval($comprobante['TotalTraslado']) > 0 ){
      			$xmlWriter->text( "\n\t" );
      			$xmlWriter->startElement('cfdi:Impuestos');
      			// Atributos:
      			if( floatval($comprobante['TotalTraslado']) > 0 ){
      			  $xmlWriter->startAttribute('TotalImpuestosTrasladados');
      				  $xmlWriter->text( number_format( $comprobante['TotalTraslado'],2,".","" ) );
      			  $xmlWriter->endAttribute();
      			}
      			if( floatval($comprobante['TotalRetenido']) > 0 ){
      				$xmlWriter->startAttribute('TotalImpuestosRetenidos');
      					$xmlWriter->text( number_format( $comprobante['TotalRetenido'],2,".","" ) );
      				$xmlWriter->endAttribute();
      			}
      			// Retenciones:
      			// Traslados:
      			// if( $this->m_info["m_impuestos"]["TotalImpuestosTrasladados"] > 0 || count( $this->m_info["m_impuestos"]["m_trasladados"] ) > 0 ){
            if( floatval($comprobante['TotalTraslado']) > 0 || count($impuestos_trasladados) > 0 ){
      				$xmlWriter->text( "\n\t\t" );
      				$xmlWriter->startElement('cfdi:Traslados');
      				// foreach( $this->m_info["m_impuestos"]["m_trasladados"] as $indice => $valor ){
              foreach( $impuestos_trasladados as $impuesto ){
      					$xmlWriter->text( "\n\t\t\t" );
      					$xmlWriter->startElement('cfdi:Traslado');
      						// Atributos:
      						$xmlWriter->startAttribute('Impuesto');
      							$xmlWriter->text( $impuesto["ClaveImpuesto"] );
      						$xmlWriter->endAttribute();

      						$xmlWriter->startAttribute('TipoFactor');
      							$xmlWriter->text( $impuesto["Factor"] );
      						$xmlWriter->endAttribute();

      						$xmlWriter->startAttribute('TasaOCuota');
      							$xmlWriter->text( number_format($impuesto["Tasa_Cuota"],6,".",""));
      						$xmlWriter->endAttribute();

      						$xmlWriter->startAttribute('Importe');
      							$xmlWriter->text( number_format( $impuesto["Importe"],2,".","" ) );
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

          $path_xml = "./comprobantes/" . $comprobante['RFCEmisor'] . "/". $comprobante['Serie'];
          // Valida si el directorio 'comprobantes'
          if(!is_dir("comprobantes")){
            mkdir("comprobantes", 0777)// or die('ERROR!');     // Crea el directorio 'Comprobantes' (si no existe)
          }
          if(!is_dir("comprobantes/". $comprobante['RFCEmisor'])) {
            mkdir("comprobantes/". $comprobante['RFCEmisor'])// or die("Error al crear directorio Emisor");
          }
          if(!is_dir("comprobantes/". $comprobante['RFCEmisor'] . "/" . $comprobante['Serie'])){
            mkdir("comprobantes/". $comprobante['RFCEmisor'] . "/" . $comprobante['Serie'])// or die("Error al crear directorio Serie");
          }
          file_put_contents( $path_xml . "/" . $id . ".xml", $xmlWriter->flush(true), FILE_APPEND );
          return true;
        }catch(Exception $e){
          write_log("ComprobantePDO | create_xml() | Error al crear XML\n " . $e->getMessage());
          return false;
        }
      }
    }
?>
