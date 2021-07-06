<div class="col-lg-3 col-md-6 col-sm-6" style="margin-bottom:15px;">
    <div class="card shadow border-left-primary py-2">
        <div class="card-body">
            <div class="row align-items-center no-gutters">
                <div class="col mr-2">
                    <div class="text-uppercase text-primary font-weight-bold text-xs mb-1">
                      <span><a href="<?= $data['host'] ?>/administrar/usuarios"> Usuarios </a> </span>
                    </div>
                    <div class="text-dark font-weight-bold h5 mb-0"><span> <?= $data['no_usuarios'] ?> </span></div>
                </div>
                <div class="col-auto"><i class="fas fa-user fa-2x text-gray-300"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6" style="margin-bottom:15px;">
    <div class="card shadow border-left-success py-2">
        <div class="card-body">
            <div class="row align-items-center no-gutters">
                <div class="col mr-2">
                    <div class="text-uppercase text-success font-weight-bold text-xs mb-1">
                      <span> <a href="<?= $data['host'] ?>/administrar/grupos" style="color: #28a745!important"> Grupos </a> </span>
                    </div>
                    <div class="text-dark font-weight-bold h5 mb-0"><span> <?= $data['no_grupos'] ?> </span></div>
                </div>
                <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6" style="margin-bottom:15px;">
    <div class="card shadow border-left-info py-2">
        <div class="card-body">
            <div class="row align-items-center no-gutters">
                <div class="col mr-2">
                    <div class="text-uppercase text-info font-weight-bold text-xs mb-1">
                      <span> <a href="<?= $data['host'] ?>/administrar/perfiles" style="color:#17a2b8!important"> Perfiles </a> </span>
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="text-dark font-weight-bold h5 mb-0"><span> <?= $data['no_perfiles'] ?> </span></div>
                        </div>
                    </div>
                </div>
                <div class="col-auto"><i class="fas fa-user-tie fa-2x text-gray-300"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-6 col-sm-6" style="margin-bottom:15px;">
    <div class="card shadow border-left-warning py-2">
        <div class="card-body">
            <div class="row align-items-center no-gutters">
                <div class="col mr-2">
                    <div class="text-uppercase text-warning font-weight-bold text-xs mb-1">
                      <span> <a href="<?= $data['host'] ?>/administrar/emisores" style="color: #ffc107!important;"> Emisores </a> </span>
                    </div>
                    <div class="text-dark font-weight-bold h5 mb-0"><span><?= $data['no_emisores'] ?></span></div>
                </div>
                <div class="col-auto"><i class="fas fa-building fa-2x text-gray-300"></i></div>
            </div>
        </div>
    </div>
</div>
<div class='col-lg-12 col-md-12 col-sm-12'>
  <hr>
</div>
