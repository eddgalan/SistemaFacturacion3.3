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
                        <h4 class="card-title">Dashboard</h4>
                        <h6 class="text-muted card-subtitle mb-2" style="margin-bottom:20px !important;">Bienvenido <strong> <?= $_SESSION['Nombre'] ?> <?= $_SESSION['ApellidoPat'] ?> </strong> a su sistema de facturación; </h6>
                        <hr>
                        <!-- ...:: Dashboard Content ::.. -->
                        <div class="row">
                          <!-- Forbidden -->
                          <div class="display_none">
                            <input type"hidden" name="token" value="<?= $data['token'] ?>">
                          </div>
                          <!-- ..:: Panel Admin ::.. -->
                          <?php
                            if( $data['show_dashboard_admin'] ){
                              require "./views/modules/components/dashboard_admin.php";
                            }
                          ?>
                          <!-- ..:: Panel Emisor ::.. -->
                          <!-- Clientes -->
                          <div class="col-lg-3 col-md-6 col-sm-6" style="margin-bottom:15px;">
                              <div class="card shadow border-left-warning py-2">
                                  <div class="card-body">
                                      <div class="row align-items-center no-gutters">
                                          <div class="col mr-2">
                                              <div class="text-uppercase text-warning font-weight-bold text-xs mb-1">
                                                <span> <a href="<?= $data['host'] ?>/administrar/clientes" style="color: #28a745!important"> Clientes </a> </span>
                                              </div>
                                              <div class="text-dark font-weight-bold h5 mb-0"><span><?= $data['no_clientes'] ?></span></div>
                                          </div>
                                          <div class="col-auto"><i class="far fa-address-book fa-2x text-gray-300"></i></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- Productos/Servicios -->
                          <div class="col-lg-4 col-md-6 col-sm-6" style="margin-bottom:15px;">
                              <div class="card shadow border-left-warning py-2">
                                  <div class="card-body">
                                      <div class="row align-items-center no-gutters">
                                          <div class="col mr-2">
                                              <div class="text-uppercase text-warning font-weight-bold text-xs mb-1">
                                                <span> <a href="<?= $data['host'] ?>/administrar/prodserv" style="color: #ffc107!important;"> Productos y servicios </a> </span>
                                              </div>
                                              <div class="text-dark font-weight-bold h5 mb-0"><span><?= $data['no_prodservs'] ?></span></div>
                                          </div>
                                          <div class="col-auto"><i class="fas fa-box fa-2x text-gray-300"></i></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- Series -->
                          <div class="col-lg-3 col-md-6 col-sm-6" style="margin-bottom:15px;">
                              <div class="card shadow border-left-warning py-2">
                                  <div class="card-body">
                                      <div class="row align-items-center no-gutters">
                                          <div class="col mr-2">
                                              <div class="text-uppercase text-warning font-weight-bold text-xs mb-1">
                                                <span> <a href="<?= $data['host'] ?>/catalogosSAT/series" style="color:red !important"> Series </a> </span>
                                              </div>
                                              <div class="text-dark font-weight-bold h5 mb-0"><span><?= $data['no_series'] ?></span></div>
                                          </div>
                                          <div class="col-auto"><i class="fas fa-font fa-2x text-gray-300"></i></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <hr>
                          </div>

                          <!-- ..:: Comprobantes ::.. -->
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <h6 class="text-muted card-subtitle mb-2" style="margin-top:10px; margin-bottom:15px !important;">
                              Se han registrado <strong> <?= $data['no_cfdis']['CFDIsTotal'] ?> </strong> CFDIs en total
                            </h6>
                          </div>
                          <!-- Nuevos -->
                          <div class="col-lg-3 col-md-6 col-sm-6" style="margin-bottom:15px;">
                              <div class="card shadow border-left-warning py-2">
                                  <div class="card-body">
                                      <div class="row align-items-center no-gutters">
                                          <div class="col mr-2">
                                              <div class="text-uppercase text-warning font-weight-bold text-xs mb-1">
                                                <span> <a href="<?= $data['host'] ?>/CFDIs/facturas" style="color:#ffc107 !important"> Nuevos </a> </span>
                                              </div>
                                              <div class="text-dark font-weight-bold h5 mb-0"><span><?= $data['no_cfdis']['CFDIsNuevos'] ?></span></div>
                                          </div>
                                          <div class="col-auto"><i class="fas fa-star fa-2x text-gray-300"></i></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- Timbrados (No verificados) -->
                          <div class="col-lg-3 col-md-6 col-sm-6" style="margin-bottom:15px;">
                              <div class="card shadow border-left-warning py-2">
                                  <div class="card-body">
                                      <div class="row align-items-center no-gutters">
                                          <div class="col mr-2">
                                              <div class="text-uppercase text-warning font-weight-bold text-xs mb-1">
                                                <span> <a href="<?= $data['host'] ?>/CFDIs/facturas" style="color:#17a2b8 !important"> No verificados </a> </span>
                                              </div>
                                              <div class="text-dark font-weight-bold h5 mb-0"><span><?= $data['no_cfdis']['CFDIsSinVerificar'] ?></span></div>
                                          </div>
                                          <div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gra-300"></i></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- Verificados -->
                          <div class="col-lg-3 col-md-6 col-sm-6" style="margin-bottom:15px;">
                              <div class="card shadow border-left-warning py-2">
                                  <div class="card-body">
                                      <div class="row align-items-center no-gutters">
                                          <div class="col mr-2">
                                              <div class="text-uppercase text-warning font-weight-bold text-xs mb-1">
                                                <span> <a href="<?= $data['host'] ?>/CFDIs/facturas" style="color:#28a745 !important"> Verificados </a> </span>
                                              </div>
                                              <div class="text-dark font-weight-bold h5 mb-0"><span><?= $data['no_cfdis']['CFDIsVerificados'] ?></span></div>
                                          </div>
                                          <div class="col-auto"><i class="fas fa-check-double fa-2x text-gray-300"></i></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- Cancelados -->
                          <div class="col-lg-3 col-md-6 col-sm-6" style="margin-bottom:15px;">
                              <div class="card shadow border-left-warning py-2">
                                  <div class="card-body">
                                      <div class="row align-items-center no-gutters">
                                          <div class="col mr-2">
                                              <div class="text-uppercase text-warning font-weight-bold text-xs mb-1">
                                                <span> <a href="<?= $data['host'] ?>/CFDIs/facturas" style="color:red !important"> Cancelados </a> </span>
                                              </div>
                                              <div class="text-dark font-weight-bold h5 mb-0"><span><?= $data['no_cfdis']['CFDIsCancelados'] ?></span></div>
                                          </div>
                                          <div class="col-auto"><i class="fas fa-ban fa-2x text-gray-300"></i></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- ..:: Gráficas ::.. -->
                          <div class="col-lg-12 col-md-12 col-sm-12">
                            <hr>
                          </div>
                          <!-- Facturación Mensual -->
                          <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <h6 class="text-muted card-subtitle mb-2" style="margin-top:10px; margin-bottom:15px !important;">
                                Su facturación en este año:
                              </h6>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <canvas id="chart_meses" name="chart_meses"></canvas>
                            </div>
                          </div>
                          <!-- Mejores Clientes -->
                          <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <h6 class="text-muted card-subtitle mb-2" style="margin-top:10px; margin-bottom:15px !important;">
                                Sus mejores clientes en este año:
                              </h6>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <canvas id="chart_clientes" name="chart_clientes"></canvas>
                            </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
            <?php include './views/modules/components/footer.php'; ?>
        </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= $data['host'] ?>/views/assets/js/chartjs/dashboard.js"></script>
</body>

</html>
