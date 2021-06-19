$(document).ready(function (){
  var table = $('table').DataTable({
    "language":{
      "url": "../views/assets/js/datatable/Spanish.json"
    }
  });
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

/* ..:: CARGA DATOS PRODUCTO/SERVICIO | AJAX ::.. */
function carga_datos(id){
  var token = $("input[name='token']").val();
  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../API/productos/get_producto",
    data: {"token":token, "id_producto":id},
    success: function(resp){
      // console.log(resp);
      // Obtiene los datos del servicio
      var id = resp.data.Id;
      var sku = resp.data.SKU;
      var nombre = resp.data.Nombre;
      var prodserv = resp.data.IdProdServ;
      var unidad = resp.data.IdUnidad;
      var precio = resp.data.Precio;
      var impuesto = resp.data.IdImpuesto;
      // Setea los datos en el formulario
      $("input[name='id_prodserv']").val(id);
      $("input[name='sku_edit']").val(sku);
      $("input[name='nombre_edit']").val(nombre);
      $("select[name='clave_prodserv_edit']").val(prodserv);
      $("select[name='clave_unidad_edit']").val(unidad);
      $("input[name='precio_edit']").val(precio);
      $("select[name='impuesto_edit']").val(impuesto);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
