$(document).ready(function (){
  $("select[name='impuesto']").change(function(){
    validar_form();
  });
  $("select[name='tipo_factor']").change(function(){
    validar_form();
  });
});

function validar_form(){
  var impuesto = $("select[name='impuesto']").val();
  var tipo_factor = $("select[name='tipo_factor']").val();

  if( impuesto==0 || tipo_factor==0 ){
    $("button[name='agregar']").attr("disabled","disabled");
  }else{
    $("button[name='agregar']").removeAttr("disabled");
  }

}
