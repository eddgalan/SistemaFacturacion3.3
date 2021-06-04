$(document).ready(function (){
  // Select Clave Producto/Servicio
  $("select[name='clave_prodserv']").change(function(){
    valida_selects();
  });
  // Select Unidad
  $("select[name='clave_unidad']").change(function(){
    valida_selects();
  });
  // Select Impuesto
  $("select[name='impuesto']").change(function(){
    valida_selects();
  });
});

function valida_selects(){
  var prodserv = $("select[name='clave_prodserv']").val();
  var unidad = $("select[name='clave_unidad']").val();
  var impuesto = $("select[name='impuesto']").val();
  if( prodserv == null || unidad  == null || impuesto  == null ){
    $("button[name='send']").attr("disabled", "disabled");
  }else{
    $("button[name='send']").removeAttr("disabled");
  }
}

/* ..:: CARGA DATOS EMISOR | AJAX ::.. */
function carga_datos(id){
  var token = $("input[name='token']").val();
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../API/emisores/get_emisor",
    data: {"token":token, "id_emisor":id},
    success: function(resp){
      // console.log(resp);
      // Obtiene los datos del servicio
      var id = resp.data.Id;
      var nombre = resp.data.Nombre;
      var rfc = resp.data.RFC;
      var domicilio = resp.data.Domicilio;
      var cp = resp.data.CP;
      var persona = resp.data.Persona;
      var regimen = resp.data.Regimen;
      var desc_regimen = resp.data.DescRegimen;
      var path_logo = resp.data.PathLogo;
      var pac = resp.data.PAC;
      var testing = resp.data.Testing;
      // Llena el <select> de Regimen
      carga_regimenes(persona);

      // Setea los datos en el formulario
      $("input[name='id_emisor']").val(id);
      $("input[name='nombre_edit']").val(nombre);
      $("input[name='rfc_edit']").val(rfc);
      $("input[name='domicilio_edit']").val(domicilio);
      $("input[name='codigo_postal_edit']").val(cp);
      $("select[name='tipo_persona_edit']").val(persona);
      $("select[name='regimen_edit']").val(regimen +" | "+ desc_regimen);
      $("input[name='pac_edit']").val(pac);
      $("select[name='modo_edit']").val(testing);
      $("img[name='img_logo']").attr("src", "../" + path_logo);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
