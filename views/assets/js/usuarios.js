$(document).ready(function () {
  $("select[name='grupos']").change(function(){
    if($(this).val()){
      $("button[name='add_group']").removeAttr("disabled");
    }
  });

  /* ..:: Agrega el usuario al Grupo del <select> ::.. */
  $("button[name='add_group']").click(function(){
    var token = $("input[name='token']").val();
    var user_id = $("input[name='id_usuario']").val();
    var group_id = $("select[name='grupos']").val();
    // AJAX que realiza el INSERT en la tabla 'grupos_usuario'
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "../API/grupos/add_grupo",
      data: {"token":token, "id_usuario":user_id, "id_grupo":group_id},
      success: function(resp){
        // console.log(resp);
        switch(resp.code){
          case 500:
            $("small[name='msg_error']").removeClass("display_none");
            break;
          case 200:
            $("small[name='msg_exist']").removeClass("display_none");
            break;
          case 201:
            $("small[name='msg_ok']").removeClass("display_none");
            break;
        }
      },
      error : function(xhr, status) {
        console.log(xhr);
      }
    });
    carga_grupos_usuario(user_id);
  });

});

/* ..:: CARGA DATOS USUARIO | AJAX ::.. */
function carga_datos_usuario(id){
  oculta_mensajes();
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
  carga_grupos_usuario(id);
}

/* ..:: CARGA LOS GRUPOS DEL USUARIO ::.. */
function carga_grupos_usuario(user_id){
  oculta_mensajes();
  var token = $("input[name='token']").val();
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../API/grupos/get_grupos_usuario",
    data: {"token":token, "id_usuario":user_id},
    success: function(resp){
      // console.log(resp.data);
      $("ul[name='group_list']").empty();
      var items_list = "";
      for(let grupo of resp.data){
        items_list += "<li class='list-group-item d-flex justify-content-between align-items-center' style='padding: 3px 10px; background-color: #DFDFDF;'>"+ grupo.Nombre +
                        "<button type='button' class='btn' onclick='remove_grupo("+ grupo.Id +", "+ grupo.IdUsuario +")'><i class='fas fa-times color_red'></i></button>"+
                      "</li>";
      }
      $("ul[name='group_list']").append(items_list);

    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}

function remove_grupo(id, id_usuario){
  var token = $("input[name='token']").val();
  $.ajax({
    type:"POST",
    dataType:"json",
    url:"../API/grupos/remove_grupo",
    data:{"token":token, "id":id},
    success:function(resp){
      // console.log(resp);
      carga_grupos_usuario(id_usuario);
      $("small[name='msg_remove']").removeClass("display_none");
    },
    error:function(xhr, status){
      console.log(xhr);
    }
  });
}

/* ..:: OCULTA TODOS LOS MENSAJES <small> ::.. */
function oculta_mensajes(){
  $("small[name='msg_error']").addClass("display_none");
  $("small[name='msg_exist']").addClass("display_none");
  $("small[name='msg_ok']").addClass("display_none");
  $("small[name='msg_remove']").addClass("display_none");
}
