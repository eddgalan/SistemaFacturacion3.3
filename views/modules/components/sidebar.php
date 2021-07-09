<?php
  $usuario_pdo = new UsuarioPDO();
  $permisos = $usuario_pdo->get_permisos($_SESSION['Id']);
  // Sección Administrar
  if( $permisos['Admin_usuario'] == 0 && $permisos['Admin_grupos'] == 0 && $permisos['Admin_perfiles'] == 0 && $permisos['Admin_emisores'] == 0 && $permisos['Admin_clientes'] == 0 && $permisos['Admin_prodserv'] == 0 && $permisos['Admin_series'] == 0 ){
    $panel_admin = false;
  }else{
    $panel_admin = true;
  }
  // Sección Comprobantes
  if( $permisos['Comprobantes_facturas'] == 0 ){
    $panel_comprobantes = false;
  }else{
    $panel_comprobantes = true;
  }
  // Sección Reportes
  if( $permisos['Reportes_reportemensual'] == 0 ){
    $panel_reportes = false;
  }else{
    $panel_reportes = true;
  }
  // Sección Catálogos SAT
  if( $permisos['CatSAT_claves_prodserv'] == 0 && $permisos['CatSAT_unidades'] == 0 && $permisos['CatSAT_formaspago'] == 0 && $permisos['CatSAT_monedas'] == 0 && $permisos['CatSAT_impuestos'] == 0 ){
    $panel_catsat = false;
  }else{
    $panel_catsat = true;
  }
?>

<div id="sidebar-wrapper" class="bg-light border-right">
          <div class="sidebar-heading">
            <div class="col">
              <a href="<?= $data['host'] ?>/dashboard">
                <img class="img-fluid" src="<?= $data['host'] ?>/views/assets/img/Logo.jpg" style="width:200px;">
              </a>
            </div>
          </div>
          <div class="list-group list-group-flush">
              <div class="section_content">
                  <!-- ..:: Administrar ::.. -->
                  <?php
                    if( $panel_admin ){
                      echo "<div class='seccion list-group-item list-group-item-action bg-light'><span> <i class='fas fa-user-cog'></i> Administrar</span></div>\n\t\t\t\t\t";
                      $panel = "<div class='panel'>\n\t\t\t\t\t\t";
                      // Mi Empresa
                      if( $permisos['Admin_miempresa'] != 0 ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/administrar/miempresa'> <i class='fas fa-building'></i> Mi Empresa</a>\n\t\t\t\t\t\t";
                      }
                      // Usuarios
                      if( $permisos['Admin_usuario'] != 0 ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/administrar/usuarios'> <i class='fas fa-user'></i> Usuarios</a>\n\t\t\t\t\t\t";
                      }
                      // Grupos
                      if( $permisos['Admin_grupos'] != 0 ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/administrar/grupos'> <i class='fas fa-users'></i> Grupos</a>\n\t\t\t\t\t\t";
                      }
                      // Perfiles
                      if( $permisos['Admin_perfiles'] != 0 ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/administrar/perfiles'> <i class='fas fa-user-tie'></i> Perfiles</a>\n\t\t\t\t\t\t";
                      }
                      // Emisores
                      if( $permisos['Admin_emisores'] != 0 ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/administrar/emisores'> <i class='fas fa-building'></i> Emisores</a>\n\t\t\t\t\t\t";
                      }
                      // Clientes
                      if( $permisos['Admin_clientes'] != 0 ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/administrar/clientes'> <i class='far fa-address-book'></i> Clientes</a>\n\t\t\t\t\t\t";
                      }
                      // Productos y Servicios
                      if( $permisos['Admin_prodserv'] != 0 ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/administrar/prodserv'> <i class='fas fa-box'></i> Productos/Servicios</a>\n\t\t\t\t\t\t";
                      }
                      // Series
                      if( $permisos['Admin_series'] != 0 ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/administrar/series'> <i class='fas fa-font'></i> Series</a>\n\t\t\t\t\t";
                      }
                      $panel .= "</div>\n";
                      echo $panel;
                    }
                  ?>
                  <!-- ..:: Comprobantes ::.. -->
                  <?php
                    if( $panel_comprobantes ){
                      echo "<div class='seccion list-group-item list-group-item-action bg-light'><span> <i class='fas fa-money-check-alt'></i> Comprobantes</span></div>\n\t\t\t\t\t";
                      $panel = "<div class='panel'>\n\t\t\t\t\t\t";
                      if( $permisos['Comprobantes_facturas'] ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/CFDIs/facturas'> <i class='fas fa-file-invoice-dollar'></i> Facturas</a>\n\n\t\t\t\t\t";
                      }
                      $panel .= "</div>\n";
                      echo $panel;
                    }
                  ?>
                    <!-- <a class="nav-link" href="/CFDIs/notas_credito"> <i class="fas fa-search-dollar"></i> Notas de crédito</a>
                    <a class="nav-link" href="/CFDIs/traslados"> <i class="fas fa-file-invoice-dollar"></i> Traslado</a>
                    <a class="nav-link" href="/CFDIs/pagos"> <i class="fas fa-file-invoice-dollar"></i> Pago (REP)</a>
                    <a class="nav-link" href="/CFDIs/nomina"> <i class="fas fa-file-invoice-dollar"></i> Nómina</a> -->

                  <!-- ..:: Reportes ::.. -->
                  <?php
                    if( $panel_reportes ){
                      echo "<div class='seccion list-group-item list-group-item-action bg-light'><span> <i class='fas fa-money-check-alt'></i> Reportes</span></div>\n\t\t\t\t\t";
                      $panel = "<div class='panel'>\n\t\t\t\t\t\t";
                      if( $permisos['Reportes_reportemensual'] ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/reportes/mensual'> <i class='far fa-calendar-alt'></i> Reporte Mensual</a>\n\t\t\t\t\t";
                      }
                      $panel .= "</div>\n";
                      echo $panel;
                    }
                  ?>
                  <!-- ..:: Catálogos SAT ::.. -->
                  <?php
                    if( $panel_catsat ){
                      echo "<div class='seccion list-group-item list-group-item-action bg-light'><span> <i class='fas fa-funnel-dollar'></i> Catálogos SAT</span></div>\n\t\t\t\t\t";
                      $panel = "<div class='panel'>\n\t\t\t\t\t\t";
                      // Claves de productos y servicios
                      if( $permisos['CatSAT_claves_prodserv'] ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/catalogosSAT/prod_serv'> <i class='fas fa-apple-alt'></i> Claves ProdServ</a>\n\t\t\t\t\t\t";
                      }
                      // Unidades
                      if( $permisos['CatSAT_unidades'] ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/catalogosSAT/unidades'> <i class='fas fa-weight'></i> Unidades</a>\n\t\t\t\t\t\t";
                      }
                      // Fromas de Pago
                      if( $permisos['CatSAT_formaspago'] ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/catalogosSAT/formas_pago'> <i class='fas fa-hand-holding-usd'></i> Formas de Pago</a>\n\t\t\t\t\t\t";
                      }
                      // Monedas
                      if( $permisos['CatSAT_monedas'] ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/catalogosSAT/monedas'> <i class='fas fa-coins'></i> Monedas</a>\n\t\t\t\t\t\t";
                      }
                      // Impuestos
                      if( $permisos['CatSAT_impuestos'] ){
                        $panel .= "<a class='nav-link' href='". $data['host'] ."/catalogosSAT/impuestos'> <i class='fas fa-dollar-sign'></i> Impuestos</a>\n\t\t\t\t\t";
                      }
                      $panel .= "</div>\n";
                      echo $panel;
                    }
                  ?>
              </div>
          </div>
      </div>
