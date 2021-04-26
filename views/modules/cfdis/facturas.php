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
                            <h4 class="card-title"> Comprobantes | Facturas </h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <a href="<?= $data['host']?>/CFDIs/facturas/nueva" class="btn btn-success waves-effect btn_full">
                              <i class="fas fa-plus"></i> Nuevo CFDI
                            </a>
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
                            <!-- ..:: Tabla CFDIs Facturas ::.. -->
                            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:5px;">
                                <div class="table-sm table-responsive">
                                  <table class="table table-bordered table-hover">
                                      <thead style="font-size:16px;">
                                        <tr class="text-center">
                                          <th>Estatus</th>
                                          <th>Serie</th>
                                          <th>Folio</th>
                                          <th>Cliente</th>
                                          <th>UUID</th>
                                          <th>Total</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:15px;">
                                        <?php
                                          foreach ($data['comprobantes'] as $comprobante) {
                                            switch ($comprobante['Estatus']) {
                                              case '0':
                                                $estado = "Nuevo";
                                                break;
                                              default:
                                                $estado = "Desconocido";
                                                break;
                                            }
                                            $html_tr = ""."\n\t\t\t\t\t\t\t<tr>\n".
                                              "\t\t\t\t\t\t\t\t<td class='text-center'>". $estado . "</td>  \n".
                                              "\t\t\t\t\t\t\t\t<td class='text-center'>". $comprobante['Serie'] . "</td>  \n".
                                              "\t\t\t\t\t\t\t\t<td class='text-center'>". $comprobante['Folio'] . "</td>  \n".
                                              "\t\t\t\t\t\t\t\t<td>". $comprobante['NombreCliente'] . "</td>  \n".
                                              "\t\t\t\t\t\t\t\t<td>". $comprobante['UUID'] . "</td>  \n".
                                              "\t\t\t\t\t\t\t\t<td class='text-center'>". $comprobante['Total'] . "</td>  \n".
                                              "\t\t\t\t\t\t\t\t <td class='text-center'> \n".
                                              "\t\t\t\t\t\t\t\t\t <div class='btn-group' role='group' aria-label='Button group with nested dropdown' style='width:100%;'> \n".
                                              "\t\t\t\t\t\t\t\t\t <button id='btnGroupDrop1' style='background-color: #4e73df !important;' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> \n".
                                              "\t\t\t\t\t\t\t\t\t <i class='fas fa-ellipsis-h icon_btn_options'></i> \n".
                                              "\t\t\t\t\t\t\t\t\t </button> \n".
                                              "\t\t\t\t\t\t\t\t\t <div class='dropdown-menu' aria-labelledby='btnGroupDrop1'> \n".
                                              "\t\t\t\t\t\t\t\t\t <a class='dropdown-item' href='". $data['host'] ."/CFDIs/facturas/detalles/". $comprobante['Id'] ."'> \n".
                                              "\t\t\t\t\t\t\t\t\t <i class='far fa-file-alt'></i> Ver detalles \n".
                                              "\t\t\t\t\t\t\t\t\t </a> \n".
                                              "\t\t\t\t\t\t\t\t\t <a class='dropdown-item' href='#'> \n".
                                              "\t\t\t\t\t\t\t\t\t <i class='fas fa-file-pdf color_red'></i> Descargar PDF \n".
                                              "\t\t\t\t\t\t\t\t\t </a> \n".
                                              "\t\t\t\t\t\t\t\t\t <a class='dropdown-item' href='#'> \n".
                                              "\t\t\t\t\t\t\t\t\t <i class='fas fa-file-code color_blue'></i> Descargar XML \n".
                                              "\t\t\t\t\t\t\t\t\t </a> \n".
                                              "\t\t\t\t\t\t\t\t\t </div> \n".
                                              "\t\t\t\t\t\t\t\t\t </div> \n".
                                              "\t\t\t\t\t\t\t\t\t </td> \n".
                                              "\t\t\t\t\t\t\t\t</tr>\n";
                                            echo $html_tr;
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
