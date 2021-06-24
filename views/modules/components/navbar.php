<nav class="navbar navbar-light navbar-expand-md" id="main_navbar" style="background-color: #000;">
              <div class="container-fluid">
                  <div class="flex-column"><button class="btn btn-primary" id="menu-toggle" type="button"> <i class="fas fa-bars"></i> Menú</button></div>
                  <div class="flex-column row">
                      <div class="dropdown" id="drop_perfil"><a class="dropdown-toggle" aria-expanded="false" data-toggle="dropdown" href="#"> <i class="fas fa-user"></i> <?= $_SESSION['Username'] ?> &nbsp;</a>
                          <div class="dropdown-menu" style="margin-left: -85px;">
                            <a class="dropdown-item" href="<?= $data['host'] ?>/perfil"> <i class="fas fa-id-card"></i> Perfil </a>
                            <a class="dropdown-item" href="<?= $data['host']?>/logout"> <i class="fas fa-sign-out-alt" style="color:red;"></i> Cerrar sesión </a>
                          </div>
                      </div>
                  </div>
              </div>
            </nav>
