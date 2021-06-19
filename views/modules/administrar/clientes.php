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
                            <h4 class="card-title"> Clientes </h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_add">
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
                                          <th>Nombre o razón social</th>
                                          <th>RFC</th>
                                          <th>Persona</th>
                                          <th>Correo</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:13px;">
                                        <?php
                                          foreach ($data['clientes'] as $cliente){
                                            $icon=""; $icon_option = ""; $label_accion ="";
                                            if( $cliente['TipoPersona']=='M' ){
                                              $tipo_persona = 'Moral';
                                            }elseif( $cliente['TipoPersona']=='F' ){
                                              $tipo_persona = 'Física';
                                            }
                                            if ($cliente['Estatus']==1){
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
                                              "\t\t\t\t\t\t\t\t\t<a href='". $data['host'] ."/administrar/clientes/switch_active/". $cliente['Id'] ."/". $cliente['Estatus'] ."'>" . $icon . "</td> \n".
                                                          "\t\t\t\t\t\t\t\t<td>". $cliente['Nombre'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $cliente['RFC'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $tipo_persona ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>". $cliente['Correo'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>\n".
                                                            "\t\t\t\t\t\t\t\t\t<div class='btn-group' role='group' aria-label='Button group with nested dropdown' style='width:100%;'>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<button id='btnGroupDrop1' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='background-color: #4e73df !important;'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-ellipsis-h icon_btn_options'></i>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t</button>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='". $data['host'] ."/administrar/clientes/detalles/". $cliente['Id'] ."'> <i class='far fa-id-card'></i> Ver detalles </a>\n".
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
    <script type="text/javascript" src="<?= $data['host'] ?>/views/assets/js/datatable/datatables.min.js"></script>
</body>

</html>
