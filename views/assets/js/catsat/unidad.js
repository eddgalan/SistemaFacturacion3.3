$(document).ready(function (){
  $("select[name='unidad']").change(function(){
    var clave = $(this).val();
    if(clave != 0){
      $("button[name='agregar']").removeAttr("disabled");
    }else{
      $("button[name='agregar']").addAttr("disabled","disabled");
    }
  });
});
