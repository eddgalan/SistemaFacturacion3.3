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
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <h4 class="card-title"> Perfil </h4>
                          </div>
                        </div>
                        <hr>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <?php require './views/modules/components/notifications.php'; ?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <h5>Nombre Apellidos</h5>
                          </div>
                          <div class="col-lg-5 col-md-5 col-sm-12 text-center">
                            <img class="img-fluid" src="http://localhost/SistemaFacturacion3.3/views/assets/img/Logo.jpg" style="max-height:200px;">
                          </div>
                          <div class="col-lg-7 col-md-7 col-sm-12">
                          <form>
                            <div class="row">
                              <!-- Token -->
                              <div style="display:none;">
                                <input type="hidden" name="token" value="2f70fe8b484de733">
                                <input type="hidden" name="perfil_id">
                              </div>
                              <!-- Nombre -->
                              <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="nombre"> Nombre: </label>
                                <input type="text" class="form-control" name="nombre" placeholder="Escriba su nombre" required autocomplete="off">
                              </div>
                              <!-- Apellido Paterno -->
                              <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="apellido_pat"> Apellido Paterno: </label>
                                <input type="text" class="form-control" name="apellido_pat" placeholder="Escriba su apellido paterno" required autocomplete="off">
                              </div>
                              <!-- Apellido Materno -->
                              <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="apellido_mat"> Apellido Materno: </label>
                                <input type="text" class="form-control" name="apellido_mat" placeholder="Escriba su apellido materno" required autocomplete="off">
                              </div>
                              <!-- Puesto -->
                              <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="puesto"> Puesto: </label>
                                <input type="text" class="form-control" name="puesto" placeholder="Puesto o cargo" required autocomplete="off">
                              </div>
                              <!-- Email -->
                              <div class="col-lg-6 col-md-6 col-sm-12">
                                <label for="email"> Email: </label>
                                <input type="email" class="form-control" name="email" placeholder="usuario@dominio.com" required autocomplete="off">
                              </div>
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <hr>
                              </div>
                              <!-- Actions -->
                              <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_cambiar_contraseña"> <i class="fas fa-key"></i> Cambiar contraseña </button>
                                <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Guardar cambios </button>
                              </div>
                            </div>
                          </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './views/modules/components/footer.php'; ?>
        </div>
    </div>
    <!-- ..:: MODALES ::.. -->
    <!-- ..:: Modal Cambiar Contraseña ::.. -->
    <div class="modal fade" id="modal_cambiar_contraseña">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-key"></i> Cambiar contraseña </h4>
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
                  <!-- New Password -->
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label for="new_pass"> Contraseña: </label>
                    <input type="password" class="form-control" placeholder="Nueva contraseña" name="new_pass" required autocomplete="off">
                  </div>
                  <!-- Confirm Password -->
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <label for="confirm_pass"> Confirmar contraseña: </label>
                    <input type="password" class="form-control" placeholder="Repita su nueva contraseña" name="confirm_pass" required autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success" disabled> <i class="fas fa-check"></i> Cambiar contraseña </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar </button>
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
