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
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row">
                              <!-- RFC Emisor -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Emisor: </strong></label>
                                <label><?= $data['comprobante']['RFCEmisor'] ?></label>
                              </div>
                              <!-- Lugar Expedición -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Lugar de Expedición: </strong></label>
                                <label><?= $data['comprobante']['LugarExpedicion'] ?></label>
                              </div>
                              <!-- Regimen -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Regimen: </strong></label>
                                <label><?= $data['comprobante']['Regimen'] ?></label>
                              </div>
                              <!-- Forma de Pago -->
                              <div class="col-lg-12 col-md-12 col-sm-12">

                              </div>
                              <!-- Método de Pago -->
                              <div class="col-lg-12 col-md-12 col-sm-12">

                              </div>
                              <!-- RFC Receptor (Cliente) -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>RFC Receptor: </strong></label>
                                <label><?= $data['comprobante']['RFCReceptor'] ?></label>
                              </div>
                              <!-- RFC Receptor (Cliente) -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Nombre Receptor: </strong></label>
                                <label><?= $data['comprobante']['NombreReceptor'] ?></label>
                              </div>
                              <!-- Fecha y Hora -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Fecha: </strong></label>
                                <label><?= $data['comprobante']['Fecha'] ?></label>
                                <label><strong>Hora: </strong></label>
                                <label><?= $data['comprobante']['Hora'] ?></label>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row">
                              <!-- Serie -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Serie: </strong></label>
                                <label><?= $data['comprobante']['Serie'] ?> </label>
                                <label><strong>Folio: </strong></label>
                                <label><?= $data['comprobante']['Folio'] ?> </label>
                              </div>
                              <!-- Método de Pago -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Método de Pago: </strong></label>
                                <label><?= $data['comprobante']['ClaveMetodoPago'] ?> | <?= $data['comprobante']['DescripcionMetodoPago'] ?></label>
                              </div>
                              <!-- Forma de Pago -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Forma de Pago: </strong></label>
                                <label><?= $data['comprobante']['ClaveFormaPago'] ?> | <?= $data['comprobante']['DescripcionFormaPago'] ?></label>
                              </div>
                              <!-- Moneda y Tipo de Cambio -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Moneda: </strong></label>
                                <label><?= $data['comprobante']['Moneda'] ?> </label>
                                <label><strong>Tipo de cambio: </strong></label>
                                <label><?= $data['comprobante']['TipoCambio'] ?> </label>
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
                          <div class="col-lg-8 col-md-6 col-sm-12">
                            <div class="row">
                              <!-- Fecha y Hora Certificación -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Fecha certificado: </strong></label>
                                <label><?= $data['comprobante']['FechaCertificado'] ?>  <?= $data['comprobante']['HoraCertificado'] ?> </label>
                              </div>
                              <!-- NoCertificado -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>No. Certificado: </strong></label>
                                <label><?= $data['comprobante']['NoCertificado'] ?></label>
                              </div>
                              <!-- UUID -->
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <label><strong>Folio Fiscal (UUID): </strong></label>
                                <label><?= $data['comprobante']['UUID'] ?> </label>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12">
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
                            <a href="<?= $data['host'] ?>/CFDIs/facturas/timbrar/<?= $data['comprobante']['IdCFDI']?>"class="btn btn-success"> <i class="fas fa-file-invoice-dollar"></i> Timbrar CFDI </a>
                            <button class="btn btn-warning"> <i class="fas fa-file-pdf"></i> Descargar PDF </button>
                            <button class="btn btn-warning"> <i class="fas fa-file-code"></i> Descargar XML </button>
                            <button class="btn btn-primary"> <i class="far fa-paper-plane"></i> Enviar por correo </button>
                          </div>
                        </div>
                    </div>
                </div>
                <?php include './views/modules/components/footer.php'; ?>
            </div>
        </div>
        <!-- ..:: MODALES ::.. -->
        <!-- ..:: Modal  ::.. -->
        <div class="modal fade" id="modal_nuevo_articulo">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"> <i class="fas fa-plus"></i> Agregar Producto o Servicio </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="col-lg-12 col-md-12 col-sm-12">

                </div>
              </div>
              <div class="modal-footer">
                <button type="button" name="add_product"class="btn btn-success" disabled> <i class="fas fa-check"></i> Agregar </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
            </div>
          </div>
        </div>

    <?php include './views/modules/components/javascript.php'; ?>
    <script type="text/javascript" src="<?=$data['host']?>/views/assets/js/nuevo_cfdi.js"></script>
</body>

</html>
