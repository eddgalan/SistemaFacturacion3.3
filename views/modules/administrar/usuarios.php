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
                            <h4 class="card-title">Usuarios</h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_nuevo_usuario">
                              <i class="fas fa-user-plus"></i> Crear Usuario
                            </button>
                          </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <?php
                            require './views/modules/components/notifications.php';
                          ?>
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
                                          <th>Id</th>
                                          <th>Estatus</th>
                                          <th>Username</th>
                                          <th>Email</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:15px;">
                                        <tr>
                                          <td class="text-center">000</td>
                                          <td class="text-center">Activo</td>
                                          <td>EddGalan</td>
                                          <td>edd.galan@hotmail.com</td>
                                          <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown" style="width:100%;">
                      												<button id="btnGroupDrop1" style="background-color: #4e73df !important;" type="button" class="btn btn-info btn_options text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      													<i class="fas fa-ellipsis-h icon_btn_options"></i>
                      												</button>
                      												<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      													<a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_editar_usuario" onclick="carga_datos_producto()">
                                                  <i class="fas fa-user-edit"></i> Editar
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
    <!-- ..:: Modal Agregar Unidad ::.. -->
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
                    <input type="text" class="form-control" name="username" placeholder="Username">
                  </div>
                  <!-- Password -->
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="password"> Contraseña: </label>
                    <input type="text" class="form-control" name="password" placeholder="* * * * * * * *">
                  </div>
                  <!-- Email -->
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="email"> Email: </label>
                    <input type="text" class="form-control" name="email" placeholder="alguien@correo.com">
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
    <?php include './views/modules/components/javascript.php'; ?>
</body>

</html>
