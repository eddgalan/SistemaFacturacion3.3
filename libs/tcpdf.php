<?php
  require_once('./libs/tcpdf/config/lang/eng.php');
  require_once('./libs/tcpdf/tcpdf.php');

  class MYPDF extends TCPDF {
  	private $m_tipos = [
  		"" => "*",
  		"I" => "Ingreso",
  		"E" => "Egreso",
  		"T" => "Traslado",
  		"N" => "Nómina",
  		"P" => "Pago",
  	];
  	// Paginacion y Bordes:
  	private $reporte_contador = 0;
  	private $registros_x_pagina = 42;
  	private $aumento_y = 6;
  	private $m_coordenadas = array(
  		array ( 1,18,150,18 ),
  		array ( 18,44,150,44 ),
  	);
  	private $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'solid' => 2, 'color' => array(0, 0, 0));
  	private $style001 = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'solid' => 2, 'color' => array(0, 0, 0));

    public function imprimir($comprobante, $detalles, $path_logo, $file_xml){
      try{
        $this->SetFont('helvetica', '', 8 );
    		$this->AddPage();
    		$this->SetY( 5 );

    		$moneda0 = "Moneda";
    		$tc0 = "T. Cambio";
    		$tc = $comprobante['TipoCambio'];
    		$moneda = $comprobante['Moneda'];
    		$forma_pago0 = "Forma de Pago:";
    		$metodo_pago0 = "Método de Pago:";
    		$forma_pago = $comprobante['FormaPago'];
    		$metodo_pago = $comprobante['MetodoPago'];
    		if( substr($comprobante['TipoComprobante'], 0, 1) == "P" ){
    			$moneda0 = "";
    			$moneda = "";
    			$forma_pago0 = "";
    			$forma_pago = "";
    			$metodo_pago0 = "";
    			$metodo_pago = "";
    			$tc0 = "";
    			$tc = "";
    		}
    		if( $comprobante['Moneda'] == "MXN" ){
    			$tc0 = "";
    			$tc = "";
    		}
    		// Emisor:
    		$this->SetFont('helvetica', 'B', 13 );
        if( strlen( $comprobante['NombreEmisor'] > 45 )) $this->SetFont('helvetica', 'B', 11 );

    		$this->imprime_encanezado_cliente_cfdi2( 0,0, $comprobante['NombreEmisor'] ,"" );
    		$this->SetFont('helvetica', 'B', 9 );
    		$this->imprime_linea1( "" );
    		$this->imprime_encanezado_cliente_cfdi2( 0,0,"RFC: ". $comprobante['RFCEmisor'],"" );
    		$this->imprime_encanezado_cliente_cfdi2( 0,0,"Lugar de Expedición: ". $comprobante['LugarExpedicion'],"" );
    		$this->imprime_encanezado_cliente_cfdi2( 0,0,$forma_pago0." ".$forma_pago,"" );
    		$this->imprime_encanezado_cliente_cfdi2( 0,0,$metodo_pago0." ".$metodo_pago,"" );
    		$this->imprime_encanezado_cliente_cfdi2( 0,0,"Régimen: ". $comprobante['Regimen'] ." | ". $comprobante['DescRegimen'],"" );
    		// Cliente:
    		if( substr($comprobante['TipoComprobante'], 0, 1) == "N" ){
          $this->imprime_encanezado_cliente_cfdi( 1,1,"Empleado:","Fecha","NÓMINA" );
    		}else{
    			$this->imprime_encanezado_cliente_cfdi( 1,1,"Cliente:","Fecha", strtoupper( $comprobante['TipoComprobante'] ) );
    		}
    		$this->imprime_encanezado_cliente_cfdi( 0,0,substr( $comprobante['NombreReceptor'],0,150),
        $comprobante['Fecha'] . " " . $comprobante['Hora'],
        $comprobante['Serie'] . " - " . $comprobante['Folio'] );

    		$this->imprime_encanezado_cliente_cfdi2( 0,1,"","Folio Fiscal ( UUID )" );
        $this->SetFont('helvetica', 'B', 8 );
        $this->imprime_encanezado_cliente_cfdi2( 0,0,"RFC: ". $comprobante['RFCReceptor'], strtoupper( $comprobante['UUID'] ) );
    		$this->SetFont('helvetica', 'B', 10 );

        if( substr($comprobante['TipoComprobante'], 0, 1) != "N" ){
          $this->imprime_encanezado_cliente_cfdi( 0,1,"Uso del CFDI: ". $comprobante['ClaveUsoCFDI'] ." | ". $comprobante['DescUsoCFDI'],$moneda0,$tc0 );
      		$txt_condiciones = "";
      		if( $comprobante['CondicionesPago'] != "" && substr($comprobante['TipoComprobante'], 0, 1) != "P" ) $txt_condiciones = "Condiciones: ". $comprobante['CondicionesPago'];
      		$this->imprime_encanezado_cliente_cfdi( 0,0,$txt_condiciones,$moneda,$tc );
        }

    		if( file_exists( "./". $path_logo ) ) $this->Image( "./". $path_logo, 148, 10, 45, 40, 'jpg', '', '', true, 150, '', false, false, 0, false, false, false);
    		if( substr($comprobante['TipoComprobante'], 0, 1) != "N" ){
    			$this->SetFont('helvetica', 'B', 8 );
    			$this->imprime_linea8( 0,"Cve. Prod.","Clave SAT","Cantidad","Unidad","Descripción","Precio","IVA","Importe","Descuento" );
    			if( count( $detalles > 0 )){
    				$this->SetFont('helvetica', '', 8 );
    				foreach( $detalles as $producto ){
    					$this->imprime_linea8_01(
    						1,
    						$producto["ClaveProdServ"],
    						$producto["SKU"],
    						number_format($producto["Cantidad"],0,".",","),
    						substr($producto["Unidad"], 6, strlen($producto['Unidad'])),
    						$producto["Descripcion"],
    						number_format($producto["PrecioUnitario"],2,".",","),
                number_format($producto["Impuestos"],2,".",","),
    						number_format($producto["Importe"],2,".",","),
    						number_format($producto["Descuento"],2,".",","),
    						$producto["Unidad"]
    					);
    					if( strlen($producto["Descripcion"]) > 200 ) $this->imprime_linea1( "" );
    					$this->Line( $this->m_coordenadas[0][0]+5, $this->m_coordenadas[0][1]+$this->aumento_y-14, $this->m_coordenadas[0][2]+54, $this->m_coordenadas[0][3]+$this->aumento_y-14, $this->style );
    				}
    			}else{
    				$this->imprime_linea1( "" );
    				$this->imprime_linea1( "" );
    				$this->imprime_linea1( "" );
    				$this->imprime_linea1( "" );
    				$this->imprime_linea1( "" );
    			}
    		}

    		if( substr($comprobante['TipoComprobante'], 0, 1) != "N" ){
    			if( substr($comprobante['TipoComprobante'], 0, 1) == "P" ){
    			}else{
    				if( floatval($comprobante['Subtotal']) > 0 ){
    					$this->SetFont('helvetica', 'B', 8 );
    					$this->imprime_linea4_01( 0,"","","Subtotal:",number_format($comprobante['Subtotal'],2,".",",") );
    				}
    			}
    			// Si es TRASLADO se oculta la forma y tipo de Pago:
    			if( substr($comprobante['TipoComprobante'], 0, 1) == "T" ){
    				if( floatval($comprobante['RetIva']) > 0 ){
    					$this->imprime_linea4_01( 0,"","","IVA:",number_format($comprobante['IVA'],2,".",",") );
    				}
    			}elseif( substr($comprobante['TipoComprobante'], 0, 1) == "P" ){
    			}else{
    				if( floatval($comprobante['Descuento']) > 0 ){
    					$this->imprime_linea4_01( 0,"","","Descuento:",number_format($comprobante['Descuento'],2,".",",") );
    				}
    				if( floatval($comprobante['IVA']) > 0 ){
    					$this->imprime_linea4_01( 0,"","","IVA:",number_format( $comprobante['IVA'],2,".",",") );
    				}
            /*
            ..:: IMPORTANTE | ¿Qué es el ISH? ::..
            */
    				if( $this->m_info["m_comprobante"]["cfdiidish"] > 0 ){
    					$this->imprime_linea4_01( 0,"","","ISH:",number_format($this->m_info["m_comprobante"]["cfdiidish"],2,".",",") );
    				}
    			}
    		}
    		if( substr($comprobante['TipoComprobante'], 0, 1) == "P" ){

    		}else{
    			$this->SetFont('helvetica', 'B', 8 );
    			$this->imprime_linea4_01( 0,"","","Total:",number_format($comprobante['Total'],2,".",",") );
    			$this->SetFont('helvetica', 'N', 8 );
    		}

    		// CFDI Relacionados:
    		// if( count( $this->m_info["m_relacionados"] ) > 0 ){
    		// 	$this->imprime_linea1( "" );
    		// 	$this->SetFont('helvetica', 'B', 8 );
    		// 	$this->imprime_linea1( "CFDI RELACIONADOS:" );
    		// 	$this->SetFont('helvetica', 'N', 8 );
    		// 	foreach( $this->m_info[ "m_relacionados" ] as $registro ){
    		// 		$cfdirelsatcla = trim( $registro[ "cfdirelcla" ] );
    		// 		$cfdirelsatcon = trim( $registro[ "cfdirelcon" ] );
    		// 		$m_items = $registro[ "m_items" ];
    		// 		$this->imprime_linea1( $cfdirelsatcla." - ".$cfdirelsatcon.":" );
    		// 		foreach( $m_items as $uuid ){
    		// 			$this->imprime_linea1( "          ".strtoupper( $uuid ) );
    		// 		}
    		// 	}
    		// }

    		if( !empty( $comprobante['Observaciones'] ) ){
    			$this->imprime_linea1( "" );
    			$this->imprime_linea4_02( 0,"Observaciones:", $comprobante['Observaciones']);
    		}

    		$this->SetFont('helvetica', 'N', 8 );
    		$this->imprime_linea1( "" );
    		$this->imprime_linea1( "" );

    		if( strlen( $comprobante['UUID'] ) == 36 ){
    			// Leer la Info del Timbre Fiscal:
    			$cfditimbver = "";
    			$cfditimbnocer = "";
    			$cfdisello = "";
    			$cfditimbsello = "";
    			$cfdisatrfc = "";
    			if( $file_xml != "" && file_exists( $file_xml ) ){
    				$archivo_xml = trim(file_get_contents( $file_xml ));
    				// Convertir a Matriz:
    				$p = xml_parser_create();
    				xml_parse_into_struct($p, $archivo_xml, $vals, $index);
    				xml_parser_free($p);
    				// echo "<br><div style='width:600px;height:300px;overflow:auto;'> "; echo "<br><pre>"; print_r( $vals ); echo "</pre><br>"; echo "</div>"; exit;
    				foreach( $vals as $valor ){
    					//echo "<br><pre>"; print_r( $valor ); echo "</pre><br>"; exit;
    					$tag = 	trim( $valor[ "tag" ] );
    					// echo "<br>TAG: $tag";
    					if( $tag == 'TFD:TIMBREFISCALDIGITAL' ){
    						// echo "<br><pre>"; print_r( $valor ); echo "</pre><br>"; // exit;
    						$cfdiuuid 		= trim( $valor[ "attributes" ][ "UUID" ] );
    						$cfditimbfecha 	= trim( $valor[ "attributes" ][ "FECHATIMBRADO" ] );
    						$cfditimbver		= trim( $valor[ "attributes" ][ "VERSION" ] );
    						$cfditimbnocer 	= trim( $valor[ "attributes" ][ "NOCERTIFICADOSAT" ] );
    						$cfdisello 		= trim( $valor[ "attributes" ][ "SELLOCFD" ] );
    						$cfditimbsello 	= trim( $valor[ "attributes" ][ "SELLOSAT" ] );
    						$cfdisatrfc 		= trim( $valor[ "attributes" ][ "RFCPROVCERTIF" ] );
    					}
    				}
    			}
    			$this->cadena_qr = "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?&id=". $comprobante['UUID'] ."&re=". $comprobante['RFCEmisor'] ."&rr=". $comprobante['RFCReceptor'] ."&tt=".number_format($comprobante['Total'],2,'.','')."&fe=".strrev(substr(strrev( $cfditimbsello ),0,8));
    			$cadenaOriginal = "||".$this->m_info["m_comprobante"]["cfdiidtimbver"]."|".$this->m_info["m_comprobante"]["cfdiuuid"]."|".$this->m_info["m_comprobante"]["cfdicerfec"]."T".$this->m_info["m_comprobante"]["cfdicerhor"]."|".$cfdisatrfc."|".$cfdisello."|".$cfditimbnocer."||";
    			$this->imprime_timbre( $this->cadena_qr,$cfdisello,$cfditimbsello,$cadenaOriginal,$this->m_info["m_comprobante"]["cfdiuuid"],$this->m_info["m_comprobante"]["cfdiidtimbnocer"],$this->m_info["m_comprobante"]["cfdicerfec"]." ".$this->m_info["m_comprobante"]["cfdicerhor"],$cfdisatrfc );
    			$this->imprime_linea1C( "ESTE DOCUMENTO ES UNA REPRESENTACIÓN IMPRESA DE UN CFDI" );
    		}else{
    			$this->imprime_linea1C( "ESTE DOCUMENTO NO TIENE VALOR FISCAL" );
    		}
        return true;
      }catch(Exception $e){
        write_log('MYPDF | imprimir() | Ocurrió un error al escribir el PDF.\Error: ' . $e->getMessage());
        return false;
      }
    }

    function imprime_timbre( $QR,$selloCFDI,$selloSAT,$cadenaOriginal,$UUID,$noCertificadoSAT,$fecha,$facsatrfc ){
  		// $this->imprime_linea1C( "QR ... (".$this->reporte_contador.")" );
  		if( $this->reporte_contador > 35 ){
  			// Ya no cabe, saltar de Hoja:
  			$this->reporte_contador = $this->registros_x_pagina;
  			$this->coordenadas();
  			$this->imprime_linea1( "" );
  		}
  		$altox = 2;
  		$this->write2DBarcode( $QR, 'QRCODE,H', 5, $this->m_coordenadas[0][3] + 6, 35, 35, $style, 'N' );
  		$this->SetY( $this->m_coordenadas[0][3] + 0 );
  		$this->Ln( $this->aumento_y );
  		$this->MultiCell( 35, $this->aumento_y, "", 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y, "Fecha Certificación:", 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 135, $this->aumento_y, $fecha, 0, 'L', 0, 0, '', '', true );
  		$this->coordenadas();
  		$this->Ln( 5 );
  		$this->MultiCell( 35, $this->aumento_y*$altox, "", 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y*$altox, "Sello digital del CFDI:", 0, 'L', 0, 0, '', '', true );
  		$this->SetFont('helvetica', 'N', 5 );
  		$this->MultiCell( 135, $this->aumento_y*$altox, $selloCFDI, 0, 'L', 0, 0, '', '', true );
  		$this->SetFont('helvetica', 'N', 8 );
  			$this->Ln( $this->aumento_y );
  		$this->coordenadas();
  		$this->coordenadas();
  		$this->Ln( 3 );
  		$this->MultiCell( 35, $this->aumento_y*( $altox + 0 ), "", 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y*( $altox + 0 ), "Sello digital del SAT:", 0, 'L', 0, 0, '', '', true );
  		$this->SetFont('helvetica', 'N', 5 );
  		$this->MultiCell( 135, $this->aumento_y*( $altox + 0 ), $selloSAT, 0, 'L', 0, 0, '', '', true );
  		$this->SetFont('helvetica', 'N', 8 );
  			$this->Ln( $this->aumento_y );
  		$this->coordenadas();
  		$this->coordenadas();
  		$this->Ln( 3 );
  		$this->MultiCell( 35, $this->aumento_y*( $altox + 0 ), "", 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y*($altox+0), "Cadena Original:", 0, 'L', 0, 0, '', '', true );
  		$this->SetFont('helvetica', 'N', 5 );
  		$this->MultiCell( 135, $this->aumento_y*($altox+0), $cadenaOriginal, 0, 'L', 0, 0, '', '', true );
  		$this->SetFont('helvetica', 'N', 8 );
  			$this->Ln( $this->aumento_y );
  		$this->coordenadas();
  	}

  	function coordenadas_reinicio(){
  		$this->m_coordenadas = array(
  			array ( 1,18,150,18 ),
  			array ( 18,44,150,44 ),
  		);
  		$this->AddPage();
  		$this->SetY( 5 );
  		$this->reporte_contador = 0;
  	}

   	function busca_texto_en_cadena( $texto,$cadena ){
  		$posicion_coincidencia = strpos( $texto, $cadena );
  		if( $posicion_coincidencia === false ){
  			return 0;
  		}else{
  			return 1;
  		}
  	}
  	public function Header(){}
  	public function Footer(){}

  	function imprime_encanezado1( $relleno,$A,$B,$C,$E ){
  		$this->Ln( $this->aumento_y );
  		if( $relleno ){
  			$this->SetFont('helvetica', 'B', 12 );
  		}else{
  			$this->SetFont('helvetica', 'B', 10 );
  		}
  		$this->MultiCell( 130, $this->aumento_y, $A, 0, 'L', 0, 0, '', '', true );

  		if( $relleno ){
  			$this->SetFont('helvetica', 'B', 10 );
  			$this->SetFillColor(50,50,50); // Gris Fuerte
  			$this->SetTextColor(255,255,255); // Blanco
  		}else{
  			$this->SetFont('helvetica', 'B', 9 );
  			$this->SetTextColor(0,0,0); // Negro
  		}
  		$this->MultiCell( 40, $this->aumento_y, $B, 0, 'C', $relleno, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y, $C, 0, 'C', $relleno, 0, '', '', true );
  		$this->SetTextColor(0,0,0); // Negro
  		$this->coordenadas();
  	}

  	function imprime_encanezado2( $relleno,$A,$B ){
  		$this->Ln( $this->aumento_y );
  		$this->SetFont('helvetica', 'B', 10 );
  		$this->MultiCell( 130, $this->aumento_y, $A, 0, 'L', 0, 0, '', '', true );
  		if( strlen( $B ) == 36 ){
  			$this->SetFont('helvetica', 'B', 8 );
  		}else{
  			$this->SetFillColor(50,50,50); // Gris Fuerte
  			$this->SetTextColor(255,255,255); // Blanco
  			$this->SetFont('helvetica', 'B', 10 );
  		}
  		$this->MultiCell( 70, $this->aumento_y-0, $B, 0, 'C', $relleno, 0, '', '', true );
  		$this->SetTextColor(0,0,0); // Negro
  		$this->coordenadas();
  	}

  	function imprime_encanezado3( $relleno,$A ){
  		$this->Ln( $this->aumento_y );
  		$this->SetFont('helvetica', 'B', 9 );
  		$alto_contenedor = $this->aumento_y;
  		if( $relleno ){
  			$this->SetFillColor(50,50,50); // Gris Fuerte
  			$this->SetTextColor(255,255,255); // Blanco

  			$alto_contenedor = $this->aumento_y -1;
  			$borde = 0;
  		}else{
  			$this->SetTextColor(0,0,0); // Negro

  			// $alto_contenedor = $this->aumento_y * 5;
  			$borde = 0;
  			$this->SetFont('helvetica', 'B', 9 );
  		}
  		$this->MultiCell( 110, $alto_contenedor, $A, $borde, 'L', $relleno, 0, '', '', true );
  		$this->SetTextColor(0,0,0); // Negro

  		$this->coordenadas();
  	}

  	function imprime_encanezado4( $relleno,$A,$B,$C,$E ){
  		$this->Ln( $this->aumento_y );
  		$this->SetFont('helvetica', 'B', 10 );
  		$this->MultiCell( 130, $this->aumento_y, $A, 0, 'L', 0, 0, '', '', true );
  		if( $relleno ){
  			$this->SetFont('helvetica', 'B', 10 );
  			$this->SetFillColor(50,50,50); // Gris Fuerte
  			$this->SetTextColor(255,255,255); // Blanco
  		}else{
  			$this->SetFont('helvetica', 'B', 9 );
  			$this->SetTextColor(0,0,0); // Negro
  		}
  		$this->SetFont('helvetica', 'B', 10 );
  		$this->MultiCell( 40, $this->aumento_y, $B, 0, 'C', $relleno, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y, $C, 0, 'C', $relleno, 0, '', '', true );
  		$this->SetTextColor(0,0,0); // Negro
  		$this->coordenadas();
  	}

  	function imprime_encanezado_cliente_cfdi( $relleno0,$relleno1,$A,$B,$C ){
  		$this->Ln( $this->aumento_y );
  		$alto_celda0 = $this->aumento_y;
  		$alto_celda1 = $this->aumento_y;
  		if( $relleno0 ){
  			$this->SetFont('helvetica', 'B', 10 );
          	$this->SetFillColor(220,220,220); // Gris suave
  			$alto_celda0 = $this->aumento_y - 1;
  		}else{
  			$this->SetFont('helvetica', 'B', 9 );
  			$this->SetTextColor(0,0,0); // Negro
  		}
  		$this->MultiCell( 129, $alto_celda0, $A, 0, 'L', $relleno0, 0, '', '', true );
  		$this->MultiCell( 1, $this->aumento_y, "", 0, 'L', 0, 0, '', '', true );

  		if( $relleno1 ){
  			$this->SetFont('helvetica', 'B', 9 );
  			$this->SetFillColor(220,220,220); // Gris suave
  			$alto_celda1 = $this->aumento_y - 1;
  		}else{
  			$this->SetFont('helvetica', 'B', 9 );
  			$this->SetTextColor(0,0,0); // Negro
  		}
  		$this->MultiCell( 40, $alto_celda1, $B, 0, 'C', $relleno1, 0, '', '', true );
  		$this->MultiCell( 30, $alto_celda1, $C, 0, 'C', $relleno1, 0, '', '', true );
  		$this->SetTextColor(0,0,0); // Negro
  		$this->coordenadas();

  	}

  	function imprime_encanezado_cliente_cfdi2( $relleno0,$relleno1,$A,$B ){
  		$this->Ln( $this->aumento_y );
  		$alto_celda0 = $this->aumento_y;
  		$alto_celda1 = $this->aumento_y;
  		if( $relleno0 ){
  			$this->SetFillColor(50,50,50); // Gris Fuerte
  			$this->SetTextColor(255,255,255); // Blanco
  			$alto_celda0 = $this->aumento_y - 1;
  		}else{
  			$this->SetTextColor(0,0,0); // Negro
  		}
  		$this->MultiCell( 129, $alto_celda0, $A, 0, 'L', $relleno0, 0, '', '', true );
  		$this->MultiCell( 1, $alto_celda0, "", 0, 'L', 0, 0, '', '', true );
  		if( $relleno1 ){
  			$this->SetFillColor(220,220,220);
  			$alto_celda1 = $this->aumento_y - 1;
  		}else{
  			$this->SetTextColor(0,0,0); // Negro
  		}
  		$this->MultiCell( 70, $alto_celda1, $B, 0, 'C', $relleno1, 0, '', '', true );
  		$this->SetTextColor(0,0,0); // Negro
  		$this->coordenadas();
  	}

  	private function coordenadas(){
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea0( $texto1 ){
  		$this->Ln( $this->aumento_y-($this->aumento_y-1) );
  		$this->MultiCell( 1, $this->aumento_y-($this->aumento_y-1), "", 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 195, $this->aumento_y-($this->aumento_y-1), $texto1, 1, 'L', 0, 0, '', '', true );
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea1( $texto1 ){
  		$this->Ln( $this->aumento_y );
  		$this->MultiCell( 195, $this->aumento_y, $texto1, 0, 'L', 0, 0, '', '', true );
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea1C( $texto1 ){
  		$this->Ln( $this->aumento_y );
  		$this->MultiCell( 7, $this->aumento_y, "", 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 195, $this->aumento_y, $texto1, 0, 'C', 0, 0, '', '', true );
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea2( $texto1,$texto2 ){
  		$this->Ln( 5 );
  		$this->MultiCell( 5, 4, "", 1, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 32, 4, $texto1, 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 135, 4, $texto2, 0, 'L', 0, 0, '', '', true );
  		$this->Line( $this->m_coordenadas[0][0]+53, $this->m_coordenadas[0][1]+0, $this->m_coordenadas[0][2]+40, $this->m_coordenadas[0][3]+0, $this->style );
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea3( $texto1,$texto2,$texto3 ){
  		$this->Ln( 5 );
  		$this->SetFont('helvetica', 'B', 10 );
  		$this->MultiCell( 10, 4, "", 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 50, 4, $texto1, 0, 'C', 0, 0, '', '', true );
  		$this->MultiCell( 15, 4, "", 0, 'C', 0, 0, '', '', true );
  		$this->MultiCell( 50, 4, $texto2, 0, 'C', 0, 0, '', '', true );
  		$this->MultiCell( 15, 4, "", 0, 'C', 0, 0, '', '', true );
  		$this->MultiCell( 50, 4, $texto3, 0, 'C', 0, 0, '', '', true );
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea4( $mostrar_linea,$texto1,$texto2,$texto3,$texto4 ){
  		$this->Ln( $this->aumento_y );
  		$this->SetFont('helvetica', 'B', 7 );
  		$this->MultiCell( 30, $this->aumento_y, $texto1, 0, 'L', 0, 0, '', '', true );
  		$this->SetFont('helvetica', 'N', 7 );
  		$this->MultiCell( 70, $this->aumento_y, $texto2, 0, 'L', 0, 0, '', '', true );
  		$this->SetFont('helvetica', 'B', 7 );
  		$this->MultiCell( 30, $this->aumento_y, $texto3, 0, 'L', 0, 0, '', '', true );
  		$this->SetFont('helvetica', 'N', 7 );
  		$this->MultiCell( 70, $this->aumento_y, $texto4, 0, 'L', 0, 0, '', '', true );
  		if( $mostrar_linea ){
  			$this->Line( $this->m_coordenadas[0][0]+35, $this->m_coordenadas[0][1]+$this->aumento_y*4+2, $this->m_coordenadas[0][2]-45, $this->m_coordenadas[0][3]+$this->aumento_y*4+2, $this->style001 );
  			$this->Line( $this->m_coordenadas[0][0]+205, $this->m_coordenadas[0][1]+$this->aumento_y*4+2, $this->m_coordenadas[0][2]-15, $this->m_coordenadas[0][3]+$this->aumento_y*4+2, $this->style001 );
  		}
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea5n( $borde,$texto1,$texto2,$texto3,$texto4,$texto5 ){
  		$this->Ln( $this->aumento_y );
  		$this->MultiCell( 20, $this->aumento_y, $texto1, $borde, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 20, $this->aumento_y, $texto2, $borde, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 120, $this->aumento_y, $texto3, $borde, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 20, $this->aumento_y, $texto4, $borde, 'R', 0, 0, '', '', true );
  		$this->MultiCell( 20, $this->aumento_y, $texto5, $borde, 'R', 0, 0, '', '', true );
  		// Linea
  		if( $mostrar_linea ){
  			$this->Line( $this->m_coordenadas[0][0]+35, $this->m_coordenadas[0][1]+$this->aumento_y*4+2, $this->m_coordenadas[0][2]-45, $this->m_coordenadas[0][3]+$this->aumento_y*4+2, $this->style001 );
  			$this->Line( $this->m_coordenadas[0][0]+205, $this->m_coordenadas[0][1]+$this->aumento_y*4+2, $this->m_coordenadas[0][2]-15, $this->m_coordenadas[0][3]+$this->aumento_y*4+2, $this->style001 );
  		}
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea5n2( $borde,$texto1,$texto2,$texto3,$texto4,$texto5 ){
  		$this->Ln( $this->aumento_y );
  		$this->MultiCell( 20, $this->aumento_y, $texto1, $borde, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 20, $this->aumento_y, $texto2, $borde, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 140, $this->aumento_y, $texto3, $borde, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 20, $this->aumento_y, $texto4, $borde, 'R', 0, 0, '', '', true );
  		// Linea
  		if( $mostrar_linea ){
  			$this->Line( $this->m_coordenadas[0][0]+35, $this->m_coordenadas[0][1]+$this->aumento_y*4+2, $this->m_coordenadas[0][2]-45, $this->m_coordenadas[0][3]+$this->aumento_y*4+2, $this->style001 );
  			$this->Line( $this->m_coordenadas[0][0]+205, $this->m_coordenadas[0][1]+$this->aumento_y*4+2, $this->m_coordenadas[0][2]-15, $this->m_coordenadas[0][3]+$this->aumento_y*4+2, $this->style001 );
  		}
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea4_01( $mostrar_linea,$texto1,$texto2,$texto3,$texto4 ){
  		$this->Ln( $this->aumento_y );
  		$relleno = 1;
  		$this->SetFillColor(220,220,220); // Gris Fuerte
  		$this->MultiCell( 30, $this->aumento_y, $texto1, 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 110, $this->aumento_y, $texto2, 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y, $texto3, 0, 'R', $relleno, 0, '', '', true );
  		$this->SetFillColor(242,242,242);
  		$this->SetTextColor(0,0,0); // Negro
  		$this->MultiCell( 30, $this->aumento_y, $texto4, 0, 'R', $relleno, 0, '', '', true );
  		// Linea
  		if( $mostrar_linea ){
  			$this->Line( $this->m_coordenadas[0][0]+35, $this->m_coordenadas[0][1]+$this->aumento_y*4+2, $this->m_coordenadas[0][2]-45, $this->m_coordenadas[0][3]+$this->aumento_y*4+2, $this->style001 );
  			$this->Line( $this->m_coordenadas[0][0]+205, $this->m_coordenadas[0][1]+$this->aumento_y*4+2, $this->m_coordenadas[0][2]-15, $this->m_coordenadas[0][3]+$this->aumento_y*4+2, $this->style001 );
  		}
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea4_02( $mostrar_linea,$texto1,$texto2){
  		$this->Ln( $this->aumento_y );
  		$this->MultiCell( 30, $this->aumento_y, $texto1, 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 170, $this->aumento_y, $texto2, 0, 'L', 0, 0, '', '', true );
  		// Linea
  		if( $mostrar_linea ){
  			$this->Line( $this->m_coordenadas[0][0]+35, $this->m_coordenadas[0][1]+$this->aumento_y*4+2, $this->m_coordenadas[0][2]-45, $this->m_coordenadas[0][3]+$this->aumento_y*4+2, $this->style001 );
  			$this->Line( $this->m_coordenadas[0][0]+205, $this->m_coordenadas[0][1]+$this->aumento_y*4+2, $this->m_coordenadas[0][2]-15, $this->m_coordenadas[0][3]+$this->aumento_y*4+2, $this->style001 );
  		}
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea4_03( $small,$texto1,$texto2){
  		$this->Ln( $this->aumento_y );
  		$altox = 1;
  		if( $small == 3 ){
  			$altox = 3;
  		}
  		$this->MultiCell( 40, $this->aumento_y*$altox, $this->reporte_contador, 1, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y*$altox, $texto1, 1, 'L', 0, 0, '', '', true );
  		if( $small == 1 || $small == 3 ) $this->SetFont('helvetica', 'N', 6 );
  		$this->MultiCell( 130, $this->aumento_y*$altox, $texto2, 1, 'L', 0, 0, '', '', true );
  		$this->SetFont('helvetica', 'N', 8 );
  		if( $small == 3 ){
  			$this->Ln( $this->aumento_y );
  			$this->Ln( $this->aumento_y );
  			++$this->reporte_contador;
  			++$this->reporte_contador;
  			++$this->reporte_contador;
  		}
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea5( $mostrar_linea,$texto1,$texto2,$texto3,$texto4,$texto5 ){
  		$this->Ln( $this->aumento_y );
  		$relleno = 0;
  		if( $mostrar_linea ) $relleno = 1;
  		$this->SetFillColor(240,240,240); // Gris
  		$this->MultiCell( 25, $this->aumento_y, "", 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y, $texto1, 1, 'C', $relleno, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y, $texto2, 1, 'C', $relleno, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y, $texto3, 1, 'C', $relleno, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y, $texto4, 1, 'C', $relleno, 0, '', '', true );
  		$this->MultiCell( 30, $this->aumento_y, $texto5, 1, 'C', $relleno, 0, '', '', true );
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ){
  			$this->coordenadas_reinicio();
  		}
  		return true;
  	}

  	function imprime_linea8( $mostrar_linea,$texto1,$texto2,$texto3,$texto4,$texto5,$texto6,$texto61,$texto7,$texto8 ){
  		$this->Ln( $this->aumento_y );
  		$relleno = 0;
  		$borde = 0;
  		if( $mostrar_linea == 0 ) $relleno = 1;
  		$this->SetFillColor(220,220,220);
  		$this->MultiCell( 17, $this->aumento_y-1, $texto2, $borde, 'L', $relleno, 0, '', '', true );
  		$this->MultiCell( 88, $this->aumento_y-1, $texto5, $borde, 'L', $relleno, 0, '', '', true );
  		$this->MultiCell( 15, $this->aumento_y-1, $texto4, $borde, 'L', $relleno, 0, '', '', true );
  		$this->MultiCell( 20,$this->aumento_y-1, $texto3, $borde, 'C', $relleno, 0, '', '', true );
  		$this->MultiCell( 20, $this->aumento_y-1, $texto6, $borde, 'R', $relleno, 0, '', '', true );
      	$this->MultiCell( 20, $this->aumento_y-1, $texto61, $borde, 'R', $relleno, 0, '', '', true );
  		$this->MultiCell( 20, $this->aumento_y-1, $texto7, $borde, 'R', $relleno, 0, '', '', true );
  		$this->SetTextColor(0,0,0); // Negro
  		// Paginacion:
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y;
  		$this->m_coordenadas[0][3] += $this->aumento_y;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
  	}

  	function imprime_linea8_01( $mostrar_linea,$texto1,$texto2,$texto3,$texto4,$texto5,$texto6,$texto61,$texto7,$texto8,$facdetunicla ){
  		$altox = 1;
  		$this->Ln( $this->aumento_y );
  		$this->MultiCell( 17, $this->aumento_y*$altox, $texto1, 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 88, $this->aumento_y*$altox, $texto5, 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 15, $this->aumento_y*$altox, $texto4, 0, 'L', 0, 0, '', '', true );
  		$this->MultiCell( 20, $this->aumento_y*$altox, $texto3, 0, 'C', 0, 0, '', '', true );
  		$this->MultiCell( 20, $this->aumento_y*$altox, $texto6,0, 'R', 0, 0, '', '', true );
    	$this->MultiCell( 20, $this->aumento_y*$altox, $texto61,0, 'R', 0, 0, '', '', true );
  		$this->MultiCell( 20, $this->aumento_y*$altox, $texto7,0, 'R', 0, 0, '', '', true );
  		++$this->reporte_contador;
  		$this->m_coordenadas[0][1] += $this->aumento_y*$altox;
  		$this->m_coordenadas[0][3] += $this->aumento_y*$altox;
  		if( $this->reporte_contador >= $this->registros_x_pagina ) $this->coordenadas_reinicio();
    }
  }
?>
