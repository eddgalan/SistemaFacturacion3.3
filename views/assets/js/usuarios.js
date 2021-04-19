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
      var id = resp.data.Id;
      var activo = resp.data.Estatus;
      var username = resp.data.Username;
      var email = resp.data.Email;
      // Setea los datos en el formulario
      $("input[name='id_usuario']").val(id);
      $("input[name='username_edit']").val(username);
      $("input[name='email_edit']").val(email);
      $("input[name='password_edit']").val("");
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
