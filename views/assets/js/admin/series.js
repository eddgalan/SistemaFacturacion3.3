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

/* ..:: CARGA DATOS SERIE | AJAX ::.. */
function carga_datos(id){
  var token = $("input[name='token']").val();

  $.ajax({
    type: "POST",
    dataType: 'json',
    url: "../API/series/get_serie",
    data: {"token":token, "serie_id":id},
    success: function(resp){
      // Obtiene los datos del servicio
      var id = resp.data.Id;
      var serie = resp.data.Serie;
      var descripcion = resp.data.Descripcion;
      var tipo_comprobante = resp.data.TipoComprobante;
      var desc_tipo_comp = resp.data.DescripcionTipoComp;
      var consecutivo = resp.data.Consecutivo;
      // Setea los datos en el formulario
      $("input[name='id_serie']").val(id);
      $("input[name='serie_edit']").val(serie);
      $("input[name='descripcion_edit']").val(descripcion);
      $("select[name='tipo_comprobante_edit']").val(tipo_comprobante +" | "+ desc_tipo_comp);
      $("input[name='consecutivo_edit']").val(consecutivo);
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}
