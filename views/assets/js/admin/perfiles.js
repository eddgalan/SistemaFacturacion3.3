$(document).ready(function () {
  var table = $('table').DataTable({
    "language":{
      "url": "../views/assets/js/datatable/Spanish.json"
    }
  });
  
  $("select[name='user']").change(function(){
    valida_selects();
  });
  $("select[name='emisor']").change(function(){
    valida_selects();
  });
});

function valida_selects(){
  var usuario = $("select[name='user']").val();
  var emisor = $("select[name='emisor']").val();
  if( usuario && emisor ){
    $("button[name='create']").removeAttr("disabled");
  }else{
    $("button[name='create']").attr("disabled","disabled");
  }
}

/* ..:: CARGA DATOS PERFIL | AJAX ::.. */
function carga_datos_perfil(id){
  var token = $("input[name='token']").val();
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../API/perfiles/get_perfil/",
    data: {"token":token, "id_perfil":id},
    success: function(resp){
      console.log(resp);
      // Obtiene los datos del servicio
      var id_perfil = resp.data.Id;
      var usuario = resp.data.UsuarioId;
      var nombre = resp.data.Nombre;
      var apellido_pat = resp.data.ApellidoPaterno;
      var apellido_mat = resp.data.ApellidoMaterno;
      var emisor = resp.data.Emisor;
      var puesto = resp.data.Puesto;
      // Setea los datos en el formulario
      $("input[name='perfil_id']").val(id_perfil);
      $("select[name='user_edit']").val(usuario);
      $("input[name='nombre_edit']").val(nombre);
      $("input[name='apellido_pat_edit']").val(apellido_pat);
      $("input[name='apellido_mat_edit']").val(apellido_mat);
      $("select[name='emisor_edit']").val(emisor);
      $("input[name='puesto_edit']").val(puesto);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
