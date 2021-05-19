<?php
    require 'vendor/autoload.php';
    use Mailgun\Mailgun;

    class MailerGun{
      private $apikey;
      private $apihost;
      private $domino;

      public function __construct($apikey='', $apihost='', $dominio=''){
        $this->apikey = $apikey;
        $this->apihost = $apihost;
        $this->dominio = $dominio;
      }

      public function send_cfdi($from, $to, $subject, $msg, $path_xml, $path_pdf){
        $mgClient = Mailgun::create($this->apikey, $this->apihost);
        $domain = $this->dominio;
        $params = array(
          'from'    => $from,
          'to'      => $to,
          'subject' => $subject,
          'text'    => $msg,
          'attachment' => array(
                array('filePath' => $path_xml),
                array('filePath' => $path_pdf)
          )
        );
        $response = $mgClient->messages()->send($domain, $params);
        write_log(serialize($response));
      }
    }

?>
