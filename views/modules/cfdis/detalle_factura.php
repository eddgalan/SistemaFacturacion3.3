<!DOCTYPE html>
<html>

<head>
    <?php include './views/modules/components/head.php'; ?>
</head>

<body>
    <div id="wrapper" class="d-flex">
        <?php include './views/modules/components/sidebar.php'; ?>
        <div id="page-content-wrapper" style="background-color: #DBD8D8;">
            <?php include './views/modules/components/navbar.php'; ?>
            <div class="container-fluid" style="margin-top: 15px;">
                <div class="card">
                    <div class="card-body">
                        <!-- ..:: Custom Content ::.. -->
                        <div class="row">
                          <div class="col-lg-8 col-md-8 col-sm-12">
                            <h4 class="card-title"> Detalles Factura </h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <a href="<?= $data['host']?>/CFDIs/facturas" class="btn btn-primary waves-effect btn_full">
                              <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <?php
                              require './views/modules/components/notifications.php';
                            ?>
                          </div>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <h4> <i class="far fa-file-alt"></i> Detalles </h4>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                              <!-- Estatus CFDI -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Estatus: </strong></label>
                                <?php
                                  $estatus = intval($data['comprobante']['EstatusCFDI']);
                                  switch ($estatus) {
                                    case 0:
                                      echo "<label class='color_blue'><strong> Nuevo </strong></label>";
                                      break;
                                    case 1:
                                      echo "<label class='color_green'><strong> Certificado </strong></label>";
                                      break;
                                    case 2:
                                      echo "<label class='color_red'><strong> Cancelado</strong> <label>";
                                      break;
                                    default:
                                      echo "<label class='color_red'><strong> Desconocido </strong></label>";
                                      break;
                                  }
                                ?>
                              </div>
                              <!-- RFC Emisor -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Emisor: </strong></label>
                                <spam><?= $data['comprobante']['RFCEmisor'] ?></spam>
                              </div>
                              <!-- Lugar Expedición -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Lugar de Expedición: </strong></label>
                                <spam><?= $data['comprobante']['LugarExpedicion'] ?></spam>
                              </div>
                              <!-- Regimen -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Regimen: </strong></label>
                                <spam><?= $data['comprobante']['Regimen'] ?> | <?= $data['comprobante']['DescRegimen'] ?></spam>
                              </div>
                              <!-- RFC Receptor (Cliente) -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>RFC Receptor: </strong></label>
                                <spam><?= $data['comprobante']['RFCReceptor'] ?></spam>
                              </div>
                              <!-- RFC Receptor (Cliente) -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Nombre Receptor: </strong></label>
                                <spam><?= $data['comprobante']['NombreReceptor'] ?></spam>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                              <!-- Serie -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Serie: </strong></label>
                                <spam><?= $data['comprobante']['Serie'] ?> </spam>
                                <label><strong>Folio: </strong></label>
                                <spam><?= $data['comprobante']['Folio'] ?> </spam>
                              </div>
                              <!-- Fecha y Hora -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Fecha: </strong></label>
                                <spam><?= $data['comprobante']['Fecha'] ?></spam>
                                <label><strong>Hora: </strong></label>
                                <spam><?= $data['comprobante']['Hora'] ?></spam>
                              </div>
                              <!-- Método de Pago -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Método de Pago: </strong></label>
                                <spam><?= $data['comprobante']['ClaveMetodoPago'] ?> | <?= $data['comprobante']['DescripcionMetodoPago'] ?></spam>
                              </div>
                              <!-- Forma de Pago -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Forma de Pago: </strong></label>
                                <spam><?= $data['comprobante']['ClaveFormaPago'] ?> | <?= $data['comprobante']['DescripcionFormaPago'] ?></spam>
                              </div>
                              <!-- Moneda y Tipo de Cambio -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Moneda: </strong></label>
                                <spam><?= $data['comprobante']['Moneda'] ?> </spam>
                                <label><strong>Tipo de cambio: </strong></label>
                                <spam><?= $data['comprobante']['TipoCambio'] ?> </spam>
                              </div>
                              <!-- Uso CFDI -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Uso CFDI: </strong></label>
                                <spam><?= $data['comprobante']['ClaveUsoCFDI'] ?> | <?= $data['comprobante']['ConceptoUsoCFDI'] ?></spam>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:15px;">
                            <h4> <i class="fas fa-apple-alt"></i> Productos y/o servicios </h4>
                          </div>
                          <!-- Tabla Productos/Servicios -->
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="table-sm table-responsive">
                              <table class="table table-bordered table-hover">
                                  <thead style="font-size:14px;">
                                    <tr class="text-center">
                                      <th>SKU</th>
                                      <th>Producto</th>
                                      <th>Cantidad</th>
                                      <th>Unidad</th>
                                      <th>Precio $</th>
                                      <th>Importe $</th>
                                      <th>Descuento $</th>
                                      <th>Impuestos $</th>
                                      <th>Tipo Impuesto</th>
                                      <th>Total $</th>
                                    </tr>
                                  </thead>
                                  <tbody style="font-size:14px;">
                                    <?php
                                      foreach ($data['prod_serv'] as $producto) {
                                        $html_row = ""."\n\t\t\t\t\t\t\t<tr>\n".
                                                      "\t\t\t\t\t\t\t\t<td>". $producto['SKU'] ."</td>\n".
                                                      "\t\t\t\t\t\t\t\t<td>" . $producto['Descripcion'] . "</td> \n".
                                                      "\t\t\t\t\t\t\t\t<td class='text-center'>". $producto['Cantidad'] ."</td>\n".
                                                      "\t\t\t\t\t\t\t\t<td class='text-center'>". $producto['Unidad'] ."</td>\n".
                                                      "\t\t\t\t\t\t\t\t<td class='text-center'> $ ". $producto['PrecioUnitario'] ."</td>\n".
                                                      "\t\t\t\t\t\t\t\t<td class='text-center'> $ ". $producto['Importe'] ."</td>\n".
                                                      "\t\t\t\t\t\t\t\t<td class='text-center'> $ ". $producto['Descuento'] ."</td>\n".
                                                      "\t\t\t\t\t\t\t\t<td class='text-center'> $ ". $producto['Impuestos'] ."</td>\n".
                                                      "\t\t\t\t\t\t\t\t<td class='text-center'>". $producto['TipoImpuesto'] ."</td>\n".
                                                      "\t\t\t\t\t\t\t\t<td class='text-center'> $ ". $producto['Total'] ."</td>\n".
                                                    "\t\t\t\t\t\t\t\t</tr>\n";
                                        echo $html_row;
                                      }
                                    ?>
                                  </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="col-lg-8 col-md-6 col-sm-6">
                            <div class="row">
                              <!-- Fecha y Hora Certificación -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Fecha certificado: </strong></label>
                                <spam><?= $data['comprobante']['FechaCertificado'] ?>  <?= $data['comprobante']['HoraCertificado'] ?> </spam>
                              </div>
                              <!-- NoCertificado -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>No. Certificado: </strong></label>
                                <spam><?= $data['comprobante']['NoCertificado'] ?></spam>
                              </div>
                              <!-- UUID -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Folio Fiscal (UUID): </strong></label>
                                <spam><?= $data['comprobante']['UUID'] ?> </spam>
                              </div>
                              <!-- Estatus SAT -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Estatus SAT: </strong></label>
                                <?php
                                  $estatus_sat = $data['comprobante']['EstatusSAT'];
                                  switch($estatus_sat){
                                    case 'Vigente':
                                      echo "<spam class='color_green'><strong> Vigente </strong></spam>";
                                      break;
                                    case 'Cancelado':
                                      echo "<spam class='color_red'><strong> Cancelado </strong></spam>";
                                      break;
                                    default:
                                      echo "<spam> --- </spam>";
                                      break;
                                  }
                                ?>
                              </div>
                              <!-- Observaciones -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Observaciones :</strong></label><br>
                                <p>
                                  <?= $data['comprobante']['Observaciones'] ?>
                                </p>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <h4> <i class="fas fa-dollar-sign"></i> Totales </h4>
                            </div>
                            <!-- Subtotal -->
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <label><strong>Subtotal $: </strong></label>
                              <label><?= $data['comprobante']['Subtotal'] ?></label>
                            </div>
                            <!-- IVA -->
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <label><strong>IVA: </strong></label>
                              <label><?= $data['comprobante']['IVA'] ?></label>
                            </div>
                            <!-- IEPS -->
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <label><strong>IEPS: </strong></label>
                              <label><?= $data['comprobante']['IEPS'] ?></label>
                            </div>
                            <!-- Descuento -->
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <label><strong>Descuento $: </strong></label>
                              <label><?= $data['comprobante']['Descuento'] ?></label>
                            </div>
                            <!-- Total -->
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <label><strong>Total $: </strong></label>
                              <label><?= $data['comprobante']['Total'] ?></label>
                            </div>
                          </div>
                          <!-- Acciones -->
                          <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                            <hr>
                            <?php
                            $estatus = intval($data['comprobante']['EstatusCFDI']);
                            switch ($estatus) {
                              case 0: // Comprobante Nuevo
                                echo "<a href='". $data['host'] . "/CFDIs/facturas/timbrar/". $data['comprobante']['IdCFDI'] ."'class='btn btn-success'> <i class='fas fa-file-invoice-dollar'></i> Timbrar CFDI </a>";
                                break;
                              case 1: // Comprobante Timbrado
                                echo "<a href='". $data['host'] ."/CFDIs/facturas/veriticar_sat/". $data['comprobante']['IdCFDI'] ."' class='btn btn-success'> <i class='fas fa-sync'></i> Verificar Estatus SAT </a>\n";
                                echo "<a href='". $data['host'] ."/CFDIs/facturas/descargar/pdf/". $data['comprobante']['IdCFDI'] ."' class='btn btn-warning'> <i class='fas fa-file-pdf color_red'></i> Descargar PDF </a>\n";
                                echo "<a href='". $data['host'] ."/CFDIs/facturas/descargar/xml/". $data['comprobante']['IdCFDI'] ."' class='btn btn-warning'> <i class='fas fa-file-code color_blue'></i> Descargar XML </a>\n";
                                echo "<button class='btn btn-primary'> <i class='far fa-paper-plane'></i> Enviar por correo </button>\n";
                                break;
                              case 2: // Comprobante Cancelado
                                echo "<label class='color_red'><strong> Cancelado</strong> <label>";
                                break;
                              default:
                                echo "<label class='color_red'><strong> Desconocido </strong></label>";
                                break;
                            }
                            ?>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './views/modules/components/footer.php'; ?>
        </div>
    </div>

    <?php include './views/modules/components/javascript.php'; ?>
    <script type="text/javascript" src="<?=$data['host']?>/views/assets/js/nuevo_cfdi.js"></script>
</body>

</html>
