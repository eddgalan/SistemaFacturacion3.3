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
                            <h4 class="card-title"> Catálogo Monedas </h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_agregar_moneda">
                              <i class="fas fa-plus-circle fa-sm"></i> Agregar Moneda
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
                                          <th>Moneda</th>
                                          <th>No Decimales</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:14px;">
                                        <?php
                                          foreach($data['monedas'] as $moneda){
                                            $icon=""; $icon_option = ""; $label_accion ="";
                                            if ($moneda['Estatus']==1){
                                              $icon = "<i class='fas fa-toggle-on color_green icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-off color_red '></i>";
                                              $label_accion = " Desactivar";
                                            }else{
                                              $icon = "<i class='fas fa-toggle-off color_red icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-on color_green'></i>";
                                              $label_accion = " Activar";
                                            }
                                            $html_row = ""."\n\t\t\t\t\t\t\t<tr>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'><a href='". $data['host'] ."/catalogosSAT/monedas/switch_active/". $moneda['Id'] ."/". $moneda['Estatus'] ."'>" . $icon . " </a></td> \n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $moneda['ClaveMoneda'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $moneda['Nombre'] ."</td>\n".
                                                        "\t\t\t\t\t\t\t\t<td class='text-center'>". $moneda['NoDecimales'] ."</td>\n".
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
    <!-- ..:: Modal Agregar Moneda ::.. -->
    <div class="modal fade" id="modal_agregar_moneda">
      <div class="modal-dialog modal-lg">
        <form action="<?= $data['host'] ?>/catalogosSAT/monedas/add" method="POST">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"> <i class="fas fa-plus"></i> Agregar Moneda </h4>
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
                    <label for="cliente"> Clave o Nombre la Moneda: </label><br>
                    <select class="from-control selectpicker" name="moneda" data-live-search="true" style="width:100%;">
                      <option value="0" disabled selected>Buscar clave o nombre de la moneda...</option>
                      <?php
                        foreach ($data['cat_monedas'] as $moneda) {
                          $html_option = "<option value='". $moneda['moneda_clave']. " | ". $moneda['moneda_nombre'] . " | ". $moneda['moneda_decimales'] . " | ". $moneda['moneda_variacion'] ." | ". $moneda['moneda_fecha_inicio'] ." | ". $moneda['moneda_fecha_fin'] ."'>".
                            $moneda['moneda_clave'] ." | ". $moneda['moneda_nombre'] .
                          "</option>\n";
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
    <script type="text/javascript" src="../views/assets/js/catsat/monedas.js"></script>

</body>

</html>
