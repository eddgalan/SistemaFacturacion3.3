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
                            <h4 class="card-title"> Proveedores Autorizados de Certificación (PACs) </h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modad_add_pac">
                              <i class="fas fa-plus"></i> Agregar Nuevo
                            </button>
                          </div>
                        </div>
                        <hr>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <?php require './views/modules/components/notifications.php'; ?>
                          </div>
                          <div class="row">
                            <!-- ..:: Tabla Clientes ::.. -->
                            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:5px;">
                                <div class="table-sm table-responsive">
                                  <table class="table table-bordered table-hover">
                                      <thead style="font-size:16px;">
                                        <tr class="text-center">
                                          <th>Estatus</th>
                                          <th>Nombre</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:13px;">
                                        <?php
                                          foreach ($data['pacs'] as $pac){
                                            $icon=""; $icon_option = ""; $label_accion ="";
                                            if ($pac['Estatus']==1){
                                              $icon = "<i class='fas fa-toggle-on color_green icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-off color_red '></i>";
                                              $label_accion = " Desactivar";
                                            }else{
                                              $icon = "<i class='fas fa-toggle-off color_red icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-on color_green'></i>";
                                              $label_accion = " Activar";
                                            }
                                            $html_row = ""."\n\t\t\t\t\t\t\t<tr>\n".
                                            "\t\t\t\t\t\t\t\t<td class='text-center'>".
                                              "\t\t\t\t\t\t\t\t\t<a href='". $data['host'] ."/administrar/pacs/switch_active/". $pac['Id'] ."/". $pac['Estatus'] ."'>" . $icon . "</td> \n".
                                                          "\t\t\t\t\t\t\t\t<td>". $pac['Nombre'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>\n".
                                                            "\t\t\t\t\t\t\t\t\t<div class='btn-group' role='group' aria-label='Button group with nested dropdown' style='width:100%;'>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<button id='btnGroupDrop1' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='background-color: #4e73df !important;'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-ellipsis-h icon_btn_options'></i>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t</button>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modad_edit_pac' onclick='carga_datos_pac(". $pac['Id'] .")'> <i class='fas fa-edit'></i> Editar </a>\n".
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
    <!-- ..:: Modal Nuevo PAC ::.. -->
    <div class="modal fade" id="modad_add_pac">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Agregar PAC </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/pacs/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                  </div>
                  <!-- Nombre -->
                  <div class="col-lg-7 col-md-7 col-sm-12">
                    <label for="nombre_pac"> Nombre: </label>
                    <input type="text" class="form-control" name="nombre_pac" placeholder="Nombre del PAC" required autocomplete="off">
                  </div>
                  <!-- Nombre Corto -->
                  <div class="col-lg-5 col-md-5 col-sm-12">
                    <label for="nombre_corto"> Nombre corto: </label>
                    <input type="text" class="form-control" name="nombre_corto" placeholder="Nombre corto" required autocomplete="off">
                  </div>
                  <!-- EndPoint -->
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label for="endpoint"> URL Producción: </label>
                    <input type="text" class="form-control" name="endpoint" placeholder="https//pac/endpoint/producción" required autocomplete="off">
                  </div>
                  <!-- EndPoint -->
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label for="endpoint_pruebas"> URL para pruebas: </label>
                    <input type="text" class="form-control" name="endpoint_pruebas" placeholder="https://pac/endpoint/pruebas" required autocomplete="off">
                  </div>
                  <!-- Usuario -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="usuario"> Usuario: </label>
                    <input type="text" class="form-control" name="usuario" placeholder="" required autocomplete="off">
                  </div>
                  <!-- Contraseña -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="pass"> Contraseña: </label>
                    <input type="password" class="form-control" name="pass" placeholder="* * * * * * * *" required autocomplete="off">
                  </div>
                  <!-- Observaciones -->
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label for="observaciones"> Observaciones: </label>
                    <textarea rows="3" class="form-control" name="observaciones"></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" name='send'class="btn btn-success"> <i class="fas fa-check"></i> Agregar </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!-- ..:: Modal Editar PAC ::.. -->
    <div class="modal fade" id="modad_edit_pac">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Agregar PAC </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/pacs/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                    <input type="hidden" name="id_pac">
                  </div>
                  <!-- Nombre -->
                  <div class="col-lg-7 col-md-6 col-sm-12">
                    <label for="nombre_pac_edit"> Nombre: </label>
                    <input type="text" class="form-control" name="nombre_pac_edit" placeholder="Nombre del PAC" required autocomplete="off">
                  </div>
                  <!-- Nombre Corto -->
                  <div class="col-lg-5 col-md-6 col-sm-12">
                    <label for="nombre_corto_edit"> Nombre corto: </label>
                    <input type="text" class="form-control" name="nombre_corto_edit" placeholder="Nombre corto" required autocomplete="off">
                  </div>
                  <!-- EndPoint -->
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label for="endpoint_edit"> URL Producción: </label>
                    <input type="text" class="form-control" name="endpoint_edit" placeholder="https//pac/endpoint/producción" required autocomplete="off">
                  </div>
                  <!-- EndPoint -->
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label for="endpoint_pruebas_edit"> URL para pruebas: </label>
                    <input type="text" class="form-control" name="endpoint_pruebas_edit" placeholder="https://pac/endpoint/pruebas" required autocomplete="off">
                  </div>
                  <!-- Usuario -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="usuario_edit"> Usuario: </label>
                    <input type="text" class="form-control" name="usuario_edit" placeholder="" required autocomplete="off">
                  </div>
                  <!-- Contraseña -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="pass_edit"> Contraseña: </label>
                    <input type="password" class="form-control" name="pass_edit" placeholder="* * * * * * * *" required autocomplete="off">
                  </div>
                  <!-- Observaciones -->
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label for="observaciones_edit"> Observaciones: </label>
                    <textarea rows="3" class="form-control" name="observaciones_edit"></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" name='send'class="btn btn-success"> <i class="fas fa-check"></i> Agregar </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <?php include './views/modules/components/javascript.php'; ?>
    <script type="text/javascript" src="<?= $data['host'] ?>/views/assets/js/datatable/datatables.min.js"></script>
    <script src="<?= $data['host'] ?>/views/assets/js/admin/pac.js"></script>
</body>

</html>
