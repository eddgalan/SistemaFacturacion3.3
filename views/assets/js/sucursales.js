$(document).ready(function () {

});

/* ..:: CARGA DATOS DE SUCURSALES | AJAX ::.. */
function carga_datos_sucursales(id){
  var token = $("input[name='token']").val();

  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../API/sucursales/get_sucursal/" + id,
    data: {"token":token},
    success: function(resp){
      // Obtiene los datos del servicio
      // var id = resp.data['0'].Id_sucursal;
      var nombre = resp.data['0'].Nombre_sucursal;

      // Setea los datos en el formulario
      $("input[name='id_sucursal']").val(id);
      $("input[name='nombre_sucursal_editar']").val(nombre);
      
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
