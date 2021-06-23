<?php
  class RenderMPDF{
    private $template;
    private $css;

    function __construct($template=None){
      if($template){
        $this->template =$template;
      }
    }

    function render_template($data_emisor, $comprobantes, $mes_nom, $mes_num, $anio, $totales){
      switch($this->template){
        case 'ReporteMensual':
          $template["html"] = $this->render_reportemensual($data_emisor, $comprobantes, $mes_nom, $mes_num, $anio, $totales);
          $template['css'] = file_get_contents('libs/mpdf/templates/reportemensual/style.css');
          break;
        default:
          break;
      }
      return $template;
    }

    function render_reportemensual($emisor, $comprobantes, $mes_nom, $mes_num, $anio, $totales){
      $template = "";
      $template .= "<h1 class='back_grey'> ". $emisor['Nombre'] ." </h1>
      <div id='info'>
        <h2>Reporte mensual</h2>
        <div style='margin-left:5px;'>
          <span> RFC: </span>  <span>". $emisor['RFC'] ."</span><br>
          <span> Periodo: </span>  <span> ". $mes_nom ." | ". $anio ." </span><br>
          <span> Fecha: </span> <span> ". date("d/m/Y") ." </span><br>
        </div>
      </div>
      <div id='logo'>
        <img src='". $emisor['PathLogo'] ."'>
      </div>
      <br>
      <h2 class='text-center' style='margin-bottom:10px'>Comprobantes Generados</h2>
      <!-- COMPROBANTES GENERADOS -->
      <table id='comprobantes'>
        <tr>
          <th>Serie</th>
          <th>Folio</th>
          <th>Cliente</th>
          <th>Estatus</th>
          <th>Estatus SAT</th>
          <th>UUID</th>
          <th>Creado</th>
          <th>Total</th>
        </tr>";

      foreach( $comprobantes as $comprobante ){
        $estatus = $comprobante['Estatus'];
        switch($comprobante['Estatus']){
          case 0:
            $estatus = "Nuevo";
            break;
          case 1:
            $estatus = "Timbrado";
            break;
          case 2:
            $estatus = "Verificado";
            break;
          case 3:
            $estatus = "Cancelado";
            break;
          case 4:
            $estatus = "Cancelado";
            break;
        }
        $template .= "
        <tr>
          <td class='text-center'>". $comprobante['Serie'] ."</td>
          <td class='text-center'>". $comprobante['Folio'] ."</td>
          <td>". $comprobante['NombreCliente'] ."</td>
          <td class='text-center'>". $estatus ."</td>
          <td class='text-center'>". $comprobante['EstatusSAT'] ."</td>
          <td>". $comprobante['UUID'] ."</td>
          <td class='text-center'>". $comprobante['Fecha'] ."</td>
          <td class='text-center'>$ ". number_format( $comprobante['Total'],2,".","" ) ."</td>
        </tr>";
      }

      $template .= "
      </table>
      <!-- TOTALES -->
      <table id='totales' style='margin-top:20px; width:100%;'>
        <tr>
          <td class='text-right' style='width:86%;'>
            <h3><strong class='back_grey'>Ingresos Totales: </strong> </h3>
          </td>
          <td class='text-right' style='width:14%;'>
            <h3> $ ". number_format( $totales['IngresosTotales'],2,".","" ) ."</h3>
          </td>
        </tr>
        <tr>
          <td class='text-right'>
            <h3><strong class='back_grey'>Comprobantes nuevos (Sin Timbrar): </strong> </h3>
          </td>
          <td class='text-right'>
            <h3> ". $totales['Nuevos'] ." </h3>
          </td>
        </tr>
        <tr>
          <td class='text-right'>
            <h3><strong class='back_grey'>Comprobantes timbrados vigentes: </strong> </h3>
          </td>
          <td class='text-right'>
            <h3> ". $totales['TimbradosVerificados'] ." </h3>
          </td>
        </tr>
        <tr>
          <td class='text-right'>
            <h3><strong class='back_grey'>Comprobantes timbrados sin verificar: </strong> </h3>
          </td>
          <td class='text-right'>
            <h3> ". $totales['TimbradosNoVerificados'] ." </h3>
          </td>
        </tr>
        <tr>
          <td class='text-right'>
            <h3><strong class='back_grey'>Comprobantes cancelados: </strong> </h3>
          </td>
          <td class='text-right'>
            <h3> ". $totales['Cancelados'] ." </h3>
          </td>
        </tr>
        <tr>
          <td class='text-right'>
            <h3><strong class='back_grey'>Comprobantes cancelados sin verificar: </strong> </h3>
          </td>
          <td class='text-right'>
            <h3> ". $totales['CanceladosNoVerificados'] ." </h2>
          </td>
        </tr>
      </table>
      <hr>
      <p class='text-center' style='font-size:11px; margin-top:0px;'>
        Copyright © <strong> Sistema Facturación 3.3 </strong> 2021
      </p>";
      return $template;
    }

  }
?>
