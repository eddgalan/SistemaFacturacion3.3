<?php
    Class CatSATRegimenesPDO extends Connection_PDO{

      function __construct() {
        parent::__construct();
      }

      public function get_all_regimenes(){
        $file_json = fopen('models/anexo20/c_RegimenFiscal.json','r');
        $array_regimen = json_decode(fread($file_json, filesize('models/anexo20/c_RegimenFiscal.json')),true);
        // var_dump($array_monedas);
        return $array_regimen;
      }

      public function get_regimenes_persona($tpo_persona){
        $regimenes = $this->get_all_regimenes();
        $data = array();

        if($tpo_persona == 'F'){
          foreach($regimenes as $regimen){
            if($regimen['regimen_fisica'] == "Sí"){
              array_push($data, $regimen);
            }
          }
        }elseif($tpo_persona == 'M'){
          foreach($regimenes as $regimen){
            if($regimen['regimen_moral'] == "Sí"){
              array_push($data, $regimen);
            }
          }
        }
        return $data;
      }

      public function get_all(){
        $sql = "SELECT * FROM catsatusocfdi WHERE emisor='1'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("CatSATUsoCFDI \n " . serialize($result));
        return $result;
      }
    }
?>
