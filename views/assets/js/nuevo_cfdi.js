var productos=[];

$(document).ready(function (){
  /* ..:: SELECT CLIENTE ::.. */
  $("select[name='cliente']").change(function(){
    $("select[name='uso_cfdi']").val("0");
    var token = $("input[name='token']").val();
    var id_cliente = $(this).val();

    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "../../API/catsat/get_usos_cfdi/",
      data: {"token":token, "id_cliente":id_cliente},
      success: function(resp){
        // Limpia las opciones del select
        $("select[name='uso_cfdi']").empty();
        // Obtiene los datos del servicio
        var usos_cfdi = resp.data;
        var html_option="<option value='0'>---</option>";
        for(let uso_cfdi of usos_cfdi){
          html_option+= "<option value='"+ uso_cfdi['uso_clave'] + "'>"+
            uso_cfdi['uso_clave'] + " | " + uso_cfdi['uso_concepto'] +
          "</option>";
        }
        $("select[name='uso_cfdi']").append(html_option);
      },
      error : function(xhr, status) {
        console.log(xhr);
      }
    });

  });

  /* ..:: SELECT  SERIE ::.. */
  $("select[name='serie']").change(function(){
    var token = $("input[name='token']").val();
    var serie = $(this).val();
    if (serie != ""){
      $.ajax({
        type: "POST",
        dataType: 'json',
        url: "../../API/series/get_serie_by_nom_serie",
        data: {"token":token, "nom_serie":serie},
        success: function(resp){
          // Obtiene los datos del servicio
          var serie = resp.data.TipoComprobante;
          // Setea los datos en el formulario
          $("input[name='tipo_comprobante']").val(serie);
        },
        error : function(xhr, status) {
          console.log(xhr);
        }
      });
    }
  });
  /* ..:: SELECT MONEDA ::.. */
  $("select[name='moneda']").change(function(){
    var moneda = $(this).val();
    if(moneda == "MXN"){
      $("input[name='tipo_cambio']").val("1.00");
    }
  });
  /* ..:: SELECT  PRODUCTO ::.. */
  $("select[name='producto']").change(function(){
    $("small[name='msg_ok']").addClass("display_none");
    var token = $("input[name='token']").val();
    var id = $(this).val();

    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "../../API/productos/get_producto/" + id,
      data: {"token":token},
      success: function(resp){
        // Obtiene los datos del servicio
        var id = resp.data.ProductoID;
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
        $("input[name='id_producto']").val(id);
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
        var id = $("input[name='id_producto']").val();
        var sku = $("input[name='sku']").val();
        var descripcion = $("input[name='descripcion']").val();
        var clave_prodserv = $("input[name='clave_sat']").val();
        var clave_unidad = $("input[name='unidad']").val();
        var clave_impuesto = $("input[name='impuesto']").val();
        var clave_unidad = $("input[name='clave_unidad']").val();
        var unidad = $("input[name='unidad_desc']").val();
        var clave_impuesto = $("input[name='clave_impuesto']").val();
        var impuesto_nombre = $("input[name='impuesto']").val();
        var tasa = $("input[name='tasa_impuesto']").val();

        if(clave_impuesto=="002"){
          var iva = parseFloat(tasa) * importe; // Redondear aquí
          var ieps = 0;
        }else{
          var ieps = parseFloat(tasa) * importe;  // Redondear aquí
          var iva = 0;
        }

        json_producto = {
          "id":id,
          "sku":sku,
          "clave_prodserv": clave_prodserv,
          "descripcion":descripcion,
          "unidad_nombre":unidad,
          "unidad_clave":clave_unidad,
          "precio":precio,
          "cantidad":cantidad,
          "importe": importe,
          "descuento":parseFloat(descuento),
          "iva":iva,
          "ieps":ieps,
          "impuesto_importe":parseFloat(tasa) * importe,
          "impuesto_tasa_cuota":tasa,
          "impuesto_clave":clave_impuesto,
          "impuesto_base":importe,
          "impuesto_nombre":impuesto_nombre,
          "total":importe - descuento + (parseFloat(tasa) * importe)
        }
        productos.push(json_producto);
        create_table();
        $("small[name='msg_prodserv']").addClass("display_none");
        $("small[name='msg_cant_desc']").addClass("display_none");
        $("small[name='msg_ok']").removeClass("display_none");
      }
    }else{
      $("small[name='msg_cant_desc']").removeClass("display_none");
      $("small[name='msg_ok']").addClass("display_none");
    }
  });
  /* ..:: Guarda los cambios realizados al producto ::.. */
  $("button[name='save_product']").click(function(){
    var id_producto = $("input[name='id_prod_edit']").val();
    var cantidad = $("input[name='cantidad_edit']").val();
    var descuento = $("input[name='descuento_prod_edit']").val();

    for(let producto of productos){
      if(producto.id == id_producto){
        producto.cantidad = cantidad;
        producto.importe = parseFloat(producto.precio) * parseFloat(cantidad);
        producto.descuento = descuento;

        if(producto.impuesto_clave == "002"){
          producto.iva = parseFloat(producto.impuesto_tasa_cuota) * parseFloat(producto.importe); // Redondear aquí
          producto.ieps = 0;
        }else{
          producto.ieps = parseFloat(producto.impuesto_tasa_cuota) * parseFloat(producto.importe); // Redondear aquí
          producto.iva = 0;
        }

        producto.impuesto_importe = parseFloat(producto.impuesto_tasa_cuota) * parseFloat(producto.importe);
        producto.total = producto.importe - producto.descuento + (parseFloat(producto.impuesto_tasa_cuota) * producto.importe)
        break;
      }
    }
    create_table();
  });

  /* ..:: BOTÓN GUARDAR CFDI ::.. */
  $("button[name='guardar_cfdi']").click(function(){
    // Obtiene los valores del formulario
    var cliente_id = $("select[name='cliente']").val();
    var serie = $("select[name='serie']").val();
    var fecha = $("input[name='fecha']").val();
    var hora = $("input[name='hora']").val();
    var moneda = $("select[name='moneda']").val();
    var tipo_cambio = $("input[name='tipo_cambio']").val();
    var tipo_comprobante = $("input[name='tipo_comprobante']").val();
    var condiciones_pago = $("input[name='condiciones_pago']").val();
    var metodo_pago = $("select[name='metodo_pago']").val();
    var forma_pago = $("select[name='forma_pago']").val();
    var uso_cfdi = $("select[name='uso_cfdi']").val();
    var subtotal = $("input[name='subtotal']").val();
    var iva = $("input[name='iva']").val();
    var ieps = $("input[name='ieps']").val();
    var descuento = $("input[name='descuento']").val();
    var total = $("input[name='total']").val();
    var observaciones = $("textarea[name='observaciones']").val();
    /* ..:: Valida Todos los datos del Formulario ::.. */
    if( cliente_id!="0" && cliente_id!=null && serie!="0" && serie!=null && fecha!="" && hora!="" && metodo_pago!="0" && metodo_pago!=null && forma_pago!="0" && forma_pago!=null && uso_cfdi!="0" && uso_cfdi!=null && moneda!="0" && moneda!=null && total!="" && total!="0" ){
      var json_cfdi = {
        "cliente_id":cliente_id,
        "serie":serie,
        "fecha":fecha,
        "hora":hora,
        "moneda":moneda,
        "tipo_cambio":tipo_cambio,
        "tipo_comprobante":tipo_comprobante,
        "condiciones_pago":condiciones_pago,
        "metodo_pago":metodo_pago,
        "forma_pago":forma_pago,
        "uso_cfdi":uso_cfdi,
        "subtotal":subtotal,
        "iva":iva,
        "ieps":ieps,
        "descuento":descuento,
        "total":total,
        "observaciones":observaciones,
        "prodservs":productos
      }
    console.log(json_cfdi);
    // Hace el INSERT del CFDI Nuevo
    var token = $("input[name='token']").val();
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "../../API/CFDIs/facturas/process/",
      data: {"token":token, "data":json_cfdi},
      success: function(resp){
        location.href="../../CFDIs/facturas";
      },
      error : function(xhr, status) {
        console.log(xhr);
      }
    });

    }else{
      // Muestra que campos están incorrectos
      if(cliente_id=="0" || cliente_id==null){
        $("small[name='cliente']").removeClass("display_none");
      }else{
        $("small[name='cliente']").addClass("display_none");
      }

      if(serie=="0" || serie==null){
        $("small[name='serie']").removeClass("display_none");
      }else{
        $("small[name='serie']").addClass("display_none");
      }

      if(fecha==""){
        $("small[name='fecha']").removeClass("display_none");
      }else{
        $("small[name='fecha']").addClass("display_none");
      }

      if(hora==""){
        $("small[name='hora']").removeClass("display_none");
      }else{
        $("small[name='hora']").addClass("display_none");
      }

      if(metodo_pago=="0" || metodo_pago==null){
        $("small[name='metodo_pago']").removeClass("display_none");
      }else{
        $("small[name='metodo_pago']").addClass("display_none");
      }

      if(forma_pago=="0" || forma_pago==null){
        $("small[name='forma_pago']").removeClass("display_none");
      }else{
        $("small[name='forma_pago']").addClass("display_none");
      }

      if(uso_cfdi=="0" || uso_cfdi==null){
        $("small[name='uso_cfdi']").removeClass("display_none");
      }else{
        $("small[name='uso_cfdi']").addClass("display_none");
      }

      if(moneda=="0" || moneda==null){
        $("small[name='moneda']").removeClass("display_none");
      }else{
        $("small[name='moneda']").addClass("display_none");
      }

      if(total=="" || total=="0"){
        $("small[name='msg_prodserv']").removeClass("display_none");
      }else{
        $("small[name='msg_prodserv']").addClass("display_none");
      }
    }
  });

});

function create_table(){
  $("tbody").empty();
  var subtotal=0, iva=0, ieps=0, desc=0, total=0;
  // console.log(productos);
  var tbody = "";
  for( let producto of productos ){
    var row = "<tr>"+
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
            "<button id='btnGroupDrop"+ producto.id +"' style='background-color: #4e73df !important;' type='button' class='btn btn-info btn_options text-center' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>"+
              "<i class='fas fa-ellipsis-h icon_btn_options'></i>"+
            "</button>"+
            "<div class='dropdown-menu' aria-labelledby='btnGroupDrop"+ producto.id +"'>"+
              "<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_editar_producto' onclick='carga_datos_producto("+ producto.id +")'>"+
                "<i class='fas fa-edit color_blue'></i> Editar"+
              "</a>"+
              "<a class='dropdown-item' href='#' data-toggle='modal' data-target='#modal_eliminar_producto' onclick='carga_datos_producto("+ producto.sku +")'>"+
                "<i class='fas fa-times color_red'></i> Remover"+
              "</a>"+
            "</div>"+
          "</div>"+
      "</td>"+
    "</tr>";
    tbody += row;
    /* ..:: Calcular Totales ::.. */
    subtotal += producto.importe;
    iva += producto.iva;
    ieps += producto.ieps;
    desc += parseFloat(producto.descuento);
    total = subtotal - desc + iva + ieps;
    /* ..:: Coloca los totales ::.. */
    $("input[name='subtotal']").val(subtotal);
    $("input[name='iva']").val(iva);
    $("input[name='ieps']").val(ieps);
    $("input[name='descuento']").val(desc);
    $("input[name='total']").val(total);
  }
  clear_inputs();
  $("tbody").append(tbody);
}

function clear_inputs(){
  $("select[name='producto']").val("");
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

function carga_datos_producto(id_producto){
  for (let producto of productos){
    if(producto.id == id_producto){
      // Coloca los datos en el formulario
      $("input[name='id_prod_edit']").val(producto.id);
      $("input[name='clave_sat_edit']").val(producto.clave_prodserv);
      $("input[name='unidad_edit']").val(producto.unidad_clave + " | " + producto.unidad_nombre);
      $("input[name='precio_edit']").val(producto.precio);
      $("input[name='impuesto_edit']").val(producto.impuesto_nombre);
      $("input[name='cantidad_edit']").val(producto.cantidad);
      $("input[name='descuento_prod_edit']").val(producto.descuento);
      break;
    }
  }
}
