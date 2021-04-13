<?php
  /* ..:: Imports Principales ::.. */
  require 'controllers/routes.php';
  require 'libs/view.php';
  include 'libs/log.php';

  $host_name = "http://localhost/SistemaFacturacion3.3";
  $site_name = "Sistema de Facturación";

  $app = new Routes($host_name, $site_name);
?>
