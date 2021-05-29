$(document).ready(function (){
  $("select[name='moneda']").change(function(){
    var clave = $(this).val();
    if(clave != 0){
      $("button[name='agregar']").removeAttr("disabled");
    }else{
      $("button[name='agregar']").attr("disabled","disabled");
    }
  });
});
