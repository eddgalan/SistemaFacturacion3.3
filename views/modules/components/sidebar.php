<div id="sidebar-wrapper" class="bg-light border-right">
          <div class="sidebar-heading">
            <div class="col">
              <img class="img-fluid" src="<?= $data['host'] ?>/views/assets/img/Logo.jpg" style="width:200px;">
            </div>
          </div>
          <div class="list-group list-group-flush">
              <div class="section_content">
                  <div class="seccion list-group-item list-group-item-action bg-light"><span> <i class="fas fa-user-cog"></i> Administrar</span></div>
                  <div class="panel">
                    <a class="nav-link" href="<?= $data['host'] ?>/administrar/articulos"> <i class="fas fa-box"></i> Artículos</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/administrar/variantes"> <i class="fas fa-barcode"></i> Variantes de artículos</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/administrar/marcas"> <i class="fas fa-trademark"></i> Marcas</a>
                  </div>
                  <div class="seccion list-group-item list-group-item-action bg-light"><span> <i class="fas fa-funnel-dollar"></i> Catálogos SAT</span></div>
                  <div class="panel">
                    <a class="nav-link" href="<?= $data['host'] ?>/catalogosSAT/metodos_pago"> <i class="fas fa-money-check-alt"></i> Métodos de Pago</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/catalogosSAT/formas_pago"> <i class="fas fa-hand-holding-usd"></i> Formas de Pago</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/catalogosSAT/monedas"> <i class="fas fa-coins"></i> Monedas</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/catalogosSAT/impuestos"> <i class="fas fa-dollar-sign"></i> Impuestos</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/catalogosSAT/usos_cfdi"> <i class="fas fa-file-invoice-dollar"></i> Usos CFDI</a>
                  </div>
                  <div class="seccion list-group-item list-group-item-action bg-light"><span> <i class="fas fa-money-check-alt"></i> Comprobantes</span></div>
                  <div class="panel">
                    <a class="nav-link" href="<?= $data['host'] ?>/CFDIs/facturas"> <i class="fas fa-file-invoice-dollar"></i> Facturas</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/CFDIs/notas_credito"> <i class="fas fa-search-dollar"></i> Notas de crédito</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/CFDIs/traslados"> <i class="fas fa-file-invoice-dollar"></i> Traslado</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/CFDIs/pagos"> <i class="fas fa-file-invoice-dollar"></i> Pago (REP)</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/CFDIs/nomina"> <i class="fas fa-file-invoice-dollar"></i> Nómina</a>
                  </div>
                  <div class="seccion list-group-item list-group-item-action bg-light"><span> <i class="fas fa-money-check-alt"></i> Reportes</span></div>
                  <div class="panel">
                    <a class="nav-link" href="<?= $data['host'] ?>/reportes/reportes"> <i class="fas fa-receipt"></i> Reportes</a>
                  </div>
              </div>
          </div>
      </div>
