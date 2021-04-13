<!DOCTYPE html>
<html lang="en">
<head>
  <?php include './views/modules/components/head.php'; ?>
  <link rel="stylesheet" href="./views/assets/css/index.css">
</head>
<body>
  <div class="container-fluid div_main">
    <div class="row h-100">
      <!-- Formulario login -->
      <div class="col-md-5 mx-auto">
        <div class="col-md-8 mx-auto" style="width:100%; margin-top:65px;">
          <div class="card col-md-12" style="padding-right:-15px;">
            <div class="card-body">
              <div class="text-center">
                <img src="<?= $data['host'] ?>/views/assets/img/logo.jpg" class="img-fluid">
              </div>
              <form action="login" method="post">
                <div class="form-group">
                    <label for="username" style="margin-left: 0px;">Usuario: </label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                          <div class="input-group-text">
                              <i class="fa fa-user"></i>
                          </div>
                      </div>
                      <input id="username" type="text" class="form-control" name="username" tabindex="1" placeholder="username">
                    </div>
                </div>
                <div class="form-group">
                    <div class="d-block">
                        <label for="password" style="margin-left: 0px;">Contraseña: </label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <div class="input-group-text">
                                  <i class="fa fa-lock"></i>
                              </div>
                          </div>
                          <input id="password" type="password" class="form-control" name="password" tabindex="2" placeholder="********">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                  <button type="submit" id="btn_login" name="btn_login" class="btn btn-primary" tabindex="4">
                      Iniciar sesión
                  </button>
                </div>
                <div class="text-center">
                  <a class="small" href="forgot-password.html">¿Olvidó su contraseña?</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include './views/modules/components/javascript.php'; ?>
</body>
</html>
