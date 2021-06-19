$(document).ready(function (){
  var table = $('table').DataTable({
    "language":{
      "url": "../views/assets/js/datatable/Spanish.json"
    }
  });
  // Select Tipo Persona
  $("select[name='tipo_persona']").change(function(){
    if($(this).val()){
      $("button[name='send']").removeAttr("disabled");
    }else{
      $("button[name='send']").attr("disabled", "disabled");
    }
  });
});


function set_contacto_id(id_contacto){
  $("input[name='contacto_id']").val(id_contacto);
}
