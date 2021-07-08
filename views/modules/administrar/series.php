<!DOCTYPE html>
<html>

<head>
    <?php include './views/modules/components/head.php'; ?>
    <link rel="stylesheet" type="text/css" href="../views/assets/js/dropzone2.0.12/dropzone.css" />
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
                            <h4 class="card-title"> Series </h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <?php
                              if( count($data['csd']) != false ){
                                echo "<button type='button' class='btn btn-success waves-effect btn_full' data-toggle='modal' data-target='#modal_agregar_serie'>
                                  <i class='fas fa-plus-circle fa-sm'></i> Agregar Serie
                                </button>";
                              }
                            ?>
                          </div>
                        </div>
                        <hr>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <?php require './views/modules/components/notifications.php'; ?>
                          </div>
                          <div class="row">
                            <?php
                              if( count($data['csd']) == false ){
                                require './views/modules/components/series_csd.php';
                              }else{

                              }
                            ?>
                            <!-- ..:: Tabla Series ::.. -->
                            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:5px;">
                                <div class="table-sm table-responsive">
                                  <table class="table table-bordered table-hover" data-order='[[1, "asc" ]]'>
                                      <thead style="font-size:15px;">
                                        <tr class="text-center">
                                          <th>Activo</th>
                                          <th>Serie</th>
                                          <th>Descripción</th>
                                          <th>Tipo Comprobante</th>
                                          <th>Consecutivo</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:14px;">
                                        <?php
                                          foreach($data['series'] as $serie){
                                            $icon=""; $icon_option = ""; $label_accion ="";
                                            if ($serie['Estatus']==1){
                                              $icon = "<i class='fas fa-toggle-on color_green icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-off color_red '></i>";
                                              $label_accion = " Desactivar";
                                            }else{
                                              $icon = "<i class='fas fa-toggle-off color_red icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-on color_green'></i>";
                                              $label_accion = " Activar";
                                            }
                                            $html_row = ""."\n\t\t\t\t\t\t\t<tr>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'><a href='". $data['host'] ."/administrar/series/switch_active/". $serie['Id'] ."/". $serie['Estatus'] ."'>" . $icon . " </a></td> \n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $serie['Serie'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $serie['Descripcion'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $serie['TipoComprobante'] ." | ". $serie['DescripcionTipoComp'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $serie['Consecutivo'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td>\n".
                                                          "\t\t\t\t\t\t\t\t\t<div class='btn-group' role='group' aria-label='Button group with nested dropdown' style='width:100%;'>\n".
                                                            "\t\t\t\t\t\t\t\t\t\t<button id='btnGroupDrop1' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='background-color: #4e73df !important;'>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-ellipsis-h icon_btn_options'></i>\n".
                                                            "\t\t\t\t\t\t\t\t\t\t</button>\n".
                                                            "\t\t\t\t\t\t\t\t\t\t<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_editar_serie' onclick='carga_datos(". $serie['Id'] .")'> <i class='fas fa-edit'></i> Editar Serie</a>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='". $data['host'] ."/administrar/series/switch_active/". $serie['Id'] ."/". $serie['Estatus'] ."' >". $icon_option . $label_accion ."</a>\n".
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
    <!-- ..:: Modal Agregar Serie ::.. -->
    <div class="modal fade" id="modal_agregar_serie">
      <div class="modal-dialog modal-lg">
        <form action="<?= $data['host'] ?>/administrar/series/process" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"> <i class="fas fa-plus"></i> Agregar Serie </h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token']?>">
                    <input type="hidden" name="id_csd" value="<?= $data['csd']['Id']?>">
                  </div>
                  <!-- Serie -->
                  <div class="col-lg-3 col-md-4 col-sm-8">
                    <label for="serie"> Serie: </label><br>
                    <input type="text" class="form-control" name="serie" placeholder="A, B, C, D, etc"autocomplete="off" required>
                  </div>
                  <!-- Descripción -->
                  <div class="col-lg-9 col-md-8 col-sm-8">
                    <label for="descripcion"> Descripción: </label>
                    <input type='text' class='form-control' name='descripcion' placeholder='Breve descripción de la serie...' autocomplete="off" required>
                  </div>
                  <!-- Tipo Comprobante -->
                  <div class="col-lg-7 col-md-12 col-sm-8">
                    <label for="tipo_comprobante"> Tipo de comprobante: </label>
                    <select class='form-control' name='tipo_comprobante' required>
                      <option value='0'>Seleccione un tipo de comprobante </option>
                      <?php
                        foreach( $data['tipo_comprobantes'] as $tipo_comprobante ){
                          echo "<option value='". $tipo_comprobante['tcomprobante_clave'] ." | ". $tipo_comprobante['tcomprobante_concepto'] ."'>".
                              $tipo_comprobante['tcomprobante_clave'] . " | " . $tipo_comprobante['tcomprobante_concepto'] . "</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <!-- Consecutivo -->
                  <div class="col-lg-5 col-md-12 col-sm-8">
                    <label for="consecutivo"> Consecutivo: </label>
                    <input type='text' class='form-control' name='consecutivo' placeholder='Comenzar el conteo en el núm...' required autocomplete="off">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success" name='agregar' disabled> <i class="fas fa-check"></i> Agregar </button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- ..:: Modal Editar Serie ::.. -->
    <div class="modal fade" id="modal_editar_serie">
      <div class="modal-dialog modal-lg">
        <form action="<?= $data['host'] ?>/administrar/series/process" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"> <i class="fas fa-edit"></i> Editar Serie </h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token']?>">
                    <input type="hidden" name="id_serie">
                  </div>
                  <!-- Serie -->
                  <div class="col-lg-3 col-md-4 col-sm-8">
                    <label for="serie"> Serie: </label><br>
                    <input type="text" class="form-control" name="serie_edit" placeholder="A, B, C, D, etc"autocomplete="off" required>
                  </div>
                  <!-- Descripción -->
                  <div class="col-lg-9 col-md-8 col-sm-8">
                    <label for="descripcion"> Descripción: </label>
                    <input type='text' class='form-control' name='descripcion_edit' placeholder='Breve descripción de la serie...' autocomplete="off" required>
                  </div>
                  <!-- Tipo Comprobante -->
                  <div class="col-lg-7 col-md-12 col-sm-8">
                    <label for="tipo_comprobante"> Tipo de comprobante: </label>
                    <select class='form-control' name='tipo_comprobante_edit' required>
                      <option value='0'>Seleccione un tipo de comprobante </option>
                      <?php
                        foreach( $data['tipo_comprobantes'] as $tipo_comprobante ){
                          echo "<option value='". $tipo_comprobante['tcomprobante_clave'] ." | ". $tipo_comprobante['tcomprobante_concepto'] ."'>".
                              $tipo_comprobante['tcomprobante_clave'] . " | " . $tipo_comprobante['tcomprobante_concepto'] . "</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <!-- Consecutivo -->
                  <div class="col-lg-5 col-md-12 col-sm-8">
                    <label for="consecutivo"> Consecutivo: </label>
                    <input type='text' class='form-control' name='consecutivo_edit' placeholder='Comenzar el conteo en el núm...' required autocomplete="off">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Guardar </button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
    <script type="text/javascript" src="../views/assets/js/admin/series.js"></script>
    <script type="text/javascript" src="<?= $data['host'] ?>/views/assets/js/datatable/datatables.min.js"></script>
</body>

</html>
