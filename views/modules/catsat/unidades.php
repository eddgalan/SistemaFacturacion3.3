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
                            <h4 class="card-title">Catálogo Unidades</h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_agregar_unidad">
                              <i class="fas fa-plus-circle fa-sm"></i> Agregar Unidad
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
                                      <thead style="font-size:16px;">
                                        <tr class="text-center">
                                          <th>Activo</th>
                                          <th>Clave</th>
                                          <th>Nombre</th>
                                          <th>Descripción</th>
                                          <th>Simbolo</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:15px;">
                                        <?php
                                          foreach($data['unidades'] as $unidad){
                                            $icon=""; $icon_option = ""; $label_accion ="";
                                            if ($unidad['Estatus']==1){
                                              $icon = "<i class='fas fa-toggle-on color_green icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-off color_red '></i>";
                                              $label_accion = " Desactivar";
                                            }else{
                                              $icon = "<i class='fas fa-toggle-off color_red icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-on color_green'></i>";
                                              $label_accion = " Activar";
                                            }
                                            $html_row = ""."\n\t\t\t\t\t\t\t<tr>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>" . $icon . "</td> \n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $unidad['ClaveUnidad'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td>". $unidad['NombreUnidad'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td>". $unidad['Descripcion'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $unidad['Simbolo'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>\n".
                                                          "\t\t\t\t\t\t\t\t\t<div class='btn-group' role='group' aria-label='Button group with nested dropdown' style='width:100%;'>\n".
                                    												"\t\t\t\t\t\t\t\t\t\t<button id='btnGroupDrop1' style='background-color: #4e73df !important;' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>\n".
                                    													"\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-ellipsis-h icon_btn_options'></i>\n".
                                    												"\t\t\t\t\t\t\t\t\t\t</button>\n".
                                    												"\t\t\t\t\t\t\t\t\t\t<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>\n".
                                    													"\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_editar_producto' onclick='carga_datos_producto()'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-edit color_blue'></i> Editar\n".
                                                              "\t\t\t\t\t\t\t\t\t\t\t</a>\n".
                                    													"\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_eliminar_producto' onclick='carga_datos_producto()'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-times color_red'></i> Eliminar\n".
                                                              "\t\t\t\t\t\t\t\t\t\t\t</a>\n".
                                    												"\t\t\t\t\t\t\t\t\t\t</div>\n".
                                    											"\t\t\t\t\t\t\t\t</div>\n".
                                                        "\t\t\t\t\t\t\t\t\t</td>\n".
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
    <!-- ..:: Modal Agregar Unidad ::.. -->
    <div class="modal fade" id="modal_agregar_unidad">
      <div class="modal-dialog modal-lg">
        <form action="<?= $data['host'] ?>/catalogosSAT/unidades/add" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"> <i class="fas fa-plus"></i> Agregar Unidad </h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token']?>">
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-8">
                    <label for="cliente"> Clave o Nombre unidad: </label><br>
                    <select class="from-control selectpicker" name="unidad" data-live-search="true" style="width:100%;">
                      <option value="0" disabled selected>Buscar clave de unidad o nombre...</option>
                      <?php
                        foreach ($data['cat_unidades'] as $unidad) {
                          $html_option = "<option value='". $unidad['unidad_clave']. " | ". $unidad['unidad_nombre'] ." | ". $unidad['unidad_simbolo'] ."'>". $unidad['unidad_clave'] ." | ". $unidad['unidad_nombre'] ." | ". $unidad['unidad_simbolo'] ."</option>\n";
                          echo $html_option;
                        }
                      ?>
                    </select>
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
    <script type="text/javascript" src="../views/assets/js/catsat/unidad.js"></script>

</body>

</html>
