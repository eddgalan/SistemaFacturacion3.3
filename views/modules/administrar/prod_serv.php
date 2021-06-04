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
                            <h4 class="card-title"> Productos y Servicios </h4>
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
                            <!-- ..:: Tabla Usuarios ::.. -->
                            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:5px;">
                                <div class="table-sm table-responsive">
                                  <table class="table table-bordered table-hover">
                                      <thead style="font-size:16px;">
                                        <tr class="text-center">
                                          <th>Estatus</th>
                                          <th>SKU</th>
                                          <th>Nombre</th>
                                          <th>Clave</th>
                                          <th>Descripción</th>
                                          <th>Unidad</th>
                                          <th>Clave Impuesto</th>
                                          <th>Tasa o cuota</th>
                                          <th>Acciones</th>
                                        </tr>
                                      </thead>
                                      <tbody style="font-size:13px;">
                                        <?php
                                          foreach ($data['prod_servs'] as $prod_serv){
                                            $icon=""; $icon_option = ""; $label_accion ="";
                                            if ($prod_serv['Estatus']==1){
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
                                              "\t\t\t\t\t\t\t\t\t<a href='". $data['host'] ."/administrar/usuarios/switch_active/". $prod_serv['Id'] ."/". $prod_serv['Estatus'] ."'>" . $icon . "</td> \n".
                                                          "\t\t\t\t\t\t\t\t<td>". $prod_serv['SKU'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>". $prod_serv['Nombre'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $prod_serv['ClaveProdServ'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>". $prod_serv['DescClave'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $prod_serv['NombreUnidad'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $prod_serv['ClaveImpuesto'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td class='text-center'>". $prod_serv['Tasa_Cuota'] ."</td>\n".
                                                          "\t\t\t\t\t\t\t\t<td>\n".
                                                            "\t\t\t\t\t\t\t\t\t<div class='btn-group' role='group' aria-label='Button group with nested dropdown' style='width:100%;'>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<button id='btnGroupDrop1' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='background-color: #4e73df !important;'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<i class='fas fa-ellipsis-h icon_btn_options'></i>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t</button>\n".
                                                              "\t\t\t\t\t\t\t\t\t\t<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>\n".
                                                                "\t\t\t\t\t\t\t\t\t\t\t<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_edit' onclick='carga_datos(". $prod_serv['Id'] .")'> <i class='fas fa-edit'></i> Editar </a>\n".
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
    <!-- ..:: Modal Nuevo Producto/Servicio ::.. -->
    <div class="modal fade" id="modal_add">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Nuevo Producto/Servicio </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/prodserv/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                  </div>
                  <!-- SKU -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="sku"> SKU: </label>
                    <input type="text" class="form-control" name="sku" placeholder="Código artículo/servicio" required autocomplete="off">
                  </div>
                  <!-- Nombre -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="nombre"> Nombre: </label>
                    <input type="text" class="form-control" name="nombre" placeholder="Nombre artículo o servicio" required autocomplete="off">
                  </div>
                  <!-- Clave ProdServ -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="clave_prodserv">Clave Producto/Servicio: </label>
                    <select class='form-control' name='clave_prodserv'>
                      <option value='0' selected disabled>Seleccione una clave</option>
                      <?php
                        foreach( $data['claves_prodserv'] as $prod_serv ){
                          echo "<option value='". $prod_serv['Id'] ."'> "
                                . $prod_serv['ClaveProdServ'] ." | ". $prod_serv['Descripcion'] .
                                "</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <!-- Clave Unidad -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="clave_unidad"> Unidad: </label>
                    <select class='form-control' name='clave_unidad'>
                      <option value='0' selected disabled>Seleccione una clave</option>
                      <?php
                        foreach( $data['unidades'] as $unidad ){
                          echo "<option value='". $unidad['Id'] ."'> "
                                . $unidad['ClaveUnidad'] ." | ". $unidad['NombreUnidad'] .
                                "</option>";
                        }
                      ?>
                    </select>
                  </div>
                  <!-- Precio -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="precio"> Precio: </label>
                    <input type="text" class="form-control" name="precio" placeholder="$ 0.00" required autocomplete="off">
                  </div>
                  <!-- Impuesto -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="impuesto"> Impuesto: </label>
                    <select class='form-control' name='impuesto'>
                      <option value='0' selected disabled>Seleccione Impuesto</option>
                      <?php
                        foreach( $data['impuestos'] as $impuesto ){
                          echo "<option value='". $impuesto['Id'] ."'> "
                                . $impuesto['ClaveImpuesto'] ." | ". $impuesto['Descripcion'] .
                                "</option>";
                        }
                      ?>
                    </select>
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
    <!-- ..:: Modal Editar Producto/Servicio ::.. -->
    <div class="modal fade" id="modal_edit">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-user-edit"></i> Editar Grupo </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form method="POST" action="<?= $data['host'] ?>/administrar/grupos/process">
              <div class="modal-body">
                <div class="row">
                  <!-- Token -->
                  <div style="display:none;">
                    <input type="hidden" name="token" value="<?= $data['token'] ?>">
                    <input type="hidden" name="id_grupo">
                  </div>
                  <!-- Nombre -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="grupo"> Nombre del grupo: </label>
                    <input type="text" class="form-control" name="grupo_edit" placeholder="Ej. Admin, Vendedores, Clientes, etc" required autocomplete="off">
                  </div>
                  <!-- Descripción -->
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <label for="descripcion"> Descripción: </label>
                    <input type="text" class="form-control" name="descripcion_edit" placeholder="Breve descripción del grupo" required autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success"> <i class="fas fa-check"></i> Guardar cambios </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
    <script src="<?= $data['host'] ?>/views/assets/js/admin/prod_serv.js"></script>
</body>

</html>
