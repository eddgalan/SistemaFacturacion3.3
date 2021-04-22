var productos=[];

$(document).ready(function (){
  /* ..:: SELECT  PRODUCTO ::.. */
  $("select[name='producto']").change(function(){
    var token = $("input[name='token']").val();
    var id = $(this).val();

    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "../../API/productos/get_producto/" + id,
      data: {"token":token},
      success: function(resp){
        // Obtiene los datos del servicio
        var id = resp.data.Id;
        var sku = resp.data.SKU;
        var descripcion = resp.data.ProductoNombre;
        var clave_sat = resp.data.ProductoClaveSAT;
        var unidad_clave = resp.data.UnidadClave;
        var unidad_nombre = resp.data.UnidadNombre;
        var precio = resp.data.ProductoPrecio;
        var impuesto_desc = resp.data.ImpuestoDesc;
        var impuesto_clave = resp.data.ImpuestoClave;
        var impuesto_tasa = resp.data.ImpuestoTasa;
        // Setea los datos en el formulario
        $("input[name='clave_sat']").val(clave_sat);
        $("input[name='unidad']").val(unidad_clave + " | " + unidad_nombre);
        $("input[name='precio']").val(precio);
        $("input[name='impuesto']").val(impuesto_desc + " | " + impuesto_tasa + "%");
        // Inputs Ocultos
        $("input[name='sku']").val(sku);
        $("input[name='descripcion']").val(descripcion);
        $("input[name='clave_unidad']").val(unidad_clave);
        $("input[name='unidad_desc']").val(unidad_nombre);
        $("input[name='clave_impuesto']").val(impuesto_clave);
        $("input[name='tasa_impuesto']").val(impuesto_tasa);

        $("button[name='add_product']").removeAttr("disabled");
      },
      error : function(xhr, status) {
        console.log(xhr);
      }
    });
  });
  /* ..:: ADD PRODUCTO ::.. */
  $("button[name='add_product']").click(function(){
    var cantidad = $("input[name='cantidad']").val();
    var descuento = parseFloat($("input[name='descuento_prod']").val());
    var precio = $("input[name='precio']").val();
    if(descuento==""){
      descuento = 0;
    }
    // Valida cantidad y descuento
    if($.isNumeric(cantidad) && cantidad > 0 && $.isNumeric(descuento) && $.isNumeric(precio)) {
      var importe = Math.round(parseFloat(cantidad) * parseFloat(precio), 4);
      // Valida importe >= descuento ¿?
      if(importe >= descuento){
        // Obtiene los datos del formulario
        var sku = $("input[name='sku']").val();
        var descripcion = $("input[name='descripcion']").val();
        var clave_prodserv = $("input[name='clave_sat']").val();
        var clave_unidad = $("input[name='unidad']").val();
        var clave_impuesto = $("input[name='impuesto']").val();
        var clave_unidad = $("input[name='clave_unidad']").val();
        var unidad = $("input[name='unidad_desc']").val();
        var impuesto = $("input[name='clave_impuesto']").val();
        var tasa = $("input[name='tasa_impuesto']").val();

        if(impuesto=="002"){
          var iva = Math.round(parseFloat(tasa) * importe, 4);
          var ieps = 0;
        }else{
          var ieps = Math.round(parseFloat(tasa) * importe, 4);
          var iva = 0;
        }

        json_producto = {
          "sku":sku,
          "descripcion":descripcion,
          "unidad_nombre":unidad,
          "unidad_clave":clave_unidad,
          "precio":precio,
          "cantidad":cantidad,
          "importe": importe,
          "descuento":descuento,
          "iva":iva,
          "ieps":ieps,
          "impuesto_importe":parseFloat(tasa) * importe,
          "impuesto_tasa_cuota":tasa,
          "impuesto_clave":impuesto,
          "impuesto_base":importe,
          "total":importe - descuento + (parseFloat(tasa) * importe)
        }
        productos.push(json_producto);
        create_table();
      }
    }else{
      console.log("NO Numeric");
    }
  });
});

function create_table(){
  var subtotal=0, iva=0, ieps=0, desc=0, total=0;

  for( let producto of productos ){
    var table_body = "<tr>"+
        "<td>" + producto.sku + "</td>"+
        "<td>" + producto.descripcion + "</td>"+
        "<td class='text-center'>"+ producto.unidad_nombre +"</td>"+
        "<td class='text-center'>$"+ producto.precio +"</td>"+
        "<td class='text-center'>"+ producto.cantidad +"</td>"+
        "<td class='text-center'>$"+ producto.importe +"</td>"+
        "<td class='text-center'>$"+ producto.descuento +"</td>"+
        "<td class='text-center'>$"+ producto.iva +"</td>"+
        "<td class='text-center'>$"+ producto.ieps +"</td>"+
        "<td class='text-center'>$"+ producto.total +"</td>"+
        "<td class='text-center'>"+
          "<div class='btn-group' role='group' aria-label='Button group with nested dropdown' style='width:100%;'>"+
            "<button id='btnGroupDrop1' style='background-color: #4e73df !important;' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
              "<i class='fas fa-ellipsis-h icon_btn_options'></i>"+
            "</button>"+
            "<div class='dropdown-menu' aria-labelledby='btnGroupDrop1'>"+
              "<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_editar_producto' onclick='carga_datos_producto("+ producto.sku +")'>"+
                "<i class='fas fa-edit color_blue'></i> Editar"+
              "</a>"+
              "<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_eliminar_producto' onclick='carga_datos_producto("+ producto.sku +")'>"+
                "<i class='fas fa-times color_red'></i> Eliminar"+
              "</a>"+
            "</div>"+
          "</div>"+
      "</td>"+
    "</tr>";
    /* ..:: Calcular Totales ::.. */
    subtotal += producto.importe;
    iva += producto.iva;
    ieps += producto.ieps;
    desc += producto.descuento;
    total = subtotal - desc + iva + ieps;
    /* ..:: Coloca los totales ::.. */
    $("input[name='subtotal']").val(subtotal);
    $("input[name='iva']").val(iva);
    $("input[name='ieps']").val(ieps);
    $("input[name='descuento']").val(desc);
    $("input[name='total']").val(total);
  }
  $("tbody").append(table_body);
  clear_inputs();
}

function clear_inputs(){
  $("input[name='clave_sat']").val("");
  $("input[name='unidad']").val("");
  $("input[name='precio']").val("");
  $("input[name='impuesto']").val("");

  $("input[name='clave_unidad']").val("");
  $("input[name='unidad_desc']").val("");
  $("input[name='clave_impuesto']").val("");
  $("input[name='tasa_impuesto']").val("");

  $("input[name='cantidad']").val("");
  $("input[name='descuento_prod']").val("");

  $("button[name='add_product']").attr("disabled","disabled");
}
