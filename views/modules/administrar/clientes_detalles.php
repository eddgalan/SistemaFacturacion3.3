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
                            <h4 class="card-title"> <i class="far fa-id-card"></i> Información del cliente </h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <a href="<?= $data['host'] ?>/administrar/clientes" class="btn btn-primary waves-effect btn_full">
                              <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                          </div>
                        </div>
                        <hr>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <?php require './views/modules/components/notifications.php'; ?>
                          </div>
                          <div class="row">
                            <div class='col-lg-12 col-md-12 col-sm-12' style="padding-left: 0px;">
                              <h5><?= $data['cliente']['Nombre'] ?></h5>
                            </div>
                            <!-- Información del cliente -->
                            <div class='col-lg-5 col-md-4 col-sm-12' style="border: solid 1px #DFDFDF; border-radius:10px; padding-top:10px; padding-bottom:10px;">
                              <div class='col-lg-12 col-md-12 col-sm-12' style="padding:0px;">
                                <h5> <i class="far fa-file-alt"></i> Información</h5>
                              </div>
                              <hr>
                              <form action="<?= $data['host'] ?>/administrar/clientes/process" method="POST">
                                <div class='row'>
                                  <!-- Forbidden Fields -->
                                  <div class='col-lg-12 col-md-12 col-sm-12 display_none'>
                                    <input type="forbidden" name='token' value="<?= $data['token']?>">
                                    <input type="forbidden" name='id_cliente' value="<?= $data['cliente']['Id']?>">
                                  </div>
                                  <!-- Nombre o razón social -->
                                  <div class='col-lg-12 col-md-12 col-sm-12'>
                                    <label for="nombre">Nombre o razón social: </label>
                                    <input type="text" class='form-control' name='nombre_edit' value="<?= $data['cliente']['Nombre']?>">
                                  </div>
                                  <!-- RFC -->
                                  <div class='col-lg-6 col-md-12 col-sm-12'>
                                    <label for="rfc">RFC: </label>
                                    <input type="text" class='form-control' name='rfc_edit' value="<?= $data['cliente']['RFC']?>">
                                  </div>
                                  <!-- Tipo de Persona -->
                                  <div class='col-lg-6 col-md-12 col-sm-12'>
                                    <label for="tipo_persona">Tipo de persona: </label><br>
                                    <select class='form-control' name='tipo_persona_edit'>
                                      <option value='0' disabled>Seleccione Tipo</option>
                                      <?php
                                        if( $data['cliente']['TipoPersona']=='M' ){
                                          echo "<option value='M' selected>Moral</option>\n";
                                          echo "<option value='F'>Física</option>\n";
                                        }elseif( $data['cliente']['TipoPersona']=='F' ){
                                          echo "<option value='M'>Moral</option>\n";
                                          echo "<option value='F' selected>Física</option>\n";
                                        }
                                      ?>
                                    </select>
                                  </div>
                                  <!-- Dirección -->
                                  <div class='col-lg-12 col-md-12 col-sm-12'>
                                    <label for="direccion">Dirección: </label>
                                    <input type="text" class='form-control' name='direccion_edit' value="<?= $data['cliente']['Direccion']?>">
                                  </div>
                                  <!-- Telefono -->
                                  <div class='col-lg-6 col-md-12 col-sm-12'>
                                    <label for="telefono">Teléfono: </label>
                                    <input type="text" class='form-control' name='telefono_edit' value="<?= $data['cliente']['Telefono']?>">
                                  </div>
                                  <!-- Correo -->
                                  <div class='col-lg-6 col-md-12 col-sm-12'>
                                    <label for="correo">Correo: </label>
                                    <input type="email" class='form-control' name='correo_edit' value="<?= $data['cliente']['Correo']?>">
                                  </div>
                                  <!-- Submit -->
                                  <div class='col-lg-12 col-md-12 col-sm-12 text-right'>
                                    <hr>
                                    <button type="submit" class='btn btn-outline-success'> <i class="fas fa-check"></i> Actualizar </button>
                                  </div>
                                </div>
                              </form>
                            </div>
                            <!-- Contactos  -->
                            <div class='col-lg-7 col-md-4 col-sm-12' style="border: solid 1px #DFDFDF; border-radius:10px; padding-top:10px; padding-bottom:10px;">
                              <div class='row'>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                  <h5><i class="fas fa-address-book"></i> Contactos</h5>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                                  <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_nuevo_contacto">
                                    <i class="fas fa-plus"></i> Nuevo
                                  </button>
                                </div>
                                <!--- Contactos -->
                                <div class='col-lg-12 col-md-12 col-sm-12'>
                                  <!-- Nav tabs -->
                                  <ul class="nav nav-tabs">
                                  <?php
                                    $activo = "active";
                                    foreach( $data['contactos'] as $contacto ){
                                      echo "<li class='nav-item'>
                                        <a class='nav-link ". $activo ."' data-toggle='tab' href='#tab-pane". $contacto['Id'] ."' style='padding-left:10px;'>". $contacto['Alias'] ."</a>
                                      </li>";
                                      $activo = "";
                                    }
                                  ?>
                                  </ul>
                                  <!-- Tab panes -->
                                  <div class="tab-content">
                                    <?php
                                    $activo = "active";
                                    foreach( $data['contactos'] as $contacto ){
                                      echo
                                      "<div class='tab-pane container ". $activo ."' id='tab-pane". $contacto['Id'] ."'>\n
                                        <form method='POST' action='". $data['host'] ."/administrar/contactos/process'>
                                          <div class='row'>
                                            <!-- Forbidden -->
                                            <div class='display_none'>
                                              <input type='text' name='token' value='". $data['token'] ."'>
                                              <input type='text' name='contacto_id' value='". $contacto['Id'] ."'>
                                              <input type='text' name='cliente_id' value='". $data['cliente']['Id'] ."'>
                                            </div>
                                            <!-- Alias -->
                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                              <lable for='alias_edit'>Alias: </label>
                                              <input type='text' class='form-control' name='alias_edit' value='". $contacto['Alias'] ."' placeholder='Nombre o sobrenombre del contacto'>
                                            </div>
                                            <!-- Nombre -->
                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                              <lable for='nombre_edit'>Nombre(s): </label>
                                              <input type='text' class='form-control' name='nombre_edit' value='". $contacto['Nombre'] ."' placeholder='nombre(s) del contacto' autocomplete='off' required>
                                            </div>
                                            <!-- Apellido Paterno -->
                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                              <lable for='apellido_pat'>Apellido Paterno: </label>
                                              <input type='text' class='form-control' name='apellido_pat' value='". $contacto['ApellidoPaterno'] ."' autocomplete='off' required>
                                            </div>
                                            <!-- Apellido Materno -->
                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                              <lable for='apellido_mat'>Apellido Materno: </label>
                                              <input type='text' class='form-control' name='apellido_mat' value='". $contacto['ApellidoMaterno'] ."' autocomplete='off' required>
                                            </div>
                                            <!-- Puesto -->
                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                              <lable for='puesto'> Puesto: </label>
                                              <input type='text' class='form-control' name='puesto' value='". $contacto['Puesto'] ."' placeholder='Puesto o cargo del contacto' autocomplete='off' required>
                                            </div>
                                            <!-- Email -->
                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                              <lable for='email'> Email: </label>
                                              <input type='email' class='form-control' name='email' value='". $contacto['Email'] ."' placeholder='alguien@correo.com' autocomplete='off' required>
                                            </div>
                                            <!-- Teléfono 1 -->
                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                              <lable for='tel_1'> Teléfono 1: </label>
                                              <input type='text' class='form-control' name='tel_1' value='". $contacto['Num1'] ."' placeholder='10 o 12 dígitos' autocomplete='off' required>
                                            </div>
                                            <!-- Teléfono 2 -->
                                            <div class='col-lg-6 col-md-6 col-sm-12'>
                                              <lable for='tel_2'> Teléfono 2: </label>
                                              <input type='text' class='form-control' name='tel_2' value='". $contacto['Num2'] ."' placeholder='(Opcional)' autocomplete='off'>
                                            </div>
                                            <!-- Actions -->
                                            <div class='col-lg-12 col-md-12 col-sm-12 text-right'>
                                              <hr>
                                              <a class='btn btn-outline-primary' href='mailto:". $contacto['Email'] ."'> <i class='fas fa-envelope-open-text'></i> Enviar Email </a>
                                              <button type='submit' class='btn btn-outline-success'> <i class='fas fa-check'></i> Guardar </button>
                                              <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modal_confirm_del' onclick='set_contacto_id(". $contacto['Id'] .")'> <i class='far fa-trash-alt'></i> Eliminar </button>
                                            </div>
                                          </div>
                                        </form>
                                      </div>";
                                      $activo ="";
                                    }
                                    ?>
                                  </div>
                                </div>
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
    <!-- ..:: Modal Nuevo Contacto ::.. -->
    <div class="modal fade" id="modal_nuevo_contacto">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Nuevo contacto </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method='POST' action="<?= $data['host'] ?> /administrar/contactos/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Forbidden -->
                  <div class='display_none'>
                    <input type='text' name='token' value="<?= $data['token'] ?>">
                    <input type='text' name='cliente_id' value="<?= $data['cliente']['Id'] ?>">
                  </div>
                  <!-- Alias -->
                  <div class='col-lg-6 col-md-6 col-sm-12'>
                    <lable for='alias'>Alias: </label>
                    <input type='text' class='form-control' name='alias' placeholder="Ej. Contador Juan Pérez" autocomplete="off" required>
                  </div>
                  <!-- Nombre -->
                  <div class='col-lg-6 col-md-6 col-sm-12'>
                    <lable for='nombre'>Nombre(s): </label>
                    <input type='text' class='form-control' name='nombre' placeholder="Nombre(s) de su contacto" autocomplete="off" required>
                  </div>
                  <!-- Apellido Paterno -->
                  <div class='col-lg-6 col-md-6 col-sm-12'>
                    <lable for='apellido_pat'>Apellido Paterno: </label>
                    <input type='text' class='form-control' name='apellido_pat' placeholder="Apellido Paterno" autocomplete="off" required>
                  </div>
                  <!-- Apellido Materno -->
                  <div class='col-lg-6 col-md-6 col-sm-12'>
                    <lable for='apellido_mat'>Apellido Materno: </label>
                    <input type='text' class='form-control' name='apellido_mat' placeholder="Apellido Materno" autocomplete="off" required>
                  </div>
                  <!-- Puesto -->
                  <div class='col-lg-6 col-md-6 col-sm-12'>
                    <lable for='puesto'> Puesto: </label>
                    <input type='text' class='form-control' name='puesto' placeholder="Puesto o cargo" autocomplete="off" required>
                  </div>
                  <!-- Email -->
                  <div class='col-lg-6 col-md-6 col-sm-12'>
                    <lable for='email'> Email: </label>
                    <input type='email' class='form-control' name='email' placeholder="micontacto@dominio.com" autocomplete="off" required>
                  </div>
                  <!-- Teléfono 1 -->
                  <div class='col-lg-6 col-md-6 col-sm-12'>
                    <lable for='tel_1'> Teléfono 1: </label>
                    <input type='text' class='form-control' name='tel_1' placeholder="Número a 10 o 12 dígitos" autocomplete="off" required>
                  </div>
                  <!-- Teléfono 2 -->
                  <div class='col-lg-6 col-md-6 col-sm-12'>
                    <lable for='tel_2'> Teléfono 2: </label>
                    <input type='text' class='form-control' name='tel_2' placeholder="(Opcional)" autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Crear contacto </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Confirmación Eliminar Contacto -->
    <div class="modal fade" id="modal_confirm_del">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-exclamation-triangle"></i> Eliminar contacto </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/contactos/delete">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div class='display_none'>
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                    <input type='hidden' name='cliente_id' value="<?= $data['cliente']['Id'] ?>">
                    <input type='hidden' name='contacto_id'>
                  </div>
                  <!-- Msg Confirmación -->
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <spam>Está a punto de eliminar un contacto. ¿Seguro que desea eliminarlo?</spam>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Si, eliminar </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> No, cerrar ventana </button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <?php include './views/modules/components/javascript.php'; ?>
    <script src="<?= $data['host'] ?>/views/assets/js/admin/clientes.js"></script>
</body>

</html>
