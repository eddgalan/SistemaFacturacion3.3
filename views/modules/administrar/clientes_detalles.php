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
                                  <div class='col-lg-12 col-md-12 col-sm-12 text-right'><br>
                                    <button type="submit" class='btn btn-success'> <i class="fas fa-check"></i> Actualizar </button>
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
                                  <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_nuevo_usuario">
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
                                      echo "<div class='tab-pane container ". $activo ."' id='tab-pane". $contacto['Id'] ."'>\n
                                      ". $contacto['Alias'] ."
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
    <!-- ..:: Modal Nuevo Cliente ::.. -->
    <div class="modal fade" id="modal_add">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Nuevo Cliente </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/clientes/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                  </div>
                  <!-- nombre -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="nombre"> Nombre: </label>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre o razón social" required autocomplete="off">
                  </div>
                  <!-- RFC -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="rfc"> RFC: </label>
                    <input type="text" class="form-control" name="rfc" placeholder="RFC" required autocomplete="off">
                  </div>
                  <!-- Tipo de Persona -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="tipo_persona">Tipo Persona: </label>
                    <select class='form-control' name='tipo_persona'>
                      <option value='0' selected disabled>Seleccione un Tipo de Persona</option>
                      <option value='M'>Moral</option>
                      <option value='F'>Física</option>
                    </select>
                  </div>
                  <!-- Dirección -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="direccion"> Dirección: </label>
                    <input type="text" class="form-control" name="direccion" placeholder="Calle, No. Int, No. Ext, Ciudad, Estado" required autocomplete="off">
                  </div>
                  <!-- Telefono -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="telefono"> Telefono: </label>
                    <input type="text" class="form-control" name="telefono" placeholder="55 00 00 00 00" required autocomplete="off">
                  </div>
                  <!-- Correo -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="correo"> Correo: </label>
                    <input type="email" class="form-control" name="correo" placeholder="cliente@correo.com" required autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" name='send'class="btn btn-success" disabled> <i class="fas fa-check"></i> Agregar </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>

    <?php include './views/modules/components/javascript.php'; ?>
    <script src="<?= $data['host'] ?>/views/assets/js/admin/clientes.js"></script>
</body>

</html>
