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
      console.log(resp);
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
