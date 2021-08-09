$(document).ready(function(){
    //  Muestra/Oculta el campo para insertar el Email
    $("select[name='contacto']").change(function(){
      if( $(this).val() == 1){
        $("#div_email").slideDown();        // Muestra el input para mostrar el Email
        $("input[name='email']").val("");   // Limpia el input del Email
        $("button[name='btn_send']").attr("disabled","disabled");
      }else{
        $("#div_email").slideUp();          // Oculta el input para insertar el Email
        $("input[name='email']").val( $(this).val() );
      }
      valida();
    });

    $("input[name='email']").on('input', function(){
      valida();
    });

    $("textarea[name='msg_email']").on('input', function(){
      valida();
    });

});

function valida(){
  var email = $("input[name='email']").val();
  // Valida que el campo Email sea un Email
  if( email.indexOf('@', 0) == -1 || email.indexOf('.', 0) == -1) {
    $("button[name='btn-send']").attr("disabled","disabled");         // Desactiva el botón de envio
  }else{
    // EMail correcto | Valida el Msg
    var msg = $("textarea[name='msg_email']").val();
    if( msg.length > 0 ){
      $("button[name='btn_send']").removeAttr("disabled");            //Activa el botón de envio
    }else{
      $("button[name='btn_send']").attr("disabled", "disabled");      //Desactiva el botón de envio
    }
  }
}
