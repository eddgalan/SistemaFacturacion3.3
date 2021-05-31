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
                    <a class="nav-link" href="<?= $data['host'] ?>/administrar/usuarios"> <i class="fas fa-user"></i> Usuarios</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/administrar/grupos"> <i class="fas fa-users"></i> Grupos</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/administrar/emisores"> <i class="fas fa-building"></i> Emisores</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/administrar/prodserv"> <i class="fas fa-box"></i> Productos/Servicios</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/catalogosSAT/series"> <i class="fas fa-font"></i> Series</a>
                  </div>
                  <div class="seccion list-group-item list-group-item-action bg-light"><span> <i class="fas fa-money-check-alt"></i> Comprobantes</span></div>
                  <div class="panel">
                    <a class="nav-link" href="<?= $data['host'] ?>/CFDIs/facturas"> <i class="fas fa-file-invoice-dollar"></i> Facturas</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/CFDIs/notas_credito"> <i class="fas fa-search-dollar"></i> Notas de crédito</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/CFDIs/traslados"> <i class="fas fa-file-invoice-dollar"></i> Traslado</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/CFDIs/pagos"> <i class="fas fa-file-invoice-dollar"></i> Pago (REP)</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/CFDIs/nomina"> <i class="fas fa-file-invoice-dollar"></i> Nómina</a>
                  </div>
                  <div class="seccion list-group-item list-group-item-action bg-light"><span> <i class="fas fa-funnel-dollar"></i> Catálogos SAT</span></div>
                  <div class="panel">
                    <a class="nav-link" href="<?= $data['host'] ?>/catalogosSAT/prod_serv"> <i class="fas fa-apple-alt"></i> Claves ProdServ</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/catalogosSAT/unidades"> <i class="fas fa-weight"></i> Unidades</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/catalogosSAT/formas_pago"> <i class="fas fa-hand-holding-usd"></i> Formas de Pago</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/catalogosSAT/monedas"> <i class="fas fa-coins"></i> Monedas</a>
                    <a class="nav-link" href="<?= $data['host'] ?>/catalogosSAT/impuestos"> <i class="fas fa-dollar-sign"></i> Impuestos</a>
                  </div>
                  <div class="seccion list-group-item list-group-item-action bg-light"><span> <i class="fas fa-money-check-alt"></i> Reportes</span></div>
                  <div class="panel">
                    <a class="nav-link" href="<?= $data['host'] ?>/reportes/reportes"> <i class="fas fa-receipt"></i> Reportes</a>
                  </div>
              </div>
          </div>
      </div>
