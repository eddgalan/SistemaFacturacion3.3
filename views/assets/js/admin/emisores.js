$(document).ready(function (){
  var table = $('table').DataTable({
    "language":{
      "url": "../views/assets/js/datatable/Spanish.json"
    }
  });
  
  $("select[name='tipo_persona_edit']").change(function(){
    var tpo_persona = $(this).val();
    carga_regimenes(tpo_persona);
  });
});

/* ..:: CARGA DATOS REGIMENES | AJAX ::.. */
function carga_regimenes(tpo_persona){
  var token = $("input[name='token']").val();
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../API/catsat/get_regimenes",
    data: {"token":token, "tpo_persona":tpo_persona},
    success: function(resp){
      // console.log(resp);
      var options = "";
      for(let regimen of resp.data){
        options += "<option value='"+ regimen.regimen_clave +" | "+ regimen.regimen_concepto +"'>"
              + regimen.regimen_clave +" | "+ regimen.regimen_concepto + "</option>";
      }
      $("select[name='regimen_edit']").empty();
      $("select[name='regimen_edit']").append(options);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
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
