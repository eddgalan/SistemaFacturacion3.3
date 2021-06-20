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
                          <h4 class="card-title"> Reporte Mensual </h4>
                        </div>
                        <!-- <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                          <button type="button" class="btn btn-success waves-effect btn_full" data-toggle="modal" data-target="#modal_nuevo_usuario">
                            <i class="fas fa-user-plus"></i> Crear Usuario
                          </button>
                        </div> -->
                      </div>
                      <hr>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <?php require './views/modules/components/notifications.php'; ?>
                      </div>
                      <form method="POST" action="<?= $data['host'] ?>/reportes/mensual">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                          <label for="mes"> Mes: </label>
                          <select class="form-control" name="mes" required>
                            <option value="0" selected disabled> Seleccione un mes</option>
                            <?php
                              foreach ($data['meses'] as $option) {
                                echo "<option value='". $option['Anio'] ." | ". $option['MesNum'] ." | ". $option['MesNom'] ."'>".
                                 $option['Anio'] ." | ". $option['MesNom'] ."</option>";
                              }
                            ?>
                          </select>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center" style="margin-top:10px;">
                          <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-contract"></i> Generar reporte
                          </button>
                        </div>
                      </form>
                      <?php
                        if( $_POST ){
                          echo "<div class='col-lg-12 col-md-12 col-sm-12'>
                            <h4 class='text-center'>
                              Reporte mensual de ". $data['mes'][2] ." de ". $data['mes'][0] ."
                            </h4>
                            <iframe src=". $data['host'] ." title='Reporte Mensual' style='width:100%;height:750px;'></iframe>
                          </div>";
                        }
                      ?>
                    </div>
                </div>
            </div>
            <?php include './views/modules/components/footer.php'; ?>
        </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
</body>

</html>
