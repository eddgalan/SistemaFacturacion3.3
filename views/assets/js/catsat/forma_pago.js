$(document).ready(function (){
  var table = $('table').DataTable({
    "language":{
      "url": "../views/assets/js/datatable/Spanish.json"
    }
  });
  $("select[name='formapago']").change(function(){
    var clave = $(this).val();
    if(clave != 0){
      $("button[name='agregar']").removeAttr("disabled");
    }else{
      $("button[name='agregar']").addAttr("disabled","disabled");
    }
  });
});
