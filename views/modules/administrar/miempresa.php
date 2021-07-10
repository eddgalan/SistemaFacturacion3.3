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
                            <h4 class="card-title">Mi Empresa</h4>
                          </div>
                        </div>
                        <hr>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <?php require './views/modules/components/notifications.php'; ?>
                          </div>
                          <div class="row">
                            <!-- ..:: Carga de Archivos ::.. -->
                            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:5px;">
                              <?php
                                if( !$data['csd'] ){
                                  require './views/modules/components/carga_csd.php';
                                }
                               ?>
                            </div>
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <h5> <?= $data['emisor']['Nombre'] ?> </h5>
                              </div>
                              <div class="col-lg-5 col-md-5 col-sm-12">
                                <img class="img-fluid" src="<?= $data['host']?>/<?= $data['emisor']['PathLogo'] ?>" style="max-height:200px;">
                              </div>
                              <div class="col-lg-7 col-md-7 col-sm-12">
                              <form method="POST" action="<?= $data['host']?>/administrar/miempresa/process">
                                <div class="row">
                                  <!-- Token -->
                                  <div style="display:none;">
                                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                                    <input type="hidden" name="id_emisor" value="<?= $data['emisor']['Id'] ?>">
                                  </div>
                                  <!-- Nombre -->
                                  <div class="col-lg-8 col-md-6 col-sm-12">
                                    <label for="nombre"> Nombre: </label>
                                    <input type="text" class="form-control" name="nombre" value="<?= $data['emisor']['Nombre'] ?>" placeholder="Nombre o razón social" required autocomplete="off">
                                  </div>
                                  <!-- RFC -->
                                  <div class="col-lg-4 col-md-6 col-sm-12">
                                    <label for="rfc"> RFC: </label>
                                    <input type="text" class="form-control" name="rfc" value="<?= $data['emisor']['RFC'] ?>">
                                  </div>
                                  <!-- Domiclio -->
                                  <div class="col-lg-9 col-md-6 col-sm-12">
                                    <label for="direccion"> Dirección: </label>
                                    <input type="text" class="form-control" name="direccion" value="<?= $data['emisor']['Domicilio'] ?>" placeholder="Dirección completa (Calle, No, etc.)" required autocomplete="off">
                                  </div>
                                  <!-- CP -->
                                  <div class="col-lg-3 col-md-6 col-sm-12">
                                    <label for="codigo_postal"> CP: </label>
                                    <input type="text" class="form-control" name="codigo_postal" value="<?= $data['emisor']['CP'] ?>" placeholder="00000" required autocomplete="off">
                                  </div>
                                  <!-- Tipo de Persona -->
                                  <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label for="persona"> Tipo de Persona: </label>
                                    <select class="form-control" name="persona">
                                      <?php
                                        if( $data['emisor']['Persona']== 'M' ){
                                          echo "<option value='M' selected> Moral </option>\n
                                          <option value='F'> Física </option>";
                                        }elseif ($data['emisor']['Persona']== 'F') {
                                          echo "<option value='M'> Moral </option>\n
                                          <option value='F' selected> Física </option>";
                                        }
                                      ?>
                                    </select>
                                  </div>
                                  <!-- Regimen -->
                                  <div class="col-lg-6 col-md-6 col-sm-12">
                                    <label for="regimen_edit"> Regimen: </label>
                                    <select class='form-control' name='regimen'>
                                      <?php
                                        foreach( $data['regimenes'] as $regimen ){
                                          if( $regimen['regimen_clave'] == $data['emisor']['Regimen'] ){
                                            echo "<option value='". $regimen['regimen_clave'] ." | ". $regimen['regimen_concepto'] ."' selected>".
                                                $regimen['regimen_clave'] ." | ". $regimen['regimen_concepto'].
                                              "</option>";
                                          }else{
                                            echo "<option value='". $regimen['regimen_clave'] ."'>". $regimen['regimen_clave'] ." | ". $regimen['regimen_concepto']. "</option>";
                                          }
                                        }
                                      ?>
                                    </select>
                                  </div>
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                    <hr>
                                  </div>
                                  <!-- Acciones -->
                                  <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                    <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Guardar cambios </button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_csdfiles"> <i class="fas fa-key"></i> Archivos CSD </button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_cambiarlogo"> <i class="far fa-image"></i> Cambiar logo </button>
                                  </div>
                                </div>
                              </form>
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
    <!-- ..:: Modal Carga de Archivos CSD ::.. -->
    <div class="modal fade" id="modal_csdfiles">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-file-upload"></i> Carga de Archivos </h4>
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

                  <div class='col-lg-12 col-md-12 col-sm-12'>
                    <form method='POST' action="" enctype="multipart/form-data">
                      <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:5px;">
                          <div class="table-sm">
                            <table class="table table-bordered">
                              <thead style="font-size:15px;">
                                <tr class="text-center">
                                  <th>Archivo .CER</th>
                                  <th>Archivo .KEY</th>
                                  <th>Contraseña</th>
                                </tr>
                              </thead>
                              <tbody style="font-size:14px;">
                                <tr>
                                  <td><input type="file" name="archivo_cer" accept=".cer" required></td>
                                  <td><input type="file" name="archivo_key" accept=".key" required></td>
                                  <td><input type="password" class='form-control' name="contrasena_archivos" placeholder="********" autocomplete="off" required></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                      </div>
                      <div class="col text-right">
                        <button type="submit" class="btn btn-success">
                          <i class="fas fa-upload"></i> Procesar archivos
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
                      </div>
                    </form>
                  </div>

                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
    <script src="<?= $data['host'] ?>/views/assets/js/admin/miempresa.js"></script>
</body>

</html>
