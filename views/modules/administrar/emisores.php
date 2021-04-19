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
                            <h4 class="card-title">Emisores</h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_nuevo_emisor">
                              <i class="fas fa-plus"></i> Nuevo Emisor
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
                                          <th>Estatus</th>
                                          <th>Nombre</th>
                                          <th>RFC</th>
                                          <th>Tipo Persona</th>
                                          <th>PAC</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:15px;">
                                        <tr>
                                          <td class="text-center">Activo</td>
                                          <td class="text-center">Marvel Comics México</td>
                                          <td>GARE970125XXX</td>
                                          <td>Moral</td>
                                          <td>PAC 1 </td>
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
    <div class="modal fade" id="modal_nuevo_emisor">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Nuevo Emisor </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/emisor/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                  </div>
                  <!-- Nombre | Razón Social -->
                  <div class="col-lg-8 col-md-12 col-sm-12">
                    <label for="nombre"> Nombre o razón social: </label>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre emisor o razón social" required>
                  </div>
                  <!-- RFC -->
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="rfc"> RFC: </label>
                    <input type="text" class="form-control" name="rfc" placeholder="AAA010101AAA" required>
                  </div>
                  <!--
                  Domicilio
                  <div class="col-lg-8 col-md-8 col-sm-12">
                    <label for="domicilio"> Domicilio: </label>
                    <input type="text" class="form-control" name="domicilio" placeholder="Calle, No Int, No Ext, Municipio/Delegación, Estado" required>
                  </div>
                  CP
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="cp"> CP: </label>
                    <input type="text" class="form-control" name="cp" placeholder="12345" required>
                  </div>
                  Tipo de Persona
                  <div class="col-lg-3 col-md-5 col-sm-12">
                    <label for="tipo_persona"> Tipo de persona: </label>
                    <select class="form-control" name="tipo_persona" required>
                      <option value="0" selected disabled>Seleccionar tipo</option>
                      <option value="M">Moral</option>
                      <option value="F">Física</option>
                    </select>
                  </div>
                  Regimen
                  <div class="col-lg-9 col-md-12 col-sm-12">
                    <label for="regimen"> Regimen: </label>
                    <select class="form-control" name="regimen" disabled required>
                    </select>
                  </div>
                   -->
                  <!-- PAC -->
                  <div class="col-lg-6 col-md-12 col-sm-12">
                    <label for="pac"> PAC: </label>
                    <select class="form-control" name="pac" required>
                      <option value='0' selected disabled>Seleccionar PAC</option>
                      <?php
                        foreach ($data['pacs'] as $pac) {
                          $html_option = "<option value='". $pac['Id'] ."'> ". $pac['Id'] ." | ". $pac['NombreCorto'] ." </option>\n";
                          echo $html_option;
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Guardar Emisor </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
</body>

</html>