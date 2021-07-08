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
                            <h4 class="card-title"> Comprobantes | Nuevo Comprobante (CFDI) </h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <a href="<?= $data['host']?>/CFDIs/facturas" class="btn btn-primary waves-effect btn_full">
                              <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                          </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <form>
                            <div class="row">
                              <div class="col-lg-12">
                                <h5> <i class="fas fa-info-circle"></i> Información</h5>
                              </div>
                              <!-- Cliente -->
                              <div class="col-lg-12 col-md-12 col-sm-8">
                                <label for="cliente"> Cliente: </label><br>
                                <select class="from-control selectpicker" name="cliente" data-live-search="true" style="width:100%;">
                                  <option value="0" disabled selected>Buscar por RFC o Nombre del cliente...</option>
                                  <?php
                                    foreach ($data['clientes'] as $cliente) {
                                      $html_option = "<option value='". $cliente['Id']. "'>". $cliente['RFC'] ." | ". $cliente['Nombre'] ."</option>\n";
                                      echo $html_option;
                                    }
                                  ?>
                                </select>
                                <small class="color_red display_none" name="cliente">Seleccione un cliente</small>
                              </div>
                              <!-- Serie -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="serie">Serie: </label>
                                <select class="form-control" name="serie">
                                  <option value="0" selected disabled>---</option>
                                  <?php
                                    foreach ($data['series'] as $serie) {
                                      $html_option = "<option value='". $serie['Serie']. "'>". $serie['Serie'] ."</option>\n";
                                      echo $html_option;
                                    }
                                  ?>
                                </select>
                                <small class="color_red display_none" name="serie">Seleccione una serie</small>
                              </div>
                              <!-- Tipo de Comprobante -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="tipo_comprobante"> Tipo de comprobante: </label>
                                <input type="text" class="form-control" name="tipo_comprobante" disabled>
                              </div>
                              <!-- Fecha -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="fecha"> Fecha: </label>
                                <input type="date" class="form-control" name="fecha" value="<?= $data['fecha'] ?>" required>
                                <small class="color_red display_none" name="fecha">Fecha no válida</small>
                              </div>
                              <!-- Hora -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="hora"> Hora: </label>
                                <input type="time" class="form-control" name="hora" value="<?= $data['hora'] ?>" required>
                                <small class="color_red display_none" name="hora">Hora no válida</small>
                              </div>
                              <!-- Método de Pago -->
                              <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="metodo_pago"> Método de Pago: </label>
                                <select class="form-control" name="metodo_pago">
                                  <option value="0">---</option>
                                  <?php
                                    foreach ($data['metodos_pago'] as $metodo_pago) {
                                      $html_option = "<option value='". $metodo_pago['ClaveMetodo']. "'>". $metodo_pago['ClaveMetodo'] ." | ". $metodo_pago['Descripcion'] ."</option>\n";
                                      echo $html_option;
                                    }
                                  ?>
                                </select>
                                <small class="color_red display_none" name="metodo_pago">Seleccione un Método de Pago</small>
                              </div>
                              <!-- Forma Pago -->
                              <div class="col-lg-3 col-md-6 col-sm-6">
                                <label for="forma_pago"> Forma de Pago: </label>
                                <select class="form-control" name="forma_pago">
                                  <option value="0">---</option>
                                  <?php
                                    foreach ($data['formas_pago'] as $forma_pago) {
                                      $html_option = "<option value='". $forma_pago['ClaveFormaPago']. "'>". $forma_pago['ClaveFormaPago'] ." | ". $forma_pago['Descripcion'] ."</option>\n";
                                      echo $html_option;
                                    }
                                  ?>
                                </select>
                                <small class="color_red display_none" name="forma_pago">Seleccione una forma de pago</small>
                              </div>
                              <!-- Condiciones de Pago -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="condiciones_pago"> Codiciones de pago: </label>
                                <input type="text" class="form-control" name="condiciones_pago">
                              </div>
                              <!-- Uso CFDI -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="uso_cfdi"> Uso CFDI: </label>
                                <select class="form-control" name="uso_cfdi">
                                  <option value="0">---</option>
                                </select>
                                <small class="color_red display_none" name="uso_cfdi">Seleccione un uso de CFDI</small>
                              </div>
                              <!-- Moneda CFDI -->
                              <div class="col-lg-3 col-md-4 col-sm-4">
                                <label for="moneda"> Moneda: </label>
                                <select class="form-control" name="moneda">
                                  <option value="0">---</option>
                                  <?php
                                    foreach ($data['monedas'] as $moneda) {
                                      $html_option = "<option value='". $moneda['ClaveMoneda']. "'>". $moneda['ClaveMoneda'] ." | ". $moneda['Nombre'] ."</option>\n";
                                      echo $html_option;
                                    }
                                  ?>
                                </select>
                                <small class="color_red display_none" name="moneda">Seleccione una moneda</small>
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
                                              <th>Importe</th>
                                              <th>Descuento</th>
                                              <th>IVA</th>
                                              <th>IEPS</th>
                                              <th>Total</th>
                                              <th>Acciones</th>
                                            </tr>
                                          </thead>
                                          <tbody style="font-size:14px;">

                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <!-- Totales -->
                                  <div class="col-lg-5 col-md-6 col-sm-5">
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
                                  <!-- Comentario/Observaciones -->
                                  <div class="col-lg-7 col-md-6 col-sm-7">
                                    <div class="col-lg-12">
                                      <label for="observaciones"><strong>Observaciones </strong>(Opcional): </label>
                                    </div>
                                    <div class="col-lg-12">
                                      <textarea class="form-control" rows="7" maxlength="256" name="observaciones" placeholder="Comentarios u observaciones..."></textarea>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-12 col-md-12 col-sm-12"><hr>
                                <div class="row">
                                  <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                    <small class="display_none color_red" name="msg_prodserv"><strong> No se ha agregado ningún producto o servicio. Capture al menos un artículo para poder continuar</strong></small>
                                  </div>
                                  <div class="col-md-12 text-right">
                                    <button type="button" class="btn btn-success" name="guardar_cfdi"> <i class="far fa-save"></i> Guardar </button>
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
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Agregar Producto o Servicio </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="row">
                <!-- Hidden -->
                <div class="col-md-12 display_none">
                  <!-- Token -->
                  <input type="hidden" name="token" value="<?= $data['token']?>">
                  <!-- id -->
                  <input type="hidden" name="id_producto" disabled>
                  <!-- sku -->
                  <input type="hidden" name="sku" disabled>
                  <!-- descripcion -->
                  <input type="hidden" name="descripcion" disabled>
                  <!-- Clave Unidad -->
                  <input type="hidden" name="clave_unidad" disabled>
                  <!-- Nombre Unidad -->
                  <input type="hidden" name="unidad_desc" disabled>
                  <!-- Tipo Impuesto -->
                  <input type="hidden" name="clave_impuesto" disabled>
                  <!-- Tasa impuesto  -->
                  <input type="hidden" name="tasa_impuesto" disabled>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-8">
                  <label for="producto"> Producto o servicio: </label><br>
                  <select class="from-control selectpicker" name="producto" data-live-search="true" style="width:100%;">
                    <option value="0" disabled selected>Buscar producto/servicio...</option>
                    <?php
                      foreach ($data['productos'] as $producto) {
                        $html_option = "<option value='". $producto['Id']. "'>". $producto['SKU'] ." | ". $producto['Nombre'] ."</option>\n";
                        echo $html_option;
                      }
                    ?>
                  </select>
                </div>
                <!-- Clave SAT -->
                <div class="col-lg-4">
                  <label for="clave_sat">Clave SAT: </label>
                  <input type="text" class="form-control" name="clave_sat" placeholder="00000000" disabled>
                </div>
                <!-- Clave Unidad -->
                <div class="col-lg-4">
                  <label for="clave_unidad"> Unidad: </label>
                  <input type="text" class="form-control" name="unidad" placeholder="-----" disabled>
                </div>
                <!-- Precio -->
                <div class="col-lg-4">
                  <label for="precio"> Precio:  </label>
                  <input type="text" class="form-control" name="precio" placeholder="$ 0.00" disabled>
                </div>
                <!-- Impuesto -->
                <div class="col-lg-4">
                  <label for="impuesto"> Impuesto:  </label>
                  <input type="text" class="form-control" name="impuesto" placeholder="IVA / IEPS | Tasa" disabled>
                </div>
                <!-- Cantidad -->
                <div class="col-lg-4">
                  <label for="cantidad"> Cantidad:  </label>
                  <input type="number" class="form-control" name="cantidad" placeholder="0.00">
                </div>
                <!-- Descuento -->
                <div class="col-lg-4">
                  <label for="descuento"> Descuento:  </label>
                  <input type="number" class="form-control" name="descuento_prod" placeholder="$ 0.00" value="0">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                  <small class="color_red display_none" name="msg_cant_desc">Valor no válido para cantidad o descuento</small>
                  <small class="color_green display_none" name="msg_ok">Se agregó el producto/servicio seleccionado</small>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" name="add_product"class="btn btn-success" disabled> <i class="fas fa-check"></i> Agregar </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- ..:: Modal Editar Producto ::.. -->
    <div class="modal fade" id="modal_editar_producto">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-edit"></i> Editar Producto/Servicio </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="row">
                <!-- Id Producto -->
                <div class="display_none">
                  <input type="hidden" name="id_prod_edit">
                </div>
                <!-- Clave SAT -->
                <div class="col-lg-4">
                  <label for="clave_sat">Clave SAT: </label>
                  <input type="text" class="form-control" name="clave_sat_edit" placeholder="00000000" disabled>
                </div>
                <!-- Clave Unidad -->
                <div class="col-lg-4">
                  <label for="clave_unidad"> Unidad: </label>
                  <input type="text" class="form-control" name="unidad_edit" placeholder="-----" disabled>
                </div>
                <!-- Precio -->
                <div class="col-lg-4">
                  <label for="precio"> Precio:  </label>
                  <input type="text" class="form-control" name="precio_edit" placeholder="$ 0.00" disabled>
                </div>
                <!-- Impuesto -->
                <div class="col-lg-4">
                  <label for="impuesto"> Impuesto:  </label>
                  <input type="text" class="form-control" name="impuesto_edit" placeholder="IVA / IEPS | Tasa" disabled>
                </div>
                <!-- Cantidad -->
                <div class="col-lg-4">
                  <label for="cantidad"> Cantidad:  </label>
                  <input type="number" class="form-control" name="cantidad_edit" placeholder="0.00">
                </div>
                <!-- Descuento -->
                <div class="col-lg-4">
                  <label for="descuento"> Descuento:  </label>
                  <input type="number" class="form-control" name="descuento_prod_edit" placeholder="$ 0.00" value="0">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" name="save_product"class="btn btn-success"> <i class="fas fa-check"></i> Guardar cambios </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- ..:: Modal Editar Producto ::.. -->
    <div class="modal fade" id="modal_eliminar_producto">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-exclamation-circle"></i> Remover producto o servicio </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="row">
                <!-- Id Producto o Servicio -->
                <div class="display_none">
                  <input type="hidden" name="id_prod_remove">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <spam>Está a punto de remover el producto o servicio <strong name="prodserv_name"></strong>,
                  ¿Seguro que desea removerlo?</spam>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                  <small class="display_none color_green">Se ha removido el producto o servicio seleccionado</small>
                  <small class="display_none color_red">Ocurrió un error al remover el producto o servicio seleccionado. Intentelo de nuevo</small>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" name="btn-remove" class="btn btn-success" data-dismiss="modal"> <i class="fas fa-check"></i> Remover </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> No, cerrar ventana </button>
          </div>
        </div>
      </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
    <script type="text/javascript" src="<?=$data['host']?>/views/assets/js/nuevo_cfdi.js"></script>
</body>

</html>
