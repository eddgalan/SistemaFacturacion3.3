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
                        <h4 class="card-title">Nuevo Comprobante (CFDI)</h4>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <form>
                            <div class="row">
                              <div class="col-lg-12">
                                <h5> <i class="fas fa-info-circle"></i> Información</h5>
                              </div>
                              <!-- Cliente -->
                              <div class="col-lg-6 col-md-8 col-sm-8">
                                <label for="cliente"> Cliente: </label>
                                <select class="form-control" name="cliente">
                                  <option value="0">-----</option>
                                  <?php
                                    foreach ($data['clientes'] as $cliente) {
                                      $html_option = "<option value='". $cliente['Id']. "'>". $cliente['Nombre'] ."</option>\n";
                                      echo $html_option;
                                    }
                                  ?>
                                </select>
                              </div>
                              <!-- Serie -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="serie">Serie: </label>
                                <select class="form-control" name="serie">
                                  <option value="">---</option>
                                  <?php
                                    foreach ($data['series'] as $serie) {
                                      $html_option = "<option value='". $serie['Serie']. "'>". $serie['Serie'] ."</option>\n";
                                      echo $html_option;
                                    }
                                  ?>
                                </select>
                              </div>
                              <!-- Tipo de Comprobante -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="tipo_comprobante"> Tipo de comprobante: </label>
                                <input type="text" class="form-control" name="tipo_comprobante" disabled>
                              </div>
                              <!-- Fecha -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="fecha"> Fecha: </label>
                                <input type="date" class="form-control" name="fecha" required>
                              </div>
                              <!-- Hora -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="hora"> Hora: </label>
                                <input type="time" class="form-control" name="hora" required>
                              </div>
                              <!-- Método de Pago -->
                              <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="metodo_pago"> Método de Pago: </label>
                                <select class="form-control" name="metodo_pago">
                                  <option value="0">---</option>
                                  <?php
                                    foreach ($data['metodos_pago'] as $metodo_pago) {
                                      $html_option = "<option value='". $metodo_pago['Id']. "'>". $metodo_pago['ClaveMetodo'] ." | ". $metodo_pago['Descripcion'] ."</option>\n";
                                      echo $html_option;
                                    }
                                  ?>
                                </select>
                              </div>
                              <!-- Forma Pago -->
                              <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="forma_pago"> Forma de Pago: </label>
                                <select class="form-control" name="forma_pago">
                                  <option value="">---</option>
                                  <?php
                                    foreach ($data['formas_pago'] as $forma_pago) {
                                      $html_option = "<option value='". $forma_pago['ClaveFormaPago']. "'>". $forma_pago['ClaveFormaPago'] ." | ". $forma_pago['Descripcion'] ."</option>\n";
                                      echo $html_option;
                                    }
                                  ?>
                                </select>
                              </div>
                              <!-- Uso CFDI -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="uso_cfdi"> Uso CFDI: </label>
                                <select class="form-control" name="uso_cfdi">
                                  <option value="">---</option>
                                  <?php
                                    foreach ($data['usos_cfdi'] as $usocfdi) {
                                      $html_option = "<option value='". $usocfdi['ClaveUso']. "'>". $usocfdi['ClaveUso'] ." | ". $usocfdi['Concepto'] ."</option>\n";
                                      echo $html_option;
                                    }
                                  ?>
                                </select>
                              </div>
                              <!-- Moneda CFDI -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="moneda"> Moneda: </label>
                                <select class="form-control" name="moneda">
                                  <option value="">---</option>
                                  <?php
                                    foreach ($data['monedas'] as $moneda) {
                                      $html_option = "<option value='". $moneda['ClaveMoneda']. "'>". $moneda['ClaveMoneda'] ." | ". $moneda['Nombre'] ."</option>\n";
                                      echo $html_option;
                                    }
                                  ?>
                                </select>
                              </div>
                              <!-- Tipo Cambio -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="tipo_cambio"> Tipo de cambio: </label>
                                <input type="text" class="form-control" name="tipo_cambio" required disabled>
                              </div>
                              <!-- Artículos -->
                              <div class="col-lg-12 col-md-12 col-sm-12"><hr>
                                <div class="row">
                                  <div class="col-lg-6 col-md-6 col-sm-12">
                                    <h5> <i class="fas fa-box"></i> Artículos</h5>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                                    <button type="button" class="btn btn-success waves-effect text-capitalize btn_full" data-toggle="modal" data-target="#modal_nuevo_articulo">
                                      <i class="fas fa-plus-circle fa-sm"></i> Agregar artículo
                                    </button>
                                  </div>
                                  <!-- Tabla Artículos -->
                                  <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:5px;">
                                    <div class="table-sm table-responsive">
                                      <table class="table table-bordered table-hover">
                                          <thead style="font-size:14px;">
                                            <tr class="text-center">
                                              <th>SKU</th>
                                              <th>Producto</th>
                                              <th>Unidad</th>
                                              <th>Precio</th>
                                              <th>Cantidad</th>
                                              <th>Subtotal</th>
                                              <th>Descuento</th>
                                              <th>IVA</th>
                                              <th>IEPS</th>
                                              <th>Total</th>
                                              <th>Remover</th>
                                            </tr>
                                          </thead>
                                          <tbody style="font-size:14px;">
                                            <tr>
                                              <td>0000-0000-0000</td>
                                              <td>Producto de Prueba 1</td>
                                              <td class="text-center">PZA</td>
                                              <td class="text-center">$ 100</td>
                                              <td class="text-center">2</td>
                                              <td class="text-center">$ 200</td>
                                              <td class="text-center">0</td>
                                              <td class="text-center">$ 32</td>
                                              <td class="text-center">$ 0</td>
                                              <td class="text-center">$ 232</td>
                                              <td class="text-center"><label onclick="saludo()" class="btn"><i class="fas fa-times"></i></label></td>
                                            </tr>
                                            <tr>
                                              <td>0000-0000-0000</td>
                                              <td>Producto de Prueba 1</td>
                                              <td class="text-center">PZA</td>
                                              <td class="text-center">$ 100</td>
                                              <td class="text-center">2</td>
                                              <td class="text-center">$ 200</td>
                                              <td class="text-center">0</td>
                                              <td class="text-center">$ 32</td>
                                              <td class="text-center">$ 0</td>
                                              <td class="text-center">$ 232</td>
                                              <td class="text-center"><label onclick="saludo()" class="btn"><i class="fas fa-times"></i></label></td>
                                            </tr>
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <!-- Totales -->
                                  <div class="col-lg-6">
                                    <h5> <i class="fas fa-dollar-sign"></i> Totales </h5>
                                    <div class="col row" style="margin-bottom:5px !important;">
                                      <div class="col-md-3">
                                        <label for"subtotal">Subtotal: </label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" name="subtotal" placeholder="$ 0.00" disabled>
                                      </div>
                                    </div>
                                    <div class="col row" style="margin-bottom:5px !important;">
                                      <div class="col-md-3">
                                        <label for="iva">IVA: </label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" name="iva" placeholder="$ 0.00" disabled>
                                      </div>
                                    </div>
                                    <div class="col row" style="margin-bottom:5px !important;">
                                      <div class="col-md-3">
                                        <label for="iva">IEPS: </label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" name="ieps" placeholder="$ 0.00" disabled>
                                      </div>
                                    </div>
                                    <div class="col row" style="margin-bottom:5px !important;">
                                      <div class="col-md-3">
                                        <label for="descuento">Descuento: </label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" name="descuento" placeholder="$ 0.00" disabled>
                                      </div>
                                    </div>
                                    <div class="col row" style="margin-bottom:5px !important;">
                                      <div class="col-md-3">
                                        <label for="total">Total: </label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" name="total" placeholder="$ 0.00" disabled>
                                      </div>
                                    </div>
                                  </div>

                                </div>
                              </div>
                              <div class="col-lg-12 col-md-12 col-sm-12"><hr>
                                <div class="row">

                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './views/modules/components/footer.php'; ?>
        </div>
    </div>
    <!-- ..:: MODALES ::.. -->
    <!-- ..:: Modal Agregar Artículo ::.. -->
    <div class="modal fade" id="modal_nuevo_articulo">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Agregar Artículo </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/usuarios/procesar">
            <div class="modal-body">

            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Agregar </button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
</body>

</html>
