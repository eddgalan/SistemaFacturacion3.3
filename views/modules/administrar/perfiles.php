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
                            <h4 class="card-title">Perfiles</h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_nuevo_perfil">
                              <i class="fas fa-user-plus"></i> Crear Perfil
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
                                          <th>Usuario</th>
                                          <th>Nombre</th>
                                          <th>Apellido Paterno</th>
                                          <th>Apellido Materno</th>
                                          <th>Correo</th>
                                          <th>Emisor</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:13px;">
                                        <?php
                                          foreach ($data['perfiles'] as $perfil) {
                                            $html_row = ""."\n\t\t\t\t\t\t\t<tr>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $perfil['Id'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $perfil['Username'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $perfil['Nombre'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $perfil['ApellidoPaterno'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $perfil['ApellidoMaterno'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $perfil['Email'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $perfil['NombreEmisor'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>\n".
                                                            "\t\t\t\t\t\t\t\t\t<div class='btn-group' role='group' aria-label='Button group with nested dropdown'  style='width:100%;'>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<button id='btnGroupDrop1' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='background-color: #4e73df !important;'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-ellipsis-h icon_btn_options'></i>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t</button>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_editar_perfil' onclick='carga_datos_perfil(". $perfil['Id'] .")'> <i class='fas fa-user-edit'></i> Editar Perfil</a>\n".
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
    <!-- ..:: Modal Nuevo Perfil ::.. -->
    <div class="modal fade" id="modal_nuevo_perfil">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Crear Perfil </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/perfiles/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                  </div>
                  <!-- Usuario -->
                  <div class="col-lg64 col-md-6 col-sm-12">
                    <label for="user"> Usuario: </label><br>
                    <select class="from-control selectpicker" name="user" data-live-search="true">
                      <option value="0" disabled selected>Buscar usuario...</option>
                      <?php
                        foreach ($data['usuarios'] as $usuario) {
                          $html_option = "<option value='". $usuario['Id'] ."'>". $usuario['Id'] ." | ". $usuario['Username'] ." | ". $usuario['Email'] ."</option>\n";
                          echo $html_option;
                        }
                      ?>
                    </select>
                  </div>
                  <!-- Nombre -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="nombre"> Nombre: </label>
                    <input type="text" class="form-control" name="nombre" required autocomplete="off">
                  </div>
                  <!-- Apellido Paterno -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="apellido_pat"> Apellido Paterno: </label>
                    <input type="text" class="form-control" name="apellido_pat" required autocomplete="off">
                  </div>
                  <!-- Apellido Materno -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="apellido_mat"> Apellido Materno: </label>
                    <input type="text" class="form-control" name="apellido_mat" required autocomplete="off">
                  </div>
                  <!-- Emisor -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="emisor"> Emisor: </label>
                    <select class="from-control selectpicker" name="emisor" data-live-search="true">
                      <option value="0" disabled selected> Seleccionar emisor... </option>
                      <?php
                        foreach ($data['emisores'] as $emisor) {
                          $html_option = "<option value='". $emisor['Id'] ."'>". $emisor['Id'] ." | ". $emisor['Nombre'] ." | ". $emisor['RFC'] ."</option>\n";
                          echo $html_option;
                        }
                      ?>
                    </select>
                  </div>
                  <!-- Puesto -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="puesto"> Puesto: </label>
                    <input type="text" class="form-control" name="puesto" placeholder="Puesto o cargo" required autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" name='create' class="btn btn-success" disabled> <i class="fas fa-check"></i> Crear Perfil </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!-- ..:: Modal Editar Perfil ::.. -->
    <div class="modal fade" id="modal_editar_perfil">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-user-edit"></i> Editar Perfil </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/perfiles/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                    <input type="hidden" name="perfil_id">
                  </div>
                  <!-- Usuario -->
                  <div class="col-lg64 col-md-6 col-sm-12">
                    <label for="user_edit"> Usuario: </label><br>
                    <select class="from-control selectpicker" name="user_edit" data-live-search="true">
                      <option value="0" disabled selected> Cambiar Usuario...</option>
                      <?php
                        foreach ($data['usuarios'] as $usuario) {
                          $html_option = "<option value='". $usuario['Id'] ."'>". $usuario['Id'] ." | ". $usuario['Username'] ." | ". $usuario['Email'] ."</option>\n";
                          echo $html_option;
                        }
                      ?>
                    </select>
                  </div>
                  <!-- Nombre -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="nombre_edit"> Nombre: </label>
                    <input type="text" class="form-control" name="nombre_edit" required autocomplete="off">
                  </div>
                  <!-- Apellido Paterno -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="apellido_pat_edit"> Apellido Paterno: </label>
                    <input type="text" class="form-control" name="apellido_pat_edit" required autocomplete="off">
                  </div>
                  <!-- Apellido Materno -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="apellido_mat_edit"> Apellido Materno: </label>
                    <input type="text" class="form-control" name="apellido_mat_edit" required autocomplete="off">
                  </div>
                  <!-- Emisor -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="emisor_edit"> Emisor: </label>
                    <select class="from-control selectpicker" name="emisor_edit" data-live-search="true">
                      <option value="0" disabled selected> Cambiar Emisor... </option>
                      <?php
                        foreach ($data['emisores'] as $emisor) {
                          $html_option = "<option value='". $emisor['Id'] ."'>". $emisor['Id'] ." | ". $emisor['Nombre'] ." | ". $emisor['RFC'] ."</option>\n";
                          echo $html_option;
                        }
                      ?>
                    </select>
                  </div>
                  <!-- Puesto -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="puesto_edit"> Puesto: </label>
                    <input type="text" class="form-control" name="puesto_edit" placeholder="Puesto o cargo" required autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Actualizar Perfil </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <?php include './views/modules/components/javascript.php'; ?>
    <script src="<?= $data['host'] ?>/views/assets/js/admin/perfiles.js"></script>
    <script type="text/javascript" src="<?= $data['host'] ?>/views/assets/js/datatable/datatables.min.js"></script>
</body>

</html>
