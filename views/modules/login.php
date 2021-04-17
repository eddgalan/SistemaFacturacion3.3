<!DOCTYPE html>
<html>
<head>
    <?php include './views/modules/components/head.php'; ?>
    <link rel="stylesheet" href="<?= $data['host']?>/views/assets/css/login.css">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h3 class="text-dark mb-4">Facturación Electrónica</h3>
                                        <h4 class="text-dark mb-4">Bienvenido</h4>
                                    </div>
                                    <form class="register-form" method="POST" action="">
                                      <div class="form-group">
                                        <label for="email">Correo: </label>
                                        <input type="text" class="form-control" name="email" placeholder="empresa@dominio.com" required>
                                      </div>
                                      <button>Recuperar contraseña</button>
                                      <p class="message">¿Ya está registrado? <a href="#">Iniciar sesión</a></p>
                                    </form>
                                    <form class="login-form"  method="POST" action="<?= $data['host']?>/login">
                                      <div class="form-group">
                                        <label for="username"><strong>Usuario: </strong></label>
                                        <input type="text" class="form-control" name="username" placeholder="Nombre de usuario" required>
                                      </div>
                                      <div class="form-group">
                                        <label for="password"><strong>Contraseña: </strong></label>
                                        <input type="password" class="form-control" name="password" placeholder="* * * * * * * * " required>
                                      </div>
                                      <button>Entrar</button>
                                      <hr>
                                      <p class="message">¿Olvidó su contraseña? <a href="#">Recuperar contraseña</a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include './views/modules/components/javascript.php'; ?>
    <script>
      $('.message a').click(function(){
       $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
      });
    </script>
</body>

</html>
