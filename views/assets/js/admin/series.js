$(document).ready(function (){
  $("select[name='tipo_comprobante']").change(function(){
    var tpo_comprobante = $(this).val();
    if(tpo_comprobante != 0){
      $("button[name='agregar']").removeAttr("disabled");
    }else{
      $("button[name='agregar']").attr("disabled","disabled");
    }
  });
});
