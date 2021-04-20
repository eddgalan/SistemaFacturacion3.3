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
                            <h4 class="card-title">Catálogo Productos y Servicios</h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_agregar_clave">
                              <i class="fas fa-plus-circle fa-sm"></i> Agregar Clave
                            </button>
                          </div>
                        </div>
                        <hr>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <?php require './views/modules/components/notifications.php'; ?>
                          </div>
                          <div class="row">
                            <!-- ..:: Tabla Claves ProdServ ::.. -->
                            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:5px;">
                                <div class="table-sm table-responsive">
                                  <table class="table table-bordered table-hover">
                                      <thead style="font-size:16px;">
                                        <tr class="text-center">
                                          <th>Activo</th>
                                          <th>Clave</th>
                                          <th>Descripción</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:15px;">
                                        <tr>
                                          <td>0000-0000-0000</td>
                                          <td>Producto de Prueba 1</td>
                                          <td class="text-center">PZA</td>
                                          <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown" style="width:100%;">
                      												<button id="btnGroupDrop1" style="background-color: #4e73df !important;" type="button" class="btn btn-info btn_options text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      													<i class="fas fa-ellipsis-h icon_btn_options"></i>
                      												</button>
                      												<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      													<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_editar_producto" onclick="carga_datos_producto()">
                                                  <i class="fas fa-edit color_blue"></i> Editar
                                                </a>
                      													<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_eliminar_producto" onclick="carga_datos_producto()">
                                                  <i class="fas fa-times color_red"></i> Eliminar
                                                </a>
                      												</div>
                      											</div>
                                          </td>
                                        </tr>
                                      </tbody>
                                  </table>
                                </div>
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './views/modules/components/footer.php'; ?>
        </div>
    </div>
    <!-- ..:: MODALES ::.. -->
    <!-- ..:: Modal Agregar Artículo ::.. -->
    <div class="modal fade" id="modal_agregar_clave">
      <div class="modal-dialog modal-lg">
        <form action="<?= $data['host'] ?>/catalogosSAT/prod_serv/add" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"> <i class="fas fa-plus"></i> Agregar Clave ProdServ </h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token']?>">
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label for="cliente"> Clave Producto o servicio: </label><br>
                    <select class="from-control selectpicker" name="clave_prodserv" data-live-search="true">
                      <option value="0" disabled selected>Buscar clave producto/servicio...</option>
                      <?php
                        foreach ($data['cat_prodserv'] as $key => $prodserv) {
                          $html_option = "<option value='". $key ." | ". $prodserv ."'>". $key ." | ". $prodserv ."</option>\n";
                          echo $html_option;
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" name="agregar" class="btn btn-success" disabled> <i class="fas fa-check"></i> Agregar </button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
    <script type="text/javascript" src="../views/assets/js/catsat/prodserv.js"></script>
</body>

</html>
