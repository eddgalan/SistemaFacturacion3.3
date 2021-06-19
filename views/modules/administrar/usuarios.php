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
                            <h4 class="card-title">Usuarios</h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_nuevo_usuario">
                              <i class="fas fa-user-plus"></i> Crear Usuario
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
                                          <th>Estatus</th>
                                          <th>Username</th>
                                          <th>Email</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:13px;">
                                        <?php
                                          foreach ($data['usuarios'] as $usuario) {
                                            $icon=""; $icon_option = ""; $label_accion ="";
                                            if ($usuario['Estatus']==1){
                                              $icon = "<i class='fas fa-toggle-on color_green icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-off color_red '></i>";
                                              $label_accion = " Desactivar";
                                            }else{
                                              $icon = "<i class='fas fa-toggle-off color_red icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-on color_green'></i>";
                                              $label_accion = " Activar";
                                            }
                                            $html_row = ""."\n\t\t\t\t\t\t\t<tr>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $usuario['Id'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>".
                                                            "\t\t\t\t\t\t\t\t\t<a href='". $data['host'] ."/administrar/usuarios/switch_active/". $usuario['Id'] ."/". $usuario['Estatus'] ."'>" . $icon . "</td> \n".
                                                          "\t\t\t\t\t\t\t\t<td>". $usuario['Username'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>". $usuario['Email'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>\n".
                                                            "\t\t\t\t\t\t\t\t\t<div class='btn-group' role='group' aria-label='Button group with nested dropdown'  style='width:100%;'>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<button id='btnGroupDrop1' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='background-color: #4e73df !important;'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-ellipsis-h icon_btn_options'></i>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t</button>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_editar_usuario' onclick='carga_datos_usuario(". $usuario['Id'] .")'> <i class='fas fa-user-edit'></i> Editar Usuario</a>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='". $data['host'] ."/administrar/usuarios/switch_active/". $usuario['Id'] ."/". $usuario['Estatus'] ."' >". $icon_option . $label_accion ."</a>\n".
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
    <!-- ..:: Modal Crear Nuevo usuario ::.. -->
    <div class="modal fade" id="modal_nuevo_usuario">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Crear usuario </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/usuarios/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                  </div>
                  <!-- Username -->
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="username"> Nombre de usuario: </label>
                    <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off">
                  </div>
                  <!-- Password -->
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="password"> Contraseña: </label>
                    <input type="password" class="form-control" name="password" placeholder="* * * * * * * *" required autocomplete="off">
                  </div>
                  <!-- Email -->
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="email"> Email: </label>
                    <input type="text" class="form-control" name="email" placeholder="alguien@correo.com" required autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Crear usuario </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!-- ..:: Modal Editar Usuario ::.. -->
    <div class="modal fade" id="modal_editar_usuario">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-user-edit"></i> Editar Usuario </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/usuarios/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                    <input type="hidden" name="id_usuario" value="<?= $data['token'] ?>">
                  </div>
                  <!-- Estatus -->
                  <div class="col-md-12">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="user_activo"> Activo
                      </label>
                    </div>
                  </div><br>
                  <!-- Username -->
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for="username_edit"> Nombre de usuario: </label>
                    <input type="text" class="form-control" name="username_edit" placeholder="Username" required autocomplete="off">
                  </div>
                  <!-- Password -->
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for="password_edit"> Actualizar contraseña: </label>
                    <input type="password" class="form-control" name="password_edit" placeholder="* * * * * * * *" autocomplete="off">
                  </div>
                  <!-- Email -->
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <label for="email_edit"> Email: </label>
                    <input type="text" class="form-control" name="email_edit" placeholder="alguien@correo.com" required autocomplete="off">
                  </div>
                  <!-- Grupos -->
                  <div class='col-lg-12 col-md-12 col-sm-12'>
                    <div class='row'>
                      <div class="col-md-12">
                        <label for="grupos">Grupos: </label>
                      </div>
                      <!-- Select Grupo -->
                      <div class="col-lg-6 col-md-6 col-sm-12">
                        <select class="form-control" name="grupos">
                          <option value="0" selected disabled> Seleccione un grupo </option>
                          <?php
                            foreach( $data['grupos'] as $grupo ){
                              echo "<option value='". $grupo['Id'] ."'>". $grupo['Nombre'] ."</option>\n";
                            }
                          ?>
                        </select>
                      </div>
                      <!-- Botón Agregar -->
                      <div class="col-lg-6 col-md-6 col-sm-12" style="margin-left: -15px;">
                        <button type="button" class="btn btn-success" name="add_group" disabled>
                          <i class="fas fa-plus"></i> Agregar
                        </button>
                      </div>
                      <!-- MSG Resultado del AJAX -->
                      <div class='col-lg-12 col-md-12 col-sm-12 text-center'>
                        <small class="color_green display_none" name="msg_ok"><strong>Se agregó el usuario al grupo indicado</strong></small>
                        <small class="color_red display_none" name="msg_error"><strong>Ocurrió un error al agregar el usuario al grupo indicado</strong></small>
                        <small class="color_red display_none" name="msg_exist"><strong>El usuario ya se encuentra dentro del grupo indicado</strong></small>
                        <small class="color_green display_none" name="msg_remove"><strong>Se eliminó al usuario del grupo</strong></small>
                      </div>
                      <!-- Listado de grupos -->
                      <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:10px;">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <ul class="list-group" name="group_list">
                          </ul>
                        </div>
                      </div>
                    </div>
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
    <?php include './views/modules/components/javascript.php'; ?>
    <script type="text/javascript" src="<?= $data['host'] ?>/views/assets/js/datatable/datatables.min.js"></script>
    <script src="<?= $data['host'] ?>/views/assets/js/usuarios.js"></script>
</body>

</html>
