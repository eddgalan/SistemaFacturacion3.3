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
                                          <th>Id</th>
                                          <th>Activo</th>
                                          <th>Nombre</th>
                                          <th>RFC</th>
                                          <th>Tipo Persona</th>
                                          <th>PAC</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:13px;">
                                        <?php
                                          foreach( $data['emisores'] as $emisor){
                                            $icon=""; $icon_option = ""; $label_accion ="";
                                            if( $emisor['Persona']== 'M'){
                                              $tipo_persona = 'Moral';
                                            }elseif( $emisor['Persona']=='F' ){
                                              $tipo_persona = 'Física';
                                            }
                                            if ($emisor['Estatus']==1){
                                              $icon = "<i class='fas fa-toggle-on color_green icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-off color_red '></i>";
                                              $label_accion = " Desactivar";
                                            }else{
                                              $icon = "<i class='fas fa-toggle-off color_red icon_status'></i>";
                                              $icon_option = "<i class='fas fa-toggle-on color_green'></i>";
                                              $label_accion = " Activar";
                                            }
                                            $html_row = "". "\n\t\t\t\t\t\t\t<tr>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $emisor['Id'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>".
                                                            "\t\t\t\t\t\t\t\t\t<a href='". $data['host'] ."/administrar/emisores/switch_active/". $emisor['Id'] ."/". $emisor['Estatus'] ."'>" . $icon . "</td> \n".
                                                          "\t\t\t\t\t\t\t\t<td>". $emisor['Nombre'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $emisor['RFC'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $tipo_persona ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $emisor['PAC'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>\n".
                                                            "\t\t\t\t\t\t\t\t\t<div class='btn-group' role='group' aria-label='Button group with nested dropdown' style='width:100%;'>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<button id='btnGroupDrop1' type='button' class='btn btn-info btn_options text-center' style='background-color: #4e73df !important;' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-ellipsis-h icon_btn_options'></i>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t</button>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_editar_emisor' onclick='carga_datos(". $emisor['Id'] .")'> <i class='fas fa-edit'></i> Editar Emisor</a>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='". $data['host'] ."/administrar/emisores/switch_active/". $emisor['Id'] ."/". $emisor['Estatus'] ."' >". $icon_option . $label_accion ."</a>\n".
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
    <!-- ..:: Modal Agregar Emisor ::.. -->
    <div class="modal fade" id="modal_nuevo_emisor">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Nuevo Emisor </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/emisores/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                  </div>
                  <!-- Nombre | Razón Social -->
                  <div class="col-lg-8 col-md-12 col-sm-12">
                    <label for="nombre"> Nombre o razón social: </label>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre emisor o razón social" required autocomplete="off">
                  </div>
                  <!-- RFC -->
                  <div class="col-lg-4 col-md-5 col-sm-12">
                    <label for="rfc"> RFC: </label>
                    <input type="text" class="form-control" name="rfc" placeholder="AAA010101AAA" required autocomplete="off">
                  </div>
                  <!-- Tipo Persona -->
                  <div class="col-lg-4 col-md-5 col-sm-12">
                    <label for="tipo_persona"> Tipo de Persona: </label>
                    <select class='form-control' name='tipo_persona' required>
                      <option value='M'> Moral </option>
                      <option value='F'> Física </option>
                    </select>
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
                  <div class="col-lg-8 col-md-12 col-sm-12">
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
    <!-- ..:: Modal Editar Emisor ::.. -->
    <div class="modal fade" id="modal_editar_emisor">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class='fas fa-edit'></i> Editar Emisor </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/emisor/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                    <input type="hidden" name="id_emisor">
                  </div>
                  <!-- Imagen -->
                  <div class='col-lg-12 col-md-12 col-sm-12'>
                    <img class="img-fluid mx-auto d-block" src='' name='img_logo' style="max-height:250px;">
                  </div>
                  <!-- Nombre | Razón Social -->
                  <div class="col-lg-8 col-md-12 col-sm-12">
                    <label for="nombre_edit"> Nombre o razón social: </label>
                    <input type="text" class="form-control" name="nombre_edit" placeholder="Nombre emisor o razón social" required>
                  </div>
                  <!-- RFC -->
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="rfc_edit"> RFC: </label>
                    <input type="text" class="form-control" name="rfc_edit" placeholder="AAA010101AAA" required>
                  </div>
                  <!-- Domicilio -->
                  <div class="col-lg-8 col-md-8 col-sm-12">
                    <label for="domicilio_edit"> Domicilio: </label>
                    <input type="text" class="form-control" name="domicilio_edit" placeholder="Calle, No Int, No Ext, Ciudad, Estado..." required>
                  </div>
                  <!-- Código Postal -->
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="codigo_postal_edit"> Código Postal: </label>
                    <input type="text" class="form-control" name="codigo_postal_edit" placeholder="00000" required>
                  </div>
                  <!-- Tipo de Persona -->
                  <div class="col-lg-4 col-md-8  col-sm-12">
                    <label for="tipo_persona_edit"> Tipo de Persona: </label>
                    <select class='form-control' name='tipo_persona_edit'>
                      <option value='F'>Física</option>
                      <option value='M'>Moral</option>
                    </select>
                  </div>
                  <!-- Tipo de Regimen -->
                  <div class="col-lg-8 col-md-12 col-sm-12">
                    <label for="regimen_edit"> Regimen: </label>
                    <select class='form-control' name='regimen_edit'></select>
                  </div>
                  <!-- PAC -->
                  <div class="col-lg-6 col-md-12 col-sm-12">
                    <label for="pac_edit"> PAC: </label>
                    <select class="form-control" name="pac_edit" required>
                      <?php
                        foreach ($data['pacs'] as $pac) {
                          $html_option = "<option value='". $pac['Id'] ."'> ". $pac['Id'] ." | ". $pac['NombreCorto'] ." </option>\n";
                          echo $html_option;
                        }
                      ?>
                    </select>
                  </div>
                  <!-- Modo -->
                  <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="codigo_postal_edit"> Modo: </label>
                    <select class='form-control' name='modo_edit'>
                      <option value='0'>Producción</option>
                      <option value='1'>Pruebas</option>
                    </select>
                  </div>
                  <!-- Cambiar Logo -->
                  <div class='col-lg-12 col-md-12 col-sm-12'><br>
                    <label for='logo_edit'>Cambiar logo</label>
                    <input type='file' name='logo_edit' accept="image/jpeg, image/png">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Guardar Cambios </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
    <script src="<?= $data['host'] ?>/views/assets/js/admin/emisores.js"></script>
</body>

</html>
