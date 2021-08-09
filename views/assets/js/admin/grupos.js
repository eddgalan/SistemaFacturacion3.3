$(document).ready(function () {
  var table = $('table').DataTable({
    "language":{
      "url": "../views/assets/js/datatable/Spanish.json"
    }
  });
});

/* ..:: CARGA DATOS GRUPO | AJAX ::.. */
function carga_datos(id){
  var token = $("input[name='token']").val();
  var id_grupo = $("input[name='id_grupo']").val();
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../API/grupos/get_grupo",
    data: {"token":token, "id_grupo":id},
    success: function(resp){
      // console.log(resp);
      // Obtiene los datos del servicio
      var id = resp.data.Id;
      var nombre = resp.data.Nombre;
      var descripcion = resp.data.Descripcion;
      // Setea los datos en el formulario
      $("input[name='id_grupo']").val(id);
      $("input[name='grupo_edit']").val(nombre);
      $("input[name='descripcion_edit']").val(descripcion);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}

/* ..:: CARGA PERMISOS GRUPO | AJAX ::.. */
function carga_permisos(id_grupo){
  var token = $("input[name='token']").val();
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../API/grupos/get_permisos",
    data: {"token":token, "id_grupo":id_grupo},
    success: function(resp){
      console.log(resp);
      if( resp.data ){
        var datos = resp.data;
        // Setea los datos en el Modal
        $("span[name='nom_grupo']").html("'"+ datos.Nombre +"'");
        $("input[name='id_permiso']").val(datos.Id);
        /* ..:: Administrar ::.. */
        // Mi Empresa
        if( datos.Admin_miempresa == 1 ){
          $("input[name='admin_miempresa']").prop("checked", true);
        }else{
          $("input[name='admin_miempresa']").prop("checked", false);
        }
        // PACs
        if( datos.Admin_PAC == 1 ){
          $("input[name='admin_pacs']").prop("checked", true);
        }else{
          $("input[name='admin_pacs']").prop("checked", false);
        }
        // Usuario
        if( datos.Admin_usuario == 1 ){
          $("input[name='admin_usuario']").prop("checked", true);
        }else{
          $("input[name='admin_usuario']").prop("checked", false);
        }
        // Grupos
        if( datos.Admin_grupos == 1 ){
          $("input[name='admin_grupos']").prop("checked", true);
        }else{
          $("input[name='admin_grupos']").prop("checked", false);
        }
        // Perfiles
        if( datos.Admin_perfiles == 1 ){
          $("input[name='admin_perfiles']").prop("checked", true);
        }else{
          $("input[name='admin_perfiles']").prop("checked", false);
        }
        // Emisores
        if( datos.Admin_emisores == 1 ){
          $("input[name='admin_emisores']").prop("checked", true);
        }else{
          $("input[name='admin_emisores']").prop("checked", false);
        }
        // Clientes
        if( datos.Admin_clientes == 1 ){
          $("input[name='admin_clientes']").prop("checked", true);
        }else{
          $("input[name='admin_clientes']").prop("checked", false);
        }
        // Productos y Servicios
        if( datos.Admin_prodserv == 1 ){
          $("input[name='admin_prodserv']").prop("checked", true);
        }else{
          $("input[name='admin_prodserv']").prop("checked", false);
        }
        // Series
        if( datos.Admin_series == 1 ){
          $("input[name='admin_series']").prop("checked", true);
        }else{
          $("input[name='admin_series']").prop("checked", false);
        }
        /* ..:: Comprobantes ::.. */
        // Facturas
        if( datos.Comprobantes_facturas == 1 ){
          $("input[name='comprobantes_facturas']").prop("checked", true);
        }else{
          $("input[name='comprobantes_facturas']").prop("checked", false);
        }
        /* ..:: Reportes ::.. */
        // Reporte Mensual
        if( datos.Reportes_reportemensual == 1 ){
          $("input[name='report_reportmensual']").prop("checked", true);
        }else{
          $("input[name='report_reportmensual']").prop("checked", false);
        }
        /* ..:: Catálogos SAT ::.. */
        // Claves ProdServ
        if( datos.CatSAT_claves_prodserv == 1 ){
          $("input[name='catsat_prodserv']").prop("checked", true);
        }else{
          $("input[name='catsat_prodserv']").prop("checked", false);
        }
        // Catálogo de Unidades
        if( datos.CatSAT_unidades == 1 ){
          $("input[name='catsat_unidades']").prop("checked", true);
        }else{
          $("input[name='catsat_unidades']").prop("checked", false);
        }
        // Catálogo Formas de Pago
        if( datos.CatSAT_formaspago == 1 ){
          $("input[name='catsat_formaspago']").prop("checked", true);
        }else{
          $("input[name='catsat_formaspago']").prop("checked", false);
        }
        // Catálogo de Monedas
        if( datos.CatSAT_monedas == 1 ){
          $("input[name='catsat_monedas']").prop("checked", true);
        }else{
          $("input[name='catsat_monedas']").prop("checked", false);
        }
        // Impuestos
        if( datos.CatSAT_impuestos == 1 ){
          $("input[name='catsat_impuestos']").prop("checked", true);
        }else{
          $("input[name='catsat_impuestos']").prop("checked", false);
        }
      }else{
        $("button[name='save']").attr("disabled", "disabled");
      }
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
