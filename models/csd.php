<?php
    Class CSD_PDO extends Connection_PDO{
      private $id;
      private $estatus;
      private $emisor;
      private $nocertificado;
      private $certificado;
      private $pathcertificado;
      private $pathkey;
      private $passcer;
      private $vigencia_inicio;
      private $vigencia_fin;
      private $pathpem;

      function __construct($id='', $estatus='', $emisor='', $nocertificado='', $certificado='', $pathcertificado='',
      $pathkey='', $passcer='', $vigencia_inicio='', $vigencia_fin='', $pathpem='') {
        parent::__construct();
        $this->id = $id;
        $this->estatus = $estatus;
        $this->emisor = $emisor;
        $this->nocertificado = $nocertificado;
        $this->certificado = $certificado;
        $this->pathcertificado = $pathcertificado;
        $this->pathkey = $pathkey;
        $this->passcer = $passcer;
        $this->vigencia_inicio = $vigencia_inicio;
        $this->vigencia_fin = $vigencia_fin;
        $this->pathpem = $pathpem;
      }

      public function get_csd($emisor){
        $this->connect();
        try{
          $sql = "SELECT * FROM csd
          WHERE Emisor='$emisor'";

          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          write_log("CSD_PDO | get_csd() | SQL: " . $sql);
          $this->disconect();
          if( count($result) >= 1 ){
            write_log("CSD_PDO | get_csd() | Result: " . serialize($result[0]));
            return $result[0];
          }else{
            return false;
          }
        }catch(PDOException $e) {
          write_log("CSD_PDO | get_csd() | Error al ejecutar la consulta. ERROR: " . $e->getMessage());
          write_log("SQL: " . $sql);
          return false;
        }
      }

      public function insert_csd($emisor){
        $this->connect();
        try{
          $sql = "INSERT INTO csd (Emisor)
          VALUES ('$emisor')";
          $this->conn->exec($sql);
          write_log("CSD_PDO | insert_csd() | Se realizó el INSERT con Éxito.");
          $this->disconect();
          return true;
        }catch(PDOException $e) {
          write_log("CSD_PDO | insert_csd() | Ocurrió un error al realizar el INSERT del Emisor\nError: ". $e->getMessage());
          $this->disconect();
          return false;
        }
      }

      public function process_csdfiles($ruta_documentos, $rfc, $password, $cer_file, $key_file){
        // Generar el archivo .key.pem
        $archivo_key_pem = $ruta_documentos."".$rfc.".key.pem";
        $generar_key_pem = "openssl pkcs8 -inform DER -in $key_file -passin pass:".$password." -out ".$archivo_key_pem;
        echo "<br> $generar_key_pem";
        exec($generar_key_pem);
        // echo "<br> "; echo "<br><pre>"; print_r( $generar_key_pem ); echo "</pre><br>"; // exit;

        // Generar el archivo .cer.pem
        $archivo_cer_pem = $ruta_documentos."".$rfc.".cer.pem";
        // $generar_cer_pem = "openssl pkcs8 -inform DER -in $file_cer2 -passin pass:".$password." -out ".$archivo_cer_pem;
        $generar_cer_pem = "openssl x509 -inform DER -outform PEM -in $cer_file -pubkey > ".$archivo_cer_pem;
        echo "<br> $generar_cer_pem";
        exec($generar_cer_pem);

        // Vigencia, noCertificado, Certificado:
        $fechaInicio = "openssl x509 -in ".$archivo_cer_pem." -startdate -noout";
        echo "<br> $fechaInicio";
        $fechaInicio = exec($fechaInicio);
        // echo "<br> R= $fechaInicio";
        $fechaInicio = substr($fechaInicio,10);
        $fechaInicio = DateTime::createFromFormat("F j H:i:s Y e",$fechaInicio);
        // echo $fechaInicio;
        $fechaInicio = $fechaInicio->format("Y-m-d");

        $fechaFin = "openssl x509 -in ".$archivo_cer_pem." -enddate -noout";
        echo "<br> $fechaFin";
        $fechaFin = exec($fechaFin);
        $fechaFin = substr($fechaFin,9);
        $fechaFin = DateTime::createFromFormat("F j H:i:s Y e",$fechaFin);
        $fechaFin = $fechaFin->format("Y-m-d");

        // Serial:
        $serial = "openssl x509 -in ".$archivo_cer_pem." -serial -noout";
        // echo "<br> $fechaFin";
        $serial = exec($serial);
        $serial = substr($serial, 7);
        $nvoSerial = "";
        for($i=0;$i<strlen($serial);$i++){
          if(($i % 2)!=0){
            $nvoSerial .= $serial[$i];
          }
        }
        $noCertificado = $nvoSerial;

        // Certificado
        $cadenaSerial = "openssl x509 -in ".$archivo_cer_pem." -serial";
        $arregloResultados = array();
        exec($cadenaSerial, $arregloResultados);
        $cadenaSerial = implode("",$arregloResultados);
        $posicion = strpos($cadenaSerial, "-----BEGIN CERTIFICATE-----");
        $cadenaSerial = substr($cadenaSerial, $posicion+27);
        $cadenaSerial = substr($cadenaSerial, 0, -25);
        $cadenaSerial = str_replace("", "\n",$cadenaSerial);
        $Certificado = $cadenaSerial;
        
        return array("NoCertificado"=>$noCertificado,
          "Certificado"=>$Certificado,
          "PathKeyPem"=>$archivo_key_pem,
          "FechaInicio"=>$fechaInicio,
          "FechaFin"=>$fechaFin
        );
      }

      public function update_csd_by_emisor($emisor, $path_cer, $path_key, $pass, $path_pem, $no_certificado, $certificado, $fecha_inicio, $fecha_fin){
        $this->connect();
        try{
          $sql_update = "UPDATE csd SET NoCertificado='$no_certificado', Certificado='$certificado', PathCertificado='$path_cer',
          PathKey='$path_key', PassCer='$pass', VigenciaInicio='$fecha_inicio', VigenciaFin='$fecha_fin', PathPem='$path_pem'
          WHERE Emisor='$emisor'";
          $stmt = $this->conn->prepare($sql_update);
          $stmt->execute();

          write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e){
          write_log("Ocurrió un error al actualizar la serie. ERROR: " .$e->getMessage());
          write_log("SQL: " .$sql_update);
          $this->disconect();
          return false;
        }
        write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
        $this->disconect();
      }

      public function update_consecutivo($id, $nuevo_consecutivo){
        $this->connect();
        try{
          $sql_update = "UPDATE series SET Consecutivo='$nuevo_consecutivo' WHERE Id='$id'";
          $stmt = $this->conn->prepare($sql_update);
          $stmt->execute();

          write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
          $this->disconect();
          return true;
        }catch(PDOException $e){
          write_log("Ocurrió un error al actualizar la serie. ERROR: " .$e->getMessage());
          write_log("SQL: " .$sql_update);
          $this->disconect();
          return false;
        }
        write_log("Se actualizaron: " . $stmt->rowCount() . " registros de forma exitosa");
        $this->disconect();
      }

    }
?>
