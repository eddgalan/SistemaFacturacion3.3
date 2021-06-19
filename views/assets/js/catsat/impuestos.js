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

function carga_datos(id_impuesto){
    var token = $("input[name='token']").val();

    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "../API/catsat/get_impuesto/",
      data: {"token":token, "id_impuesto":id_impuesto},
      success: function(resp){
        // Obtiene los datos del servicio
        var id = resp.data.Id;
        var clave = resp.data.ClaveImpuesto;
        var descripcion = resp.data.Descripcion;
        var estatus = resp.data.Estatus;
        var factor = resp.data.Factor;
        var tasa_cuota = resp.data.Tasa_Cuota;
        var retencion = resp.data.Retencion;
        var traslado = resp.data.Traslado;

        if(retencion == 1){
          retencion = "Si";
        }else{
          retencion = "No";
        }

        if(traslado == 1){
          traslado = "Si";
        }else{
          traslado = "No";
        }

        clave += " | "+ retencion +" | "+ traslado;

        // Setea los datos en el formulario
        $("input[name='id_impuesto']").val(id);
        $("select[name='impuesto_edit']").val(clave);
        $("input[name='descripcion_impuesto_edit']").val(descripcion);
        $("select[name='tipo_factor_edit']").val(factor);
        $("input[name='tasa_cuota_edit']").val(tasa_cuota);
      },
      error : function(xhr, status) {
        console.log(xhr);
      }
    });
}
