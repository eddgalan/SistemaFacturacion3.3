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
                            <h4 class="card-title"> Comprobantes | Detalles Factura </h4>
                          </div>
                          <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                            <a href="<?= $data['host']?>/CFDIs/facturas" class="btn btn-primary waves-effect btn_full">
                              <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                          </div>
                        </div>
                        <hr>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          
                        </div>
                    </div>
                </div>
            </div>
            <?php include './views/modules/components/footer.php'; ?>
        </div>
    </div>
    <!-- ..:: MODALES ::.. -->
    <!-- ..:: Modal  ::.. -->
    <div class="modal fade" id="modal_nuevo_articulo">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> <i class="fas fa-plus"></i> Agregar Producto o Servicio </h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="col-lg-12 col-md-12 col-sm-12">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" name="add_product"class="btn btn-success" disabled> <i class="fas fa-check"></i> Agregar </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fas fa-times"></i> Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <?php include './views/modules/components/javascript.php'; ?>
    <script type="text/javascript" src="<?=$data['host']?>/views/assets/js/nuevo_cfdi.js"></script>
</body>

</html>
