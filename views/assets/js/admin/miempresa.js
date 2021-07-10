$(document).ready(function (){
  $("select[name='persona']").change(function(){
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
        options += "<option value='"+ regimen.regimen_clave +"'>"
              + regimen.regimen_clave +" | "+ regimen.regimen_concepto + "</option>";
      }
      $("select[name='regimen']").empty();
      $("select[name='regimen']").append(options);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
