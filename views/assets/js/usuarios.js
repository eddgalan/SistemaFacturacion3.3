$(document).ready(function () {

});

/* ..:: CARGA DATOS USUARIO | AJAX ::.. */
function carga_datos_usuario(id){
  var token = $("input[name='token']").val();

  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../API/usuarios/get_usuario/" + id,
    data: {"token":token},
    success: function(resp){
      // Obtiene los datos del servicio
      var id = resp.data['0'].Id_usuario;
      var activo = resp.data['0'].Activo;
      var nombre = resp.data['0'].Nombre;
      var apellidos = resp.data['0'].Apellidos;
      var user_name = resp.data['0'].User_name;
      // Setea los datos en el formulario
      $("input[name='id_usuario']").val(id);
      $("input[name='nombre_usuario_editar']").val(nombre);
      $("input[name='apellidos_editar']").val(apellidos);
      $("input[name='user_name_editar']").val(user_name);
      $("input[name='contrasenia_editar']").val("");
      // Activa/Desactiva el check
      if(activo == "1"){
        $("input[name='user_activo']").prop("checked", true);
      }else{
        $("input[name='user_activo']").prop("checked", false);
      }
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
