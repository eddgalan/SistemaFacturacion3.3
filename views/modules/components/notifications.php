<?php
  $session = new UserSession();
  $notification = $session->get_notification();

  if($notification != false){
    switch ($notification['status']){
      case 'OK':
        $class_notification='alert alert-success alert-dismissible';
        $strong = "Operación realizada con éxito. ";
        break;
      case 'ERROR':
        $class_notification='alert alert-danger alert-dismissible';
        $strong = "Ocurrió un error. ";
        break;
      case 'WARNING':
        $class_notification='alert alert-warning alert-dismissible';
        $strong = "¡Advertencia!: ";
        break;
      case 'INFO':
        $class_notification='alert alert-info alert-dismissible';
        $strong = "¡Importante! : ";
        break;
    }
    $html_notification = "<div class='". $class_notification ."'>\n\t
      <button type='button' class='close' data-dismiss='alert'>&times;</button>\n
      <strong>". $strong . "</strong> ". $notification['msg'] ."\n
    </div>";
    echo $html_notification;
  }
?>
