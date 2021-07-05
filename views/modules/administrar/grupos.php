<!DOCTYPE html>
<html>

<head>
    <?php include './views/modules/components/head.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?= $data['host'] ?>/views/assets/js/datatable/datatables.min.css"/>
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
                            <h4 class="card-title">Grupos</h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_nuevo_grupo">
                              <i class="fas fa-user-plus"></i> Crear Grupo
                            </button>
                          </div>
                        </div>
                        <hr>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <?php require './views/modules/components/notifications.php'; ?>
                          </div>
                          <div class="row">
                            <!-- ..:: Tabla Usuarios ::.. -->
                            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:5px;">
                                <div class="table-sm table-responsive">
                                  <table class="table table-bordered table-hover">
                                      <thead style="font-size:16px;">
                                        <tr class="text-center">
                                          <th>Id</th>
                                          <th>Nombre</th>
                                          <th>Descripcion</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:13px;">
                                        <?php
                                          foreach ($data['grupos'] as $grupo) {
                                            $html_row = ""."\n\t\t\t\t\t\t\t<tr>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $grupo['Id'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>". $grupo['Nombre'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>". $grupo['Descripcion'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>\n".
                                                            "\t\t\t\t\t\t\t\t\t<div class='btn-group' role='group' aria-label='Button group with nested dropdown' style='width:100%;'>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<button id='btnGroupDrop1' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='background-color: #4e73df !important;'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-ellipsis-h icon_btn_options'></i>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t</button>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_editar_grupo' onclick='carga_datos(". $grupo['Id'] .")'> <i class='fas fa-user-edit'></i> Editar Grupo</a>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_permisos' onclick='carga_permisos(". $grupo['Id'] .")'> <i class='fas fa-user-lock'></i> Permisos </a>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t</div>\n".
                                                            "\t\t\t\t\t\t\t\t\t</div>\n".
                                                          "\t\t\t\t\t\t\t\t</td>\n".
                                                        "\t\t\t\t\t\t\t\t</tr>\n";
                                            echo $html_row;
                                          }
                                        ?>
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
    <!-- ..:: Modal Crear Nuevo Grupo ::.. -->
    <div class="modal fade" id="modal_nuevo_grupo">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Crear Grupo </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/grupos/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                  </div>
                  <!-- Nombre -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="grupo"> Nombre del grupo: </label>
                    <input type="text" class="form-control" name="grupo" placeholder="Ej. Admin, Vendedores, Clientes, etc" required autocomplete="off">
                  </div>
                  <!-- Descripción -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="descripcion"> Descripción: </label>
                    <input type="text" class="form-control" name="descripcion" placeholder="Breve descripción del grupo" required autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Crear Grupo </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!-- ..:: Modal Editar Usuario ::.. -->
    <div class="modal fade" id="modal_editar_grupo">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-user-edit"></i> Editar Grupo </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/grupos/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                    <input type="hidden" name="id_grupo">
                  </div>
                  <!-- Nombre -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="grupo"> Nombre del grupo: </label>
                    <input type="text" class="form-control" name="grupo_edit" placeholder="Ej. Admin, Vendedores, Clientes, etc" required autocomplete="off">
                  </div>
                  <!-- Descripción -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="descripcion"> Descripción: </label>
                    <input type="text" class="form-control" name="descripcion_edit" placeholder="Breve descripción del grupo" required autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Guardar cambios </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!-- ..:: Modal Permisos ::.. -->
    <div class="modal fade" id="modal_permisos">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="far fa-hand-paper"></i> Permisos del Grupo <span name="nom_grupo">'Nombre_Grupo'</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/grupos/permisos/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                    <input type="hidden" name="id_permiso">
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    Desde esta sección puede administrar el acceso a las diferentes secciones o menús del sistema.
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:15px;">
                    <!-- Navbars -->
                    <ul class="nav nav-tabs">
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-administrar" style="padding-left:10px;">Administrar</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-comprobantes" style="padding-left:10px;">Comprobantes</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-reportes" style="padding-left:10px;">Reportes</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-catsat" style="padding-left:10px;">Catálogos SAT</a>
                      </li>
                    </ul>
                    <!-- Tabpanes -->
                    <div class="tab-content">
                      <div class="tab-pane container active" id="tab-administrar">
                        <div class="row">
                          <!-- ..:: Usuario ::.. -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="admin_usuario"> Usuarios
                              </label>
                            </div>
                          </div>
                          <!-- Grupos -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="admin_grupos"> Grupos
                              </label>
                            </div>
                          </div>
                          <!-- Perfiles -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="admin_perfiles"> Perfiles
                              </label>
                            </div>
                          </div>
                          <!-- Emisores -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="admin_emisores"> Emisores
                              </label>
                            </div>
                          </div>
                          <!-- Clientes -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="admin_clientes"> Clientes
                              </label>
                            </div>
                          </div>
                          <!-- Productos y servicios -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="admin_prodserv"> Productos y servicios
                              </label>
                            </div>
                          </div>
                          <!-- Series -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="admin_series"> Series
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- ..:: Comprobantes ::.. -->
                      <div class="tab-pane container" id="tab-comprobantes">
                        <div class="row">
                          <!-- Comprobantes -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="comprobantes_facturas"> Facturas
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- ..:: Reportes ::.. -->
                      <div class="tab-pane container" id="tab-reportes">
                        <div class="row">
                          <!-- Reporte Mensual -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="report_reportmensual"> Reporte Mensual
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- ..:: Catalogo SAT ::.. -->
                      <div class="tab-pane container" id="tab-catsat">
                        <div class="row">
                          <!-- Claves de productos y servicios -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="catsat_prodserv"> Claves de productos y servicios
                              </label>
                            </div>
                          </div>
                          <!-- Unidades -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="catsat_unidades"> Catálogo de Unidades
                              </label>
                            </div>
                          </div>
                          <!-- Formas de Pago -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="catsat_formaspago"> Catálogo de Formas de Pago
                              </label>
                            </div>
                          </div>
                          <!-- Monedas -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="catsat_monedas"> Catálogo de Monedas
                              </label>
                            </div>
                          </div>
                          <!-- Impuestos -->
                          <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="catsat_impuestos"> Impuestos
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" name="save" class="btn btn-success"> <i class="fas fa-check"></i> Guardar cambios </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
    <script type="text/javascript" src="<?= $data['host'] ?>/views/assets/js/datatable/datatables.min.js"></script>
    <script src="<?= $data['host'] ?>/views/assets/js/admin/grupos.js"></script>
</body>

</html>
