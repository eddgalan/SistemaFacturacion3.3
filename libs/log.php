<?php
// Método que escribe en el archivo txt
function write_log($data_string){

  //  Validate Directory Exists
  if(!is_dir("logs")){
    //  If Directory don't Exists then Create Directory (0777 => User Permissions)
    mkdir("logs", 0777) or die('ERROR!');
  }else{
    $nombre_archivo = date("Y-m-d"). ".log";
    $file_log = fopen('logs/'. $nombre_archivo,'a');
    fwrite($file_log, "===================================================================================================================================================\n");
    fwrite($file_log, "Hora: " . date("H:i:s") . "\n");
    // fwrite($file_log, "ID Usuario: \n");
    // fwrite($file_log, "Nombre Usuario: \n");
    fwrite($file_log, $data_string . "\n");
    fclose($file_log);
  }

}

?>
