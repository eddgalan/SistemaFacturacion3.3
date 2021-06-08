$(document).ready(function (){
  // Select Tipo Persona
  $("select[name='tipo_persona']").change(function(){
    if($(this).val()){
      $("button[name='send']").removeAttr("disabled");
    }else{
      $("button[name='send']").attr("disabled", "disabled");
    }
  });
});
