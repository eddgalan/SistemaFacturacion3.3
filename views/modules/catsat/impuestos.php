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
                            <h4 class="card-title"> Catálogo Impuestos </h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_agregar_moneda">
                              <i class="fas fa-plus-circle fa-sm"></i> Agregar Impuesto
                            </button>
                          </div>
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
                                      <thead style="font-size:15px;">
                                        <tr class="text-center">
                                          <th>Activo</th>
                                          <th>Clave</th>
                                          <th>Descripción</th>
                                          <th>Factor</th>
                                          <th>Tasa o cuota</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:14px;">
                                        <?php
                                          foreach($data['impuestos'] as $impuesto){
                                            $icon=""; $icon_option = ""; $label_accion ="";
                                            if ($impuesto['Estatus']==1){
                                              $icon = "<i class='fas fa-toggle-on color_green icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-off color_red '></i>";
                                              $label_accion = " Desactivar";
                                            }else{
                                              $icon = "<i class='fas fa-toggle-off color_red icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-on color_green'></i>";
                                              $label_accion = " Activar";
                                            }
                                            $html_row = ""."\n\t\t\t\t\t\t\t<tr>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'><a href='". $data['host'] ."/catalogosSAT/impuestos/switch_active/". $impuesto['Id'] ."/". $impuesto['Estatus'] ."'>" . $icon . " </a></td> \n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $impuesto['ClaveImpuesto'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $impuesto['Descripcion'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $impuesto['Factor'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $impuesto['Tasa_Cuota'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td>\n".
                                                          "\t\t\t\t\t\t\t\t\t<div class='btn-group' role='group' aria-label='Button group with nested dropdown' style='width:100%;'>\n".
                                                            "\t\t\t\t\t\t\t\t\t\t<button id='btnGroupDrop1' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='background-color: #4e73df !important;'>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-ellipsis-h icon_btn_options'></i>\n".
                                                            "\t\t\t\t\t\t\t\t\t\t</button>\n".
                                                            "\t\t\t\t\t\t\t\t\t\t<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_editar_usuario' onclick='carga_datos(". $impuesto['Id'] .")'> <i class='fas fa-edit'></i> Editar Impuesto</a>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='". $data['host'] ."/catalogosSAT/impuestos/switch_active/". $impuesto['Id'] ."/". $impuesto['Estatus'] ."' >". $icon_option . $label_accion ."</a>\n".
                                                            "\t\t\t\t\t\t\t\t\t\t</div>\n".
                                                          "\t\t\t\t\t\t\t\t\t</div>\n".
                                                        "\t\t\t\t\t\t\t\t</td>\n".
                                                        "\t\t\t\t\t\t\t\t<tr>\n";
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
    <!-- ..:: Modal Agregar Impuesto ::.. -->
    <div class="modal fade" id="modal_agregar_moneda">
      <div class="modal-dialog modal-lg">
        <form action="<?= $data['host'] ?>/catalogosSAT/impuestos/add" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"> <i class="fas fa-plus"></i> Agregar Impuesto </h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token']?>">
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-8">
                    <label for="impuesto"> Tipo de Impuesto: </label><br>
                    <select class='form-control' name='impuesto' required>
                      <option value='0'> Seleccione un tipo </option>
                      <?php
                        foreach ($data['cat_impuestos'] as $impuesto) {
                          $html_option = "<option value='". $impuesto['impuesto_clave']. " | ". $impuesto['impuesto_retencion'] . " | ". $impuesto['impuesto_traslado'] ."'>".
                            $impuesto['impuesto_clave'] ." | ". $impuesto['impuesto_concepto'] .
                          "</option>\n";
                          echo $html_option;
                        }
                      ?>
                    </select>
                  </div>
                  <!-- Descripción -->
                  <div class="col-lg-6 col-md-12 col-sm-8">
                    <label for="descripcion_impuesto"> Descripción: </label>
                    <input type='text' class='form-control' name='descripcion_impuesto' placeholder='Breve descripción del impuesto' required autocomplete="off">
                  </div>
                  <!-- Factor -->
                  <div class="col-lg-6 col-md-12 col-sm-8">
                    <label for="tipo_factor"> Factor: </label>
                    <select class='form-control' name='tipo_factor' required>
                      <option value='0'>Seleccione un tipo</option>
                      <option value='Tasa'>Tasa</option>
                      <option value='Cuota'>Cuota</option>
                    </select>
                  </div>
                  <!-- Tasa o Cuota -->
                  <div class="col-lg-6 col-md-12 col-sm-8">
                    <label for="tasa_cuota"> Tasa o cuota: </label>
                    <input type='text' class='form-control' name='tasa_cuota' placeholder='Ejemplo: 0.16' required autocomplete="off">
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
    <?php include './views/modules/components/javascript.php'; ?>
    <script type="text/javascript" src="../views/assets/js/catsat/impuestos.js"></script>

</body>

</html>
