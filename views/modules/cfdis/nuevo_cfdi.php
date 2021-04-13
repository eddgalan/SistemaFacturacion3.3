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
                              <div class="col-lg-6 col-md-6">
                                <label for="cliente"> Cliente: </label>
                                <select class="form-control" name="cliente">
                                  <option value="A">Cliente 1</option>
                                  <option value="B">Cliente 2</option>
                                  <option value="C">Cliente 3</option>
                                </select>
                              </div>
                              <!-- Serie -->
                              <div class="col-lg-3 col-md-6">
                                <label for="serie">Serie (Opcional): </label>
                                <select class="form-control" name="serie">
                                  <option value="A">A</option>
                                  <option value="B">B</option>
                                  <option value="C">C</option>
                                </select>
                              </div>
                              <!-- Folio -->
                              <div class="col-lg-3 col-md-6">
                                <label for="folio"> Folio: </label>
                                <input type="text" class="form-control" name="folio" required>
                              </div>
                              <!-- Fecha -->
                              <div class="col-lg-3 col-md-6">
                                <label for="fecha"> Fecha: </label>
                                <input type="date" class="form-control" name="fecha" required>
                              </div>
                              <!-- Hora -->
                              <div class="col-lg-3 col-md-6">
                                <label for="hora"> Hora: </label>
                                <input type="time" class="form-control" name="hora" required>
                              </div>
                              <!-- Método de Pago -->
                              <div class="col-lg-3 col-md-6">
                                <label for="metodo_pago"> Método de Pago: </label>
                                <select class="form-control" name="metodo_pago">
                                  <option value="A">Método Pago 1</option>
                                  <option value="B">Método Pago 2</option>
                                  <option value="C">Método Pago 3</option>
                                </select>
                              </div>
                              <!-- Forma Pago -->
                              <div class="col-lg-3 col-md-6">
                                <label for="forma_pago"> Forma de Pago: </label>
                                <select class="form-control" name="forma_pago">
                                  <option value="A">Forma Pago 1</option>
                                  <option value="B">Forma Pago 2</option>
                                  <option value="C">Forma Pago 3</option>
                                </select>
                              </div>
                              <!-- Uso CFDI -->
                              <div class="col-lg-3 col-md-6">
                                <label for="uso_cfdi"> Uso CFDI: </label>
                                <select class="form-control" name="uso_cfdi">
                                  <option value="A">Uso 1</option>
                                  <option value="B">Uso 2</option>
                                </select>
                              </div>
                              <!-- Moneda CFDI -->
                              <div class="col-lg-3 col-md-6">
                                <label for="moneda"> Moneda: </label>
                                <select class="form-control" name="moneda">
                                  <option value="A">Moneda 1</option>
                                  <option value="B">Moneda 2</option>
                                </select>
                              </div>
                              <!-- Tipo Cambio -->
                              <div class="col-lg-3 col-md-6">
                                <label for="tipo_cambio"> Tipo de cambio: </label>
                                <input type="text" class="form-control" name="tipo_cambio" required>
                              </div>
                              <!-- Artículos -->
                              <div class="col-lg-12 col-md-12 col-sm-12"><hr>
                                <div class="row">
                                  <div class="col-lg-6 col-md-12 col-sm-12">
                                    <h5> <i class="fas fa-box"></i> Artículos</h5>
                                  </div>
                                  <div class="col-lg-6 col-md-12 col-sm-12 text-right">
                                    <button type="button" class="btn btn-success waves-effect text-capitalize btn_full" data-toggle="modal" data-target="#modal_nuevo_articulo">
                                      <i class="fas fa-plus-circle fa-sm"></i> Agregar artículo
                                    </button>
                                  </div>
                                  <!-- Tabla Artículos -->
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                    <table>

                                    </table>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-12 col-md-12 col-sm-12"><hr>
                                <div class="row">
                                  <div class="col-lg-12">
                                    <h5> <i class="fas fa-dollar-sign"></i> Totales </h5>
                                    <div class="col-lg-4 row">
                                      <div class="col-md-3">
                                        <label for"subtotal">Subtotal: </label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" name="subtotal" placeholder="$ 0.00" disabled>
                                      </div>
                                    </div>
                                    <div class="col-lg-4 row">
                                      <div class="col-md-3">
                                        <label for="iva">IVA: </label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" name="iva" placeholder="$ 0.00" disabled>
                                      </div>
                                    </div>
                                    <div class="col-lg-4 row">
                                      <div class="col-md-3">
                                        <label for="descuento">Descuento: </label>
                                      </div>
                                      <div class="col-md-3">
                                        <input type="text" name="descuento" placeholder="$ 0.00" disabled>
                                      </div>
                                    </div>
                                    <div class="col-lg-4 row">
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
