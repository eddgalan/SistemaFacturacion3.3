<?php
    Class MailGunPDO extends Connection_PDO{

      function __construct(){
        parent::__construct();
      }

      public function get_config(){
        $this->connect();
        $sql = "SELECT * FROM confmailgun";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        write_log("MailGunPDO | get_config() | SQL MailGun: \n" . $sql);
        write_log("MailGunPDO | get_config() | Información de configuración MailGUN\n" . serialize($result[0]));
        return $result[0];
      }
    }
?>
